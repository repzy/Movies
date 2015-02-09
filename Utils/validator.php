<?php

class Validator
{
    /**
     * @param $data
     * @return mixed
     * Отримуємо action та виконуємо функцію
     */
    public function validate($data)
    {
        $func = key($data['action'])."Validate";
        $response = $this->$func($data);

        return $response;
    }

    /**
     * @param array $data
     * @return bool
     * Перевірка полів форми додавання фільмів
     */
    public function addValidate(array $data)
    {
        if (
            strlen($data['film']['Title']) > 3 &&
            is_numeric($data['film']['Year']) &&
            strlen($data['film']['Year']) == 4 &&
            strlen($data['film']['Stars']) > 2
            )  {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $data
     * @return bool
     * Перевірка форми пошуку фільмів
     */
    public function findValidate(array $data)
    {
        if (
            strlen($data['request']) >= 3 &&
            ($data['find_type'] == 'search_star' ||
            $data['find_type'] == 'search_film')
        )  {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * Перевірка файлу
     */
    public function fileValidate()
    {
        if (
            strlen($_FILES['file']['name']) > 0 &&
            $_FILES['file']['size'] > 0
        )  {
            return true;
        } else {
            return false;
        }
    }

    public function listValidate()
    {
        return true;
    }

    public function deleteValidate()
    {
        return true;
    }

    public function showValidate()
    {
        return true;
    }
}