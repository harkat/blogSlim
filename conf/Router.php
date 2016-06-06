<?php

namespace conf;

use Slim\Slim;
use Symfony\Component\Yaml\Yaml;

class Router {

    // Attributes

    private $app;
    private $routingFilesPath;
    private $controllersNamespace;

    // Constructor

    public function __construct(Slim $app, $routesPath, $controllersNamespace) {
        $this->app = $app;
        $this->routingFilesPath = $routesPath;
        $this->controllersNamespace = $controllersNamespace;
    }

    // Meta-routing method

    public function parseRoutes() {
        $filesList = scandir($this->routingFilesPath);
        $routingFiles = array();

        foreach($filesList as $file) {
            if(preg_match('#.yml$#', $file))
                $routingFiles[] = Yaml::parse(file_get_contents($this->routingFilesPath .
								DIRECTORY_SEPARATOR .
								$file));
        }

        foreach($routingFiles as $file) {
            foreach($file as $routeName => $routeRules) {
                $this->app->{$routeRules['method']}($routeRules['url'], function() use ($routeRules) {
                    $args = func_get_args();
                    $controller = $this->controllersNamespace . '\\' . $routeRules['controller'];
                    $c = new $controller();

                    if(count($args) > 0)
                        call_user_func_array(array($c, $routeRules['action']), $args);
                    else
                        $c->{$routeRules['action']}();

                })->name($routeName);
            }
        }
    }
}
