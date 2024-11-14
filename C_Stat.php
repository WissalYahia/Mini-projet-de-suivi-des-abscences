<?php
class Stat 
{
    public function Liste_abscence_etudiant_parMatiere($CodeEtudiant, $CodeMatiere, $dateDebut, $dateFin)
    {
        require_once('Config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        $req = "SELECT
                    e.nom AS nom_enseignant,
                    f.DateJour AS date_abscence,
                    s.NomSeance AS seance_abscence,
                    m.NomMatiere AS NomMatiere
                FROM
                    t_ficheabscence f
                JOIN
                    t_matiere m ON 	m.CodeMatiere = f.CodeMatiere
                JOIN
                    t_enseignant e ON f.CodeEnseignant = e.CodeEnseignant
                JOIN
                    t_ficheabscenceseance fs ON f.CodeFicheabscence = fs.CodeFicheabscence
                JOIN
                    t_seance s ON fs.CodeSeance = s.CodeSeance
                JOIN
                    t_ligneficheabscence lfa ON f.CodeFicheAbscence = lfa.CodeFicheabscence
                WHERE
                    lfa.CodeEtudiant = ? 
                    AND f.CodeMatiere = ? 
                    AND f.DateJour BETWEEN ? AND ?";

        $stmt = $mysqli->prepare($req);
        $stmt->bind_param("ssss", $CodeEtudiant, $CodeMatiere, $dateDebut, $dateFin);
        $stmt->execute();

        $result = $stmt->get_result();
        $i = 0;

        echo "<table class='table table-hover'>";
        echo "<tr><th>date</th><th>Enseignant</th><th>Seance</th></tr>";

        while ($row = $result->fetch_assoc()) {
            if ($i === 0) {
                echo "<h4>Matière : ". htmlspecialchars($row["NomMatiere"]) ."</h4>";
            }
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["date_abscence"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nom_enseignant"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["seance_abscence"]) . "</td>";
            echo "</tr>";
            $i++;
        }

        echo "</table>";
        echo "<h6>"."Le nombre total des abscences est :  "."</h6>" ."<h6>". $i . "</h6>";

        $stmt->close();
        $mysqli->close();
    }    

    public function Liste_abscence_etudiant($nomEtudiant, $prenomEtudiant, $dateDebut, $dateFin, $nomClass)
    {
        require_once('config.php');
        $mysqli = new mysqli(db_host, db_user, db_password, db_database);

        if ($mysqli->connect_error) {
            die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $req = "SELECT
                    m.NomMatiere AS nomMatiere,
                    m.CodeMatiere AS CodeMatiere,
                    COUNT(fs.CodeFicheabscence) AS nombre_abscences,
                    e.*,
                    m.*
                FROM
                    t_ficheabscence f
                JOIN
                    t_matiere m ON f.CodeMatiere = m.CodeMatiere
                JOIN
                    t_ficheabscenceseance fs ON f.CodeFicheabscence = fs.CodeFicheabscence
                JOIN
                    t_seance s ON fs.CodeSeance = s.CodeSeance
                JOIN
                    t_ligneficheabscence lfa ON f.CodeFicheabscence = lfa.CodeFicheabscence
                JOIN
                    t_etudiant e ON lfa.CodeEtudiant = e.CodeEtudiant
                JOIN
                    t_classe c ON e.CodeClasse = c.CodeClasse
                WHERE
                    e.Nom = ?
                    AND e.prenom = ?
                    AND f.DateJour BETWEEN ? AND ?
                    AND c.NomClasse = ?
                GROUP BY
                    m.NomMatiere;
        ";

        $stmt = $mysqli->prepare($req);
        $stmt->bind_param("sssss", $nomEtudiant, $prenomEtudiant, $dateDebut, $dateFin, $nomClass);
        $stmt->execute();

        $result = $stmt->get_result();

        echo "<table class='table table-hover'>";
        echo "<tr><th>Matière</th><th>Nombre d'abscences</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nomMatiere"] . "</td>";
            echo "<td><a href='Detail_abscence.php?CodeMatiere=" . urlencode($row["CodeMatiere"]) . "&CodeEtudiant=" . urlencode($row["CodeEtudiant"]) . "&dateDebut=" . urlencode($dateDebut) . "&dateFin=" . urlencode($dateFin) . "'>" . htmlspecialchars($row["nombre_abscences"]) . "</a></td>";
            echo "</tr>";
        }

        echo "</table>";

        $stmt->close();
        $mysqli->close();
    }

}
?>