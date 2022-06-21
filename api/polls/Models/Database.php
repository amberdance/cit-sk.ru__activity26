<?php

namespace RegionalPolls\Models;

use Exception;
use PDO;
use PDOStatement;
use RegionalPolls\Exceptions\DatabaseException;
use RegionalPolls\Utils\DbContext;

class Database
{

    /**
     * @var PDO|DbContext
     */
    private $dbContext;

    /**
     * @var string
     */
    private $queryString;

    /**
     * @var string
     */
    private $selectString;

    /**
     * @var string
     */
    private $filterString;

    /**
     * @var string
     */
    private $joinString;

    /**
     * @var string
     */
    private $limitString;

    /**
     * @var string
     */
    private $sortingString;

    /**
     * @var string
     */
    private $groupByString;

    /**
     * @var string
     */
    private $updateString;

    /**
     * @var string
     */
    private $insertString;

    /**
     * @var string
     */
    private $deleteString;

    /**
     * @var string
     */
    private $dbTable;

    /**
     * @var bool
     */
    private $isTransactionBegin = false;

    /**
     * @var bool
     */
    private $isSkipArgs = false;

    /**
     * @var array
     */
    private $transactions = [];

    /**
     * @var array
     */
    private $args = [];

    /**
     * @param PDO|PDOBase|null $dbContext
     */
    public function __construct($dbContext = null)
    {

        $this->dbContext = $dbContext ?? new DbContext;
    }

