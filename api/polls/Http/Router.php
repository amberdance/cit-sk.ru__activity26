<?php

namespace RegionalPolls\Http;

use Error;
use Exception;
use RegionalPolls\Exceptions\RouterException;
use RegionalPolls\Http\Request;
use RegionalPolls\Http\Response;

class Router extends Request
{

    /**
     * @var Request
     */
    protected static $request;

    public function __construct()
    {

        Request::__construct();

        self::setHeaders();
        self::$request = $this;
        self::startMatching();
    }

    /**
     * @return void
     */
    public static function setHeaders(): void
    {

        if (stripos($_SERVER['REQUEST_URI'], 'bootstrap.php')
            || $_SERVER['REQUEST_URI'] == '/index.php'
            || $_SERVER['REQUEST_URI'] == '/') {

            Response::HttpCode(404);
        }

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            Response::header("Access-Control-Allow-Headers: DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range,x-userid,authorization");
            Response::header("Access-Control-Allow-Origin: *");
            Response::header('Access-Control-Max-Age: 86400');
            Response::header('Access-Control-Expose-Headers: Content-Length,Content-Range');
            Response::header("Accept-Encoding: gzip, compress, br");
            Response::header('Content-Language: ru');
            Response::header('Content-Type: application/json');
            Response::header('Vary: Origin, Accept-Language, Cookie');
            Response::header('X-Frame-Options: SAMEORIGIN');
            Response::header('X-Request-Id:' . createGUID());
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                Response::header("Access-Control-Allow-Methods: GET,POST,PUT,PATCH,DELETE,OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                Response::header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit;
        }
    }

    /**
     * @param string $controller
     *
     * @return void
     */
    protected static function initializeController(string $controller): void
    {

        try {
            if (!class_exists($controller)) {
                Response::HttpCode(404);
            }

            self::$request->parseParams();

            $method = self::$request->action;

            (new $controller(self::$request, self::matchModel($controller)))->$method();
        } catch (Error | Exception $e) {
            if ($_ENV['APP_DEBUG']) {
                echo json_encode([
                    "error" => $e->getMessage(),
                    "code"  => $e->getCode(),
                    "trace" => $e->getTrace(),
                ]);

                exit;
            } else {
                Response::error();
            }
        }
    }

    /**
     * @return void
     */
    private static function startMatching(): void
    {

        if (file_exists($file = __DIR__ . "./../routes.php")) {
            $routes = require $file;
        } else {
            throw new RouterException("Route file was not found at directory $file");
        }

        $match = $routes[self::$request->route];

        self::initializeController($match[1]);

    }

    /**
     * @param string $controller
     *
     * @return string
     */
    private static function matchModel(string $controller): string
    {

        try {

            $parts      = explode("\\", $controller);
            $namespance = $parts[0];

            $parts = array_slice($parts, 2);
            $model = preg_replace("/(Controller)/", "", $parts);

            unset($model[0]);

            $model = array_values($model);
            $model = "\\$namespance\\Models\\" . implode("\\", $model);

            if (!class_exists($model)) {
                throw new Error("Class '$model' was not found", 404);
            }

            return $model;
        } catch (Error $e) {
            throw new RouterException($e->getMessage(), $e->getCode());
        }
    }

}
