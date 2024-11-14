<?php
class Classe
{
    public $mysqli;

    function __construct()
    {
        require_once('Config.php');
        $this->mysqli = new mysqli(db_host, db_user, db_password, db_database);
    }

    function listclasse()
    {
        $query = 'SELECT * FROM `t_classe`';
        $result = $this->mysqli->query($query);
        return $result;
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }
}
?>