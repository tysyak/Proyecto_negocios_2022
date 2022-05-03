<?php

namespace Model;

class Router
{
    private array $handlers;
    private $not_found_handler;
    private const METHOD_POST = 'POST';
    private const  METHOD_GET = 'GET';

    public function get(string $path, $handler): void
    {
        $this->add_handler(self::METHOD_GET ,$path, $handler);

    }

    public function post(string $path, $handler): void
    {
        $this->add_handler(self::METHOD_POST ,$path, $handler);
    }

    private function add_handler(string $method, string $path, $handler) : void
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];
    }

    public function add_not_found_handler($handler): void
    {
        $this->not_found_handler = $handler;
    }

    public function run()
    {
        $request_uri = parse_url($_SERVER['REQUEST_URI']);
        $request_path = $request_uri['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callback = null;
        foreach ($this->handlers as $handler) {
            if ($handler['path'] == $request_path && $method == $handler['method']) {
                $callback = $handler['handler'];
            }
        }

        if (!$callback) {
            header('HTTP/1.0 404 Not Found');
            if (!empty($this->not_found_handler)) {
                $callback = $this->not_found_handler;
            }
        }

        call_user_func_array($callback, [
            array_merge($_GET, $_POST)
        ]);
    }

}