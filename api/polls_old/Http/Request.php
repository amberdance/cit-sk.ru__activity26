<?php

namespace RegionalPolls\Http;

use RegionalPolls\Utils\CaseHelper;

class Request
{

    /**
     * @var string
     */
    public $action;

    /**
     * @var string
     */
    public $route;

    /**
     * @var string
     */
    public $httpMethod;

    /**
     * @var string|int|null
     */
    public $id;

    /**
     * @var null|array
     */
    public $params;

    /**
     * @var array
     */
    private $urlFragments;

    public function __construct()
    {

        $this->parseUrl();

    }

    /**
     * @param array|null $inputData
     * @param string $case
     *
     * @return array
     */
    public static function getFormattedParams(?array $inputData = null, string $case = 'snake'): array
    {

        $inputData = $inputData ?? $_POST ?? $_GET;

        if (!$inputData) {
            return [];
        }

        if ($case == 'snake') {
            return CaseHelper::keysToSnakeCase($inputData);
        }

        if ($case == 'camel') {
            return CaseHelper::keysToCamelCase($inputData);
        }
    }

    /**
     * @return void
     */
    protected function parseUrl(): void
    {

        if ($_SERVER['REQUEST_URI'] == $_ENV['ROUTE_PREFIX']) {
            Response::HttpCode(404);
        }

        $this->httpMethod   = $_SERVER['REQUEST_METHOD'];
        $this->route        = str_replace($_ENV['ROUTE_PREFIX'], '/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->urlFragments = array_values(array_diff(explode('/', $this->route), ['']));

        $lastUrlFragmenIndex = array_key_last($this->urlFragments);
        $lastUrlFragment     = $this->urlFragments[$lastUrlFragmenIndex];

        if (in_array($this->httpMethod, ['DELETE', 'PUT', 'PATCH'])
            || ($this->httpMethod == 'GET' && (is_numeric($lastUrlFragment) || isGUID($lastUrlFragment)))) {

            $this->id = $lastUrlFragment;

            unset($this->urlFragments[$lastUrlFragmenIndex]);

            $this->route = "/" . implode('/', $this->urlFragments);
        }

        $this->action = $this->urlFragments[array_key_last($this->urlFragments)];
    }

    /**
     * @return void
     */
    protected function parseParams(): void
    {

        if (empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
        }

        $this->params = $this->getFormattedParams();

        if (isset($this->params['id']) && in_array($this->httpMethod, ['GET', 'POST'])) {
            $this->id = $this->params['id'];
            unset($this->params['id']);
        }
    }
}
