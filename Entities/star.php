<?php

class Star
{
    /**
     * @param $star
     * @return mixed|string
     * Отримуємо id актора за його ім'ям.
     */
    public static function getOneStar($star)
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->prepare('SELECT stars.id FROM Movie.stars WHERE stars.Name LIKE :name');
            $stmt->execute(array('name' => '%'.$star.'%'));
            $result = $stmt->fetch();

            return $result;
        } catch (PDOException $e) {
            $response = "Whoops, looks like something went wrong...<br>";

            return $response;
        }
    }

    /**
     * @param $data
     * @return array
     * Зберігаємо актора.
     */
    public static function save($data)
    {
        $db = new Db();

        $new_stars = explode(", ", $data);
        $star_ids = [];
        $stmt = $db->dbh->prepare('INSERT INTO Movie.stars (Name) VALUES (?)');
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        foreach ($new_stars as $star) {
            try {
                $name = $star;
                $stmt->execute();
                $id = $db->dbh->lastInsertId();

                $star_ids[] = $id;
            } catch (PDOException $e ) {
                $result = self::getOneStar($star);
                $star_ids[] = $result['id'];
            }
        }
        return $star_ids;
    }

    /**
     * @param $film_id
     * @param $stars_id
     * @return bool|string
     * Добавляємо акторів до фільму
     */
    public static function addStarsToFilm($film_id, $stars_id)
    {
        $db = new Db();

        $stmt = $db->dbh->prepare('INSERT INTO Movie.films_stars (films_id, stars_id) VALUES (?, ?)');
        $stmt->bindParam(1, $f_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $a_id, PDO::PARAM_INT);

        foreach ($stars_id as $star) {
            try {
                $f_id = $film_id;
                $a_id = $star;
                $stmt->execute();
            } catch (PDOException $e ){
                $response = "Whoops, looks like something went wrong...<br>";

                return $response;
            }
        }
        return true;
    }

    /**
     * @param $id
     * @return array
     * Отримуємо акторів по id фільму.
     */
    public static function getStars($id)
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->prepare('SELECT films_stars.stars_id FROM Movie.films_stars WHERE films_id = :id');
            $stmt->execute(array('id' => $id));
            $stars_id = $stmt->fetchAll();

            $stmt = $db->dbh->prepare('SELECT stars.Name FROM Movie.stars WHERE id = :id');
            $stars = [];
            foreach ($stars_id as $star) {
                $stmt->execute(array('id' => $star['stars_id']));
                $result = $stmt->fetch();
                $stars[] = $result['Name'];
            }

            return $stars;
        } catch (PDOException $e) {
            $response['error'] = "Whoops, looks like something went wrong...<br>";

            return $response;
        }

    }
}