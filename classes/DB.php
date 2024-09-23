<?php
class DB {

    private $databasePath = 'kiliometerlistesqlite.db'; // Correct SQLite database path
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
            if ($kmStop <= $kmStart){
                echo "kmStop kan ikke være mindre end kmStart";
                exit;
            }
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
    public function getlastStopKm(){
        $pdo = $this->DBCONNECT();
        $stmt = $pdo->prepare('SELECT kmSlut FROM kiliometerliste ORDER BY EntryID DESC LIMIT 1');
        $stmt->execute();
        echo $stmt->fetch(PDO::FETCH_ASSOC)["kmSlut"] ?? '';
    }
    public function getDataToSql($limit = 5, $offset = 0) {
    $pdo = $this->DBCONNECT();
    if ($pdo) {
        try {
            $statement = $pdo->prepare("SELECT * FROM kiliometerliste ORDER BY EntryID DESC LIMIT :limit OFFSET :offset");
            $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
            $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
            $statement->execute();
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

public function getTotalEntries() {
    $pdo = $this->DBCONNECT();
    if ($pdo) {
        try {
            $statement = $pdo->query("SELECT COUNT(*) as total FROM kiliometerliste");
            $result = $statement->fetch();
            return $result['total'];
        } catch (PDOException $e) {
            echo 'Query error: ' . $e->getMessage();
            return 0;
        }
    } else {
        echo 'Database connection failed';
        return 0;
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
