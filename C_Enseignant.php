<?php
class Enseignant
{
    public $CodeEnseignant;
    public $Nom;
    public $Prenom;
    public $DateRecrutement;
    public $Adresse;
    public $Mail;
    public $Tel;
    public $CodeDepartement;
    public $CodeGrade;

    function __construct($CodeEnseignant , $Nom , $Prenom , $DateRecrutement , $Adresse , $Mail , $Tel , $CodeDepartement , $CodeGrade )
    {
        $this->CodeEnseignant = $CodeEnseignant;
        $this->Nom = $Nom;
        $this->Prenom = $Prenom;
        $this->DateRecrutement = $DateRecrutement;
        $this->Adresse = $Adresse;
        $this->Mail = $Mail;
        $this->Tel = $Tel;
        $this->CodeDepartement = $CodeDepartement;
        $this->CodeGrade = $CodeGrade;
    }

    public function createEnseignant()
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("INSERT INTO `t_enseignant` (CodeEnseignant, Nom, Prenom, DateRecrutement, Adresse, Mail, 	Tel, CodeDepartement , 	CodeGrade ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssss", $this->CodeEnseignant , $this->Nom, $this->Prenom, $this->DateRecrutement, $this->Adresse, $this->Mail, $this->Tel, $this->CodeDepartement, $this->CodeGrade);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }

    public function readEnseignantList()
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $teachers = array();

        $result = $mysqli->query("SELECT * FROM `t_enseignant`");

        while ($row = $result->fetch_assoc()) {
            $teachers[] = $row;
        }

        $result->close();
        $mysqli->close();

        return $teachers;
    }

    public function deleteEnseignant($id)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("DELETE FROM `t_enseignant` WHERE CodeEnseignant = ?");

        $stmt->bind_param("s", $id);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }

    public function getEnseignantById($id)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);


        $stmt = $mysqli->prepare("SELECT * FROM `t_enseignant` WHERE CodeEnseignant = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        $student = $result->fetch_assoc();

        $stmt->close();
        $mysqli->close();

        return $student;
    }

    public function updateEnseignant($id, $Nom, $Prenom, $DateRecrutement, $Adresse, $Mail, $Tel, $CodeDepartement, $CodeGrade)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("UPDATE `t_enseignant` SET Nom=?, Prenom=?, DateRecrutement=?, Adresse=?, Mail=?, Tel=?,CodeDepartement=?, CodeGrade=? WHERE CodeEnseignant=?");

        $stmt->bind_param("sssssssss", $Nom, $Prenom, $DateRecrutement, $Adresse, $Mail, $Tel, $CodeDepartement, $CodeGrade, $id);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }

}
?>
