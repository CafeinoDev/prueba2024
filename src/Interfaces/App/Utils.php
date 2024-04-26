<?php

declare(strict_types=1);

namespace LG\Interfaces\App;

class Utils
{
    /**
     * @param array $arr
     * @param string $key
     * @return mixed|null
     */
    public static function dataGet(array $arr, string $key): mixed
    {

        if (empty($key)) {
            return null;
        }

        $keysArr = explode(".", $key);
        $searchedKey = $keysArr[count($keysArr) - 1];

        $i = 0;

        if(array_key_exists($keysArr[$i], $arr)) {

            $nextArr = $arr[$keysArr[$i]];

            while($i < count($keysArr)) {

                $i++;

                if(!array_key_exists($keysArr[$i], $nextArr)) break;

                if($keysArr[$i] === $searchedKey) return $nextArr[$keysArr[$i]];

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
