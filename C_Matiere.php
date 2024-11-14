<?php
class Matiere
{
    public $CodeMatiere;
    public $NomMatiere;
    public $NbreHeureCoursParSemaine;
    public $NbreHeureTDParSemaine;
    public $NbreHeureTPParSemaine;

    function __construct($CodeMatiere , $NomMatiere , $NbreHeureCoursParSemaine , $NbreHeureTDParSemaine , $NbreHeureTPParSemaine)
    {
        $this->CodeMatiere = $CodeMatiere;
        $this->NomMatiere = $NomMatiere;
        $this->NbreHeureCoursParSemaine = $NbreHeureCoursParSemaine;
        $this->NbreHeureTDParSemaine = $NbreHeureTDParSemaine;
        $this->NbreHeureTPParSemaine = $NbreHeureTPParSemaine;
    }

    public function createMatiere()
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("INSERT INTO `t_matiere` (CodeMatiere, NomMatiere, NbreHeureCoursParSemaine, NbreHeureTDParSemaine, NbreHeureTPParSemaine) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("sssss", $this->CodeMatiere , $this->NomMatiere, $this->NbreHeureCoursParSemaine, $this->NbreHeureTDParSemaine, $this->NbreHeureTPParSemaine);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }

    public function readMatiereList()
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $teachers = array();

        $result = $mysqli->query("SELECT * FROM `t_matiere`");

        while ($row = $result->fetch_assoc()) {
            $teachers[] = $row;
        }

        $result->close();
        $mysqli->close();

        return $teachers;
    }

    public function deleteMatiere($id)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("DELETE FROM `t_matiere` WHERE CodeMatiere = ?");

        $stmt->bind_param("s", $id);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }

    public function getMatiereById($id)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("SELECT * FROM `t_matiere` WHERE CodeMatiere = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result();


        $student = $result->fetch_assoc();

        $stmt->close();
        $mysqli->close();

        return $student;
    }

    public function updateMatiere($id, $NomMatiere, $NbreHeureCoursParSemaine, $NbreHeureTDParSemaine, $NbreHeureTPParSemaine)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("UPDATE `t_matiere` SET NomMatiere=?, NbreHeureCoursParSemaine=?, NbreHeureTDParSemaine=?, NbreHeureTPParSemaine=? WHERE CodeMatiere=?");

        $stmt->bind_param("sssss", $NomMatiere, $NbreHeureCoursParSemaine, $NbreHeureTDParSemaine, $NbreHeureTPParSemaine, $id);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }
}
?>
