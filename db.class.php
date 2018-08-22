<?php

class DB
{
    private $host;
    private $login;
    private $password;
    private $db_name;
    private $db;

    public function __construct() {
        $config = require('config.php');
        $this->host = $config['db']['host'];
        $this->login = $config['db']['login'];
        $this->password = $config['db']['password'];
        $this->db_name = $config['db']['db_name'];
        $this->db = new mysqli($this->host, $this->login, $this->password, $this->db_name);

        if (mysqli_connect_errno()) {
            printf("Подключение к серверу MySQL невозможно. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
    }

    public function getDb(){
        return $this->db;
    }

}
?>