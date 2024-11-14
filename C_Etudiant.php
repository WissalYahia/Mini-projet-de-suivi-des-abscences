<?php
class Etudiant
{
    public $CodeEtudiant;
    public $Nom;
    public $Prenom;
    public $DateNaissance;
    public $CodeClasse;
    public $NumInscription;
    public $Adresse;
    public $Mail;
    public $Tel;

    function __construct( $Nom, $Prenom, $DateNaissance, $CodeClasse, $NumInscription, $Adresse, $Mail, $Tel)
    {
       
        $this->Nom = $Nom;
        $this->Prenom = $Prenom;
        $this->DateNaissance = $DateNaissance;
        $this->CodeClasse = $CodeClasse;
        $this->NumInscription = $NumInscription;
        $this->Adresse = $Adresse;
        $this->Mail = $Mail;
        $this->Tel = $Tel;
    }

    public function createEtudiant()
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("INSERT INTO `t_etudiant` (CodeEtudiant, Nom, Prenom, DateNaissance, CodeClasse, NumInscription, Adresse, Mail, Telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssss", $this->CodeEtudiant, $this->Nom, $this->Prenom, $this->DateNaissance, $this->CodeClasse, $this->NumInscription, $this->Adresse, $this->Mail, $this->Tel);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }
    
    public function readEtudiantList()
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $students = array();

        $result = $mysqli->query("SELECT * FROM `t_etudiant`");

        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }

        $result->close();
        $mysqli->close();

        return $students;
    }
    public function deleteEtudiant($id)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("DELETE FROM `t_etudiant` WHERE CodeEtudiant = ?");

        $stmt->bind_param("s", $id);

        $result = $stmt->execute();

        if (!$result) {
            throw new Exception("Error: " . $stmt->error);
        }

        $stmt->close();
        $mysqli->close();
    }

    public function getEtudiantById($id)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("SELECT * FROM `t_etudiant` WHERE CodeEtudiant = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        $student = $result->fetch_assoc();

        $stmt->close();
        $mysqli->close();

        return $student;
    }

    public function updateEtudiant($id,$Nom, $Prenom, $DateNaissance, $CodeClasse, $NumInscription, $Adresse, $Mail, $Tel)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $stmt = $mysqli->prepare("UPDATE `t_etudiant` SET Nom=?, Prenom=?, DateNaissance=?, CodeClasse=?, NumInscription=?, Adresse=?, Mail=?, Telephone=? WHERE CodeEtudiant=?");

        $stmt->bind_param("sssssssss", $Nom, $Prenom, $DateNaissance, $CodeClasse, $NumInscription, $Adresse, $Mail, $Tel, $id);

        $result = $stmt->execute();

        $stmt->close();
        $mysqli->close();
    }

    public function markEtudiantAbsent($CodeEtudiant, $matiereId, $enseignantId, $seanceId, $classId, $dateJour) {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);
    
        $mysqli->begin_transaction();
    
        try {
            $queryFicheAbsence = "INSERT INTO t_ficheabscence (CodeMatiere, CodeEnseignant, CodeClasse, DateJour) VALUES (?,?, ?, ?)";
            $stmtFicheAbsence = $mysqli->prepare($queryFicheAbsence);
            $stmtFicheAbsence->bind_param("ssss",$matiereId, $enseignantId, $classId, $dateJour);
            $stmtFicheAbsence->execute();
    
            $ficheAbsenceId = $stmtFicheAbsence->insert_id;
    
            $queryFicheAbsenceSeance = "INSERT INTO t_ficheabscenceseance (CodeFicheAbscence, CodeSeance) VALUES (?, ?)";
            $stmtFicheAbsenceSeance = $mysqli->prepare($queryFicheAbsenceSeance);
            $stmtFicheAbsenceSeance->bind_param("ss", $ficheAbsenceId, $seanceId);
            $stmtFicheAbsenceSeance->execute();
    
            $queryLigneFicheAbsence = "INSERT INTO t_ligneficheabscence (CodeFicheAbscence, CodeEtudiant ) VALUES (?, ?)";
            $stmtLigneFicheAbsence = $mysqli->prepare($queryLigneFicheAbsence);
            $stmtLigneFicheAbsence->bind_param("ss", $ficheAbsenceId, $CodeEtudiant);
            $stmtLigneFicheAbsence->execute();
    
            $stmtFicheAbsence->close();
            $stmtFicheAbsenceSeance->close();
            $stmtLigneFicheAbsence->close();
    
            $mysqli->commit();
        } catch (Exception $e) {
            $mysqli->rollback();
            echo "Error: " . $e->getMessage();
        } finally {
            $mysqli->close();
        }
    }
}
?>