<?php
include "Interface/HandlerInterface.php";


class FindHandler implements HandlerInterface
{
    /**
     * @param array $data
     * @return mixed
     * Отримуємо action та передаємо валідатору. Якщо дані валідні - генеруємо назву функції, та виконуємо її.
     */
    public function handleRequest(array $data)
    {
        $validator = new Validator();

        $func = key($data['action'])."Request";

        if ($validator->validate($data)) {
            $response = $this->$func($data);

            return $response;
        } else {
            $response['error'] = "Whoops, looks like something went wrong...<br>Wrong data";

            return $response;
        }
    }

    /**
     * @param array $data
     * @return bool|string
     * Добаваляємо фільм в базу
     */
    public function addRequest(array $data)
    {
        $film_id = Movie::save($data['film']);
        $stars_id = Star::save($data['film']['Stars']);
        $result = Star::addStarsToFilm($film_id, $stars_id);

        return $result;
    }

    /**
     * @param array $data
     * @return string
     * Залежно від find_type шукаємо фільм.
     */
    public function findRequest(array $data)
    {
        if ($data['find_type'] == 'search_film') {
            $film = Movie::getOneFilmByTitle($data['request']);
            $result['film'] = $film;

            $stars = Star::getStars($film['id']);
            $result['Stars'] = $stars;

            return $result;
        } elseif ($data['find_type'] == 'search_star') {
            $star = Star::getOneStar($data['request']);
            $result['film'] = Movie::getFilmByStar($star['id']);

            return $result;
        } else {
            $response = "Whoops, looks like something went wrong...<br>";

            return $response;
        }
    }

    /**
     * @return bool
     * Завантажуємо файл, зчитуємо інформацію, та видаляємо файл.
     */
    public function fileRequest()
    {
        if ($_FILES['file']['name'] !== '') {
            $_FILES['file']['name'] = 'file';
            copy($_FILES['file']['tmp_name'], "Uploads/" . basename($_FILES['file']['name']));
        } else {
            $response['error'] = "Whoops, looks like something went wrong...<br>File does not exists";

            return $response;
        }

        if (file_exists('Uploads/file')) {
            $content = file('Uploads/file', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $films = array_chunk($content, 4);

            foreach ($films as $film) {
                try {
                    $res = File::makeArray($film);
                    $film_id = Movie::save($res);
                    $stars_id = Star::save($res['Stars']);
                    $result = Star::addStarsToFilm($film_id, $stars_id);
                } catch (Exception $e) {
                    $response['error'] = "Whoops, looks like something went wrong...<br>Please, try another file.";

                    return $response;
                }
            }
            unlink('Uploads/file');

            return true;
        } else {
            $response['error'] = "Whoops, looks like something went wrong...<br>";

            return $response;
        }
    }

    /**
     * @return array|string
     * Виводимо всі фільми
     */
    public function listRequest()
    {
        $result = Movie::getAllFilms();

        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     * Виводимо один фільм
     */
    public function showRequest(array $data)
    {

        $film_id = key($data['action']['show']);

        $film = Movie::getOneFilmById($film_id);
        $result['film'] = $film;

        $stars = Star::getStars($film['id']);
        $result['stars'] = $stars;

        return $result;
    }

    /**
     * @param array $data
     * @return bool|string
     * Видаляємо фільм
     */
    public function deleteRequest(array $data)
    {
        $id = key($data['action']['delete']);
        $result = Movie::deleteOneFilm($id);

        return $result;
    }
}