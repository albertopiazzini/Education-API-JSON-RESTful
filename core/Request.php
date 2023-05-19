<?php

class Request {

    

    function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    function getPath() {
        
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url, PHP_URL_PATH);
        $base_path = substr($path, strpos($path, 'index.php/') + strlen('index.php/'));
        return $base_path; 

    }

    function getBody() {
       return json_decode(file_get_contents('php://input'), true);
    }



    function getQueryParams() {
        $queryParams = array();
        $queryStr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        if ($queryStr){
            parse_str($queryStr,$queryParams);
        }
        
        
        return $queryParams;
    }

}