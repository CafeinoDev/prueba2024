<?php

declare(strict_types=1);

namespace LG\Interfaces\App;

class Utils
{
    /**
     * @param string $url
     * @param array $routes
     * @param array $params
     * @return string|null
     */
    public static function matchRoute(string $url, array $routes, array $params = []): mixed
    {
        $url = array_values(array_filter(explode('/', $url)));
        foreach ($routes as $route) {
            $route = array_values(array_filter(explode('/', $route)));

            if (count($route) === count($url)) {
                $arrLength = count($url);
                $endpoint = '/' . implode('/', $route);

                for ($i = 0; $i < $arrLength; $i++) {
                    if ($url[$i] == $route[$i]) {
                        unset($url[$i]);
                        unset($route[$i]);
                    }
                }

                foreach($url as $key => $param) {
                    if(str_contains($route[$key], '{') && str_contains($route[$key], '}')) {
                        $paramKey = str_replace(['{', '}'], '', $route[$key]);
                        $params[$paramKey] = $param;
                    }
                }

                if(count($params))
                    return [$endpoint, $params];
            }
        }

        return null;
    }

    /**
     * @param array $arr
     * @param string $key
     * @param array $params
     * @return mixed
     */
    public static function dataGet(array $arr, string $key): mixed
    {
        if (empty($key)) {
            return null;
        }

        $keysArr = explode(".", $key);
        $searchedKey = $keysArr[count($keysArr) - 1];

        $routesArr = [];

        foreach($arr as $routes) {
            foreach($routes as $endpoint => $method) {
                array_push($routesArr, $endpoint);
            }
        }

        list($endpoint, $params) = self::matchRoute($keysArr[1], $routesArr);

        $i = 0;

        if($endpoint) {
            foreach($arr as $httpMethod => $routes) {
                foreach($routes as $key => $method) {
                    if($key === $endpoint && $httpMethod === $keysArr[0]) {
                        return [$method, $params];
                    }
                }
            }
        }

        if(array_key_exists($keysArr[$i], $arr)) {

            $nextArr = $arr[$keysArr[$i]];

            while($i < count($keysArr)) {

                $i++;

                if(!array_key_exists($keysArr[$i], $nextArr)) break;

                if($keysArr[$i] === $searchedKey) return [$nextArr[$keysArr[$i]], $params];

                $nextArr = $nextArr[$keysArr[$i]];
            }
        }

        return null;
    }

    /**
     * @param $path
     * @return string
     */
    public static function basePath($path): string
    {
        return BASE_PATH . $path;
    }


    /**
     * @param $message
     * @param $code
     * @return void
     */
    public static function abort($message, $code = 404): void
    {
        http_response_code($code);
        echo $message;
        exit();
    }
}
