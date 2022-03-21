<?php 
require_once "./.env";
class Database{
    public function openDbConnection()
    {
        $host = getenv('HOST');
        $user = getenv('DATA_BASE_USER');
        $password = getenv('DATA_BASE_PASSWORD');
        $dbname = getenv("DATA_BASE_NAME");
        $link = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        return $link;
    }

    public function closeDbConnection(&$link)
    {
        $link = null;
    }
}