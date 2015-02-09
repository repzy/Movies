<?php

class Movie
{
    /**
     * @param $data
     * @return string
     * Добавляє фільм в базу
     */
    public static function save($data)
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->prepare('INSERT INTO Movie.films (Title, Year, Format) VALUES (:Title, :Year, :Format) ');
            $stmt->bindParam(1, $title, PDO::PARAM_STR);
            $stmt->bindParam(2, $year, PDO::PARAM_STR);
            $stmt->bindParam(3, $format, PDO::PARAM_STR);
            $stmt->execute(array_slice($data, 0, 3));

            $id = $db->dbh->lastInsertId();

            return $id;
        } catch (PDOException $e) {
            $response = "Whoops, looks like something went wrong...<br>Film with title is already exists.";

            return $response;
        }
    }

    /**
     * @return array|string
     * Повертає масив всіх фільмів
     */
    public static function getAllFilms()
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->query('SELECT films.id, films.Title FROM Movie.films ORDER BY films.Title ASC');
            $result = $stmt->fetchAll();

            return $result;
        } catch (PDOException $e) {
            $response =  "Whoops, looks like something went wrong...<br>";

            return $response;
        }
    }

    /**
     * @param $id
     * @return mixed|string
     * Повертає фільм по вказаному id
     */
    public static function getOneFilmById($id)
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->prepare('SELECT * FROM Movie.films WHERE id = :id');
            $stmt->execute(array(':id' => $id));
            $result = $stmt->fetch();

            return $result;
        } catch (PDOException $e) {
            $response =  "Whoops, looks like something went wrong...<br>We cant find film.";

            return $response;
        }
    }

    /**
     * @param $title
     * @return mixed|string
     * Повертає фільм по вказаній назві
     */
    public static function getOneFilmByTitle($title)
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->prepare('SELECT * FROM Movie.films WHERE films.Title LIKE :title');
            $stmt->execute(array(':title' => '%'.$title.'%'));
            $result = $stmt->fetch();

            return $result;
        } catch (PDOException $e) {
            $response =  "Whoops, looks like something went wrong...<br>We cant find film.";

            return $response;
        }
    }

    /**
     * @param $id
     * @return array|string
     * Повертає фільми по вказаному id актора
     */
    public static function getFilmByStar($id)
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->prepare('SELECT * FROM Movie.films_stars WHERE films_stars.stars_id = :id');
            $stmt->execute(array(':id' => $id));
            $films = $stmt->fetchAll();

            $result = [];
            $stmt = $db->dbh->prepare('SELECT * FROM Movie.films WHERE films.id = :id');
            foreach ($films as $film) {
                $stmt->execute(array(':id' => $film['films_id']));
                $result[] = $stmt->fetch();
            }

            return $result;
        } catch (PDOException $e) {
            $response =  "Whoops, looks like something went wrong...<br>We cant find film with this star";

            return $response;
        }
    }

    /**
     * @param $id
     * @return bool|string
     * Видаляє фільм з бази
     */
    public static function deleteOneFilm($id)
    {
        $db = new Db();

        try {
            $stmt = $db->dbh->prepare('DELETE FROM Movie.films WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $db->dbh->prepare('DELETE FROM films_stars WHERE films_id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            $response =  "Whoops, looks like something went wrong...<br>We cant delete this film.";

            return $response;
        }
    }
}