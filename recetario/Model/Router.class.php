<?php

namespace Model;

class Router
{
    private array $handlers;
    private $not_found_handler;
    private const METHOD_POST = 'POST';
    private const  METHOD_GET = 'GET';
    private const VIEW_PATH = PATH.'/recetario/view/';

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

    public function render(string $view, array $data=[]): void
    {
        if ($view != 'panel') {
            $view = file_get_contents(self::VIEW_PATH . '/'.$view.'.'.'view.php');
        } else {
            $view=null;
        }
        require_once self::VIEW_PATH . '/panel.view.php';
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

        if (is_string($callback)) {
            $parts = explode('::', $callback);
            if (is_array($parts)) {
                $className = array_shift($parts);
                $handler = new $className;

                $method = array_shift($parts);
                $callback = [$handler, $method];
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