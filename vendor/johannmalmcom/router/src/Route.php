<?php

namespace Router;

class Route {
    
    public static function get($path, $callback, $guard=null) {
        $request = new Request();
        $guarding = true;
        
        if (isset($guard)) {
            $guarding = $guard();
        }
        
        if ($request->getMethod() === "get" && $request->doesPathMatch($path) && $guarding) {
            echo $callback();
        }
    }
    
    public static function post($path, $callback, $guard=null) {
        $request = new Request();
        $guarding = true;
        
        if (isset($guard)) {
            $guarding = $guard();
        }
        
        if ($request->getMethod() === "post" && $request->doesPathMatch($path) && $guarding) {
            echo $callback();
        }
    }
    
    public static function put($path, $callback, $guard=null) {
        $request = new Request();
        $guarding = true;
        
        if (isset($guard)) {
            $guarding = $guard();
        }
        
        if ($request->getMethod() === "put" && $request->doesPathMatch($path) && $guarding) {
            echo $callback();
        }
    }
    
    public static function delete($path, $callback, $guard=null) {
        $request = new Request();
        $guarding = true;
        
        if (isset($guard)) {
            $guarding = $guard();
        }
        
        if ($request->getMethod() === "delete" && $request->doesPathMatch($path) && $guarding) {
            echo $callback();
        }
    }
    
}

class Request {
    
    private $method;
    
    function __construct() {
        $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
    }
    
    public function getMethod() {
        return $this->method;
    }
    
    public function doesPathMatch($path) {
        $url = $this->cleanUrl($_SERVER["REQUEST_URI"]);
        $path = $this->cleanUrl($path);
        $pass = [];
        
        if (count($url) === count($path)) {
            foreach($path as $i => $p) {
                if ($p === $url[$i]) {
                    $pass[] = true;
                } elseif (strpos($p, ":") !== false) {
                    $pass[] = true;
                }
            }
        }
        
        return count($url) === count($pass);
    }
    
    private function cleanUrl($url) {
        $url = trim($url, "/");
        $url = explode("?", $url);
        $url = explode("/", $url[0]);
        return $url;
    }
    
}

?>