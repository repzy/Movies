<?php

class File
{
    /**
     * @param $file
     * @return array
     * Отримуємо дані з файлу. Повертаємо асоціативний масив фільмів.
     */
    public static function makeArray($file)
    {
        $arr =[];
        $name = "";
        foreach ($file as $row) {
            if (strstr($row, ": ",true) == "Release Year") {
                $name = substr(strstr($row, ": ",true), -4);
                $arr[$name] =  substr(strstr($row, ": "), 2);
            } else {
                $arr[strstr($row, ": ",true)] =  substr(strstr($row, ": "), 2);
            }
        }
        return $arr;
    }
}