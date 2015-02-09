<?php

class Db
{
    public $dbh;

    public $dns;

    public $user;

    public $pass;

    public function __construct()
    {
        $this->dns = "mysql:host=localhost;dbname=Movie";
        $this->user = "root";
        $this->pass = "root";
        $this->dbh = new PDO($this->dns, $this->user, $this->pass);
        $this->dbh->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
        $this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
}