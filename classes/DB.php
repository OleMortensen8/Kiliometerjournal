<?php
class DB {

    private $databasePath = '/opt/htdocs/KiliometerJournal-i-PHP/kiliometerlistesqlite.db'; // Correct SQLite database path
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );

    public function DBCONNECT() {
        try {
            $pdo = new PDO('sqlite:' . $this->databasePath, null, null, $this->options);
            return $pdo;
        } catch (Exception $e) {
            echo 'Connection error: ' . $e->getMessage();
            return null; // Returning null instead of the error message string
        }
    }

    public function sendsDataToSql($ini, $kmStart, $kmStop, $samledetal) {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            $statement = $pdo->prepare("INSERT INTO kiliometerliste (initialer, kmStart, kmSlut, samledeKmTal) VALUES (?, ?, ?, ?)");
            $statement->bindParam(1, $ini, PDO::PARAM_STR);
            $statement->bindParam(2, $kmStart, PDO::PARAM_INT);
            $statement->bindParam(3, $kmStop, PDO::PARAM_INT);
            $statement->bindParam(4, $samledetal, PDO::PARAM_INT);
            $statement->execute();
            header("Location: features.php");
        } else {
            echo 'Database connection failed';
        }
    }

    public function getDataToSql() {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            try {
                $statement = $pdo->query("SELECT * FROM kiliometerliste ORDER BY EntryID DESC LIMIT 5");
                return $statement->fetchAll();
            } catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                return [];
            }
        } else {
            echo 'Database connection failed';
            return [];
        }
    }

    public function deleteEntry($id) {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            try {
                $statement = $pdo->prepare("DELETE FROM kiliometerliste WHERE EntryID=:id");
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();
            } catch (PDOException $e) {
                echo 'Delete error: ' . $e->getMessage();
            }
        } else {
            echo 'Database connection failed';
        }
    }
}
?>