    /**
     * @param string $dbTable
     *
     * @return Database
     */
    public function setDbTable(string $dbTable): Database
    {

        $this->dbTable = $dbTable;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDbTable(): ?string
    {
        return $this->dbTable;
    }

    /**
     * @return string|null
     */
    public function getQueryString(): ?string
    {
        return $this->combineQuery();
    }

    /**
     * @return Database
     */
    public function skipArgs(): Database
    {
        $this->isSkipArgs = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getInsertedId(): int
    {
        return $this->dbContext->lastInsertId();
    }

    /**
     * @return void
     */
    public function purge(): void
    {

        $this->dbTable       = null;
        $this->queryString   = null;
        $this->selectString  = null;
        $this->filterString  = null;
        $this->insertString  = null;
        $this->joinString    = null;
        $this->limitString   = null;
        $this->sortingString = null;
        $this->deleteString  = null;
        $this->updateString  = null;
        $this->groupByString = null;
        $this->isSkipArgs    = false;
        $this->args          = [];
    }

    /**
     * @param string $query
     * @param array $args
     *
     * @return Database
     */
    public function customQuery(string $query, array $args = []): Database
    {

        $this->queryString = $query;
        $this->args        = $args;

        $this->runQuery();

        return $this;
    }

    /**
     * @param array $args
     * @param bool $isReturn
     *
     * @return Database|array
     */
    public function setArgs(array $args, bool $isReturn = false)
    {

        $result = &$this->args;

        if ($isReturn) {
            $result = [];
        }

        foreach ($args as $key => $value) {
            if (is_numeric(strpos($key, ":"))) {
                $result[$key] = $value;
                continue;
            } else {
                if (is_null($value)) {
                    $result[$this->getPlaceHolder($key)] = null;
                } elseif (is_bool($value) || $value == "true" || $value == "false") {
                    $result[$this->getPlaceHolder($key)] = intval((bool) $value);
                } else {
                    $result[$this->getPlaceHolder($key)] = trim(preg_replace("/(!=)|(<=)|(>=)|(%%!)|(\()\)|(!!)|(<>)/", "", $value));
                }
            }
        }

        return $isReturn ? $result : $this;
    }

    /**
     * @param string|array|null $fields
     *
     * @return Database
     */
    public function select($fields = "*"): Database
    {

        if ($fields == "*") {
            $this->selectString = "SELECT * FROM {$this->dbTable}";

            return $this;
        }

        $result = null;

        if (is_array($fields) && !empty($fields)) {

            foreach ($fields as $key => $field) {
                $key = is_string($key) ? "$key as" : '';
                $result .= "$key $field, ";
            }

            $result = trim($result, ', ');
        } elseif (is_string($fields) && !is_numeric($fields)) {
            $result = $fields;
        }

        $this->selectString = "SELECT $result FROM {$this->dbTable}";

        return $this;
    }

    /**
     * @param null|array|int $params
     *
     * @return Database
     */
    public function filter($params = null): Database
    {

        if (!$params) {
            return $this;
        }

        $this->filterString = 'WHERE ';

        if (!is_array($params)) {
            $this->filterString .= "id = :id";
            $this->setArgs([":id" => $params]);

            return $this;
        }

        if (!$this->isSkipArgs) {
            $this->setArgs($params);
        }

        $glue       = ' AND ';
        $comparsion = null;

        foreach ($params as $key => $field) {
            if (preg_match("/^[^\w\s:']+/", $field, $match)) {
                $comparsion = $this->getFilterComparsion($match[0]);

                $field = ($match[0] == "()")
                ? str_replace($match[0], "", "($field)")
                : str_replace($match[0], "", $field);
            } else {
                $comparsion = "=";
            }

            $param = $this->isSkipArgs ? $field : $this->getPlaceHolder($key);
            $this->filterString .= "$key $comparsion $param $glue";
        }

        $this->filterString = str_replace('OR AND', "OR", trim($this->filterString, "$glue"));

        return $this;
    }

    /**
     * @param null|array $params
     *
     * @return Database
     */
    public function join(array $params = null): Database
    {

        if (!$params) {
            return $this;
        }

        foreach ($params as $key => $field) {
            $this->joinString .= "LEFT JOIN $key ON $field ";
        }

        $this->joinString = " " . trim($this->joinString, 'ON ');

        return $this;
    }

    /**
     * @param array $params
     *
     * @return Database
     */
    public function sort(array $params): Database
    {

        foreach ($params as $key => $value) {
            $this->sortingString .= $key . " " . strtoupper($value) . ", ";
        }

        $this->sortingString = "ORDER BY " . trim($this->sortingString, ', ');

        return $this;
    }

    public function limit(int $count): Database
    {

        $this->limitString = "LIMIT $count";

        return $this;
    }

    /**
     * @param array|string $params
     *
     * @return Database
     */
    public function groupBy($params): Database
    {

        $this->groupByString = "GROUP BY";

        if (is_string($params)) {
            $this->groupByString .= " $params ";
        } else {
            foreach ($params as $field) {
                $this->groupByString .= " $field, ";
            }
        }

        $this->groupByString = trim($this->groupByString, ', ');

        return $this;
    }

    /**
     * @param array $params
     *
     * @return Database
     */
    public function add(array $params): Database
    {

        $fields = [];

        array_walk($params, function ($value, $key) use (&$fields) {
            $param        = $this->isSkipArgs ? $value : $this->getPlaceHolder($key);
            $fields[$key] = $param;
        });

        $keys   = implode(', ', array_keys($fields));
        $values = implode(', ', array_values($fields));

        $this->insertString = "INSERT INTO {$this->dbTable} ($keys) VALUES ($values)";

        if (!$this->isSkipArgs) {
            $this->setArgs($params);
        }

        if ($this->isTransactionBegin) {
            $this->transactions[] = [
                'query' => $this->insertString,
                'args'  => $this->setArgs($params, true),
            ];

            return $this;
        }

        $this->runQuery();

        return $this;
    }

    /**
     * @param array $params
     *
     * @return void
     */
    public function update(array $params): void
    {

        $fields = "";

        array_walk($params, function ($value, $key) use (&$fields) {
            $param = $this->isSkipArgs ? $value : $this->getPlaceHolder($key);
            $fields .= "$key =  $param, ";
        });

        $fields = trim($fields, ', ');

        $this->updateString = "UPDATE {$this->dbTable} SET $fields";

        if (!$this->isSkipArgs) {
            $this->setArgs($params);
        }

        if ($this->isTransactionBegin) {
            $this->transactions[] = [
                'query' => $this->combineQuery(),
                'args'  => array_merge($this->args, $this->setArgs($params, true)),
            ];

            return;
        }

        $this->runQuery();
    }

    /**
     * @param null $id
     * @param string|null $tables
     *
     * @return void
     */
    public function delete($id = null, string $tables = null): void
    {

        if ($id) {
            $this->queryString = "DELETE from {$this->dbTable} WHERE id = :id";
            $this->setArgs([':id' => $id]);
        } elseif ($tables) {
            $tables = trim($tables, ",");

            $this->deleteString = "DELETE $tables FROM {$this->dbTable}";
        } elseif (!$id && !$tables) {
            $this->queryString = "DELETE from {$this->dbTable}";
        }

        if ($this->isTransactionBegin) {
            $this->transactions[] = [
                'query' => $this->deleteString ?? $this->queryString,
                'args'  => $this->args,
            ];

            return;
        }

        $this->runQuery();
    }

    /**
     * @return int
     */
    public function getRowCount(): int
    {

        return $this->runQuery()->rowCount();
    }

    /**
     * @param int $mode

     * @return array|object|null
     */
    public function getRow(int $mode = PDO::FETCH_ASSOC)
    {

        $row = $this->runQuery()->fetch($mode);

        return $row === false ? null : $row;
    }

    /**
     * @param int $mode

     * @return array|null
     */
    public function getRows(int $mode = PDO::FETCH_ASSOC): ?array
    {
        $rows = $this->runQuery()->fetchAll($mode);

        return $rows === false ? null : $rows;
    }

    /**
     * @return string|null
     */
    public function getColumn(): ?string
    {

        return $this->runQuery()->fetchColumn();
    }

    /**
     * @return void
     */
    public function startTransaction(): void
    {
        $this->isTransactionBegin = true;
    }

    /**
     * @return void
     *
     * @throws DatabaseException
     */
    public function executeTransaction(): void
    {

        try {
            $this->dbContext->beginTransaction();

            foreach ($this->transactions as $transaction) {
                $statement = $this->dbContext->prepare($transaction['query']);
                $statement->execute($transaction['args']);
            }

            $this->dbContext->commit();
        } catch (Exception $e) {
            $this->dbContext->rollBack();

            throw new DatabaseException($e->getMessage());
        } finally {
            $this->isTransactionBegin = false;
            $this->purge();
        }
    }

    /**
     * @return string|null
     */
    private function combineQuery(): ?string
    {

        if ($this->insertString) {
            $this->queryString = $this->insertString;
        }

        if ($this->selectString) {
            $this->queryString = $this->selectString;
        }

        if ($this->updateString) {
            $this->queryString = $this->updateString;
        }

        if ($this->deleteString) {
            $this->queryString = $this->deleteString;
        }

        if ($this->joinString) {
            $this->queryString .= " " . $this->joinString;
        }

        if ($this->filterString) {
            $this->queryString .= " " . $this->filterString;
        }

        if ($this->groupByString) {
            $this->queryString .= " " . $this->groupByString;
        }

        if ($this->sortingString) {
            $this->queryString .= " " . $this->sortingString;
        }

        if ($this->limitString) {
            $this->queryString .= " " . $this->limitString;
        }

        return $this->queryString;
    }

    /**
     * @return PDOStatement
     */
    private function runQuery(): PDOStatement
    {

        $this->combineQuery();

        if (method_exists($this->dbContext, "execute")) {
            $statement = $this->dbContext->execute($this->queryString, $this->args);
        } else {
            $statement = $this->dbContext->prepare($this->queryString);
            $statement->execute($this->args);
        }

        $this->purge();

        return $statement;
    }

    /**
     * @param string $param
     *
     * @return string
     */
    private function getPlaceHolder(string $param): string
    {
        return ":" . preg_replace("/[\W_]/", "_$1", $param);
    }

    /**
     * Convert symbol tags to condition query statement
     *
     * @param  string $comparsion
     *
     * @return string
     */
    private function getFilterComparsion(string $comparsion): string
    {

        switch ($comparsion) {
            case '<>':
                return "BETWEEN";

            case "!!":
                return "IS NOT NULL";

            case "()":
                return "IN";

            case "!()":
                return "NOT IN";

            case "%%":
                return "LIKE";

            case "<=":
                return "<=";

            case ">=":
                return ">= ";

            case "!=":
                return "!=";

            default:
                return '';
        }
    }
}
