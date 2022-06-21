<?php

namespace RegionalPolls\Utils;

use PDO;
use PDOException;
use PDOStatement;
use RegionalPolls\Exceptions\DatabaseException;

/**
 * PDO Wrapper
 */
final class DbContext
{

    /**
     * @var PDO
     */
    private static $dbConnection;

    public function __construct()
    {
        self::createConnection();

    }

    /**
     * @return PDO
     */
    public static function createConnection(): PDO
    {

        try {
            if (self::$dbConnection instanceof PDO) {
                return self::$dbConnection;
            }

            self::$dbConnection = new PDO("{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            self::$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return self::$dbConnection;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * @param string $query
     * @param array|null $params
     *
     * @return PDOStatement
     */
    public static function execute(string $query, ?array $params = null): PDOStatement
    {

        try {
            $statement = self::$dbConnection->prepare($query);
            $statement->execute($params);

            return $statement;
        } catch (PDOException $e) {
            if (strripos($e->getMessage(), "only_full_group_by")) {
                self::execute("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
                $statement->execute();

                return $statement;
            }

            if (strripos($e->getMessage(), 'Duplicate entry')) {
                throw new DatabaseException('Duplicate entry', 102);
            }

            if (strripos($e->getMessage(), 'Data too long')) {
                throw new DatabaseException('Data too long', 111);
            }

            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * @return int
     */
    public static function lastInsertId(): int
    {
        try {
            return self::$dbConnection->lastInsertId();
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    /**
     * @return bool
     */
    public static function beginTransaction(): bool
    {
        try {
            return self::$dbConnection->beginTransaction();
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param string $query
     *
     * @return PDOStatement|false
     */
    public static function prepare(string $query): PDOStatement
    {
        try {
            return self::$dbConnection->prepare($query);
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return bool
     */
    public static function commit(): bool
    {
        try {
            return self::$dbConnection->commit();
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return bool
     */
    public static function rollBack(): bool
    {
        try {
            return self::$dbConnection->rollBack();
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

}
