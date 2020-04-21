<?php

namespace app\core;

class View
{

    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route =  $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($title, $vars = [])
    {
        extract($vars);
        $path = 'app/views/'.$this->path.'.php';
        if (file_exists($path)) {
            ob_start();
            include $path;
            $content = ob_get_clean();
            include 'app/views/layouts/'.$this->layout.'.php';
        }
    }

    // Redirect with PHP
    public function redirect($url)
    {
        header('location: '.$url);
        exit;
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'app/views/errors/'.$code.'.php';
        if (file_exists($path)) {
            include $path;
        }
        exit;
    }

    // Display status message
    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    // Redirect to page after submit
    public function location($url)
    {
        exit(json_encode(['url' => $url]));
    }
}