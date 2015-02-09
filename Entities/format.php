<?php

class Format
{
    /**
     * @return array
     * Виведеня всіх форматів
     */
    public static function getAllFormats()
    {
        $db = new Db();
        $stmt = $db->dbh->query('SELECT * FROM Movie.formats');
        return $stmt->fetchAll();
    }
}