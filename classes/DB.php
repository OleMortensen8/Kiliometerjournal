<?php /** @noinspection ALL */

class DB {
    private float $fuelConsumptionRate = 4.20168; // liters per 100 km
    private string $databasePath = 'kiliometerliste.db'; // Correct SQLite database path
    private array $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );

    public int $full_tank_capacity = 45; // Assuming 45 liters as the full tank capacity
    public function DBCONNECT(): ?PDO
    {
        try {
            return new PDO('sqlite:' . $this->databasePath, null, null, $this->options);
        } catch (Exception $e) {
            echo 'Connection error: ' . $e->getMessage();
            return null; // Returning null instead of the error message string
        }
    }

    public function sendsDataToSql($ini, $kmStart, $kmStop, $samledetal, $fuelRemaining): void
    {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            if ($kmStop <= $kmStart){
                echo "kmStop kan ikke være mindre end kmStart";
                exit;
            }
            $statement = $pdo->prepare("INSERT INTO kiliometerliste (Initialer, KmStart, KmSlut, SamledeKmTal, FuelRemaining) VALUES (?, ?, ?, ?, ?)");
            $statement->bindParam(1, $ini, PDO::PARAM_STR);
            $statement->bindParam(2, $kmStart, PDO::PARAM_INT);
            $statement->bindParam(3, $kmStop, PDO::PARAM_INT);
            $statement->bindParam(4, $samledetal, PDO::PARAM_INT);
            $statement->bindParam(5, $fuelRemaining);
            $statement->execute();
            header("Location: features.php");
        } else {
            echo 'Database connection failed';
        }
    }

    public function getlastStopKm(): void
    {
        $pdo = $this->DBCONNECT();
        $stmt = $pdo->prepare('SELECT kmSlut FROM kiliometerliste ORDER BY EntryID DESC LIMIT 1');
        $stmt->execute();
        echo $stmt->fetch(PDO::FETCH_ASSOC)["KmSlut"] ?? '';
    }

    public function getDataToSql($limit = 5, $offset = 0): array
    {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            try {
                $username = $_SESSION['username']; // Get the current user's username from the session
                $statement = $pdo->prepare("SELECT * FROM kiliometerliste WHERE Initialer = :username ORDER BY EntryID DESC LIMIT :limit OFFSET :offset");
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
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

    public function deleteEntry($id): void
    {
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

    public function getTotalEntries(): int
    {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            try {
                $username = $_SESSION['username']; // Get the current user's username from the session
                $statement = $pdo->prepare("SELECT COUNT(*) as total FROM kiliometerliste WHERE Initialer = :username");
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->execute();
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


    public function getLastEntry()
    {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            try {
                $statement = $pdo->query("SELECT * FROM kiliometerliste ORDER BY EntryID DESC LIMIT 1");
                return $statement->fetch();
            } catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                return null;
            }
        } else {
            echo 'Database connection failed';
            return null;
        }
    }

    public function getFuelConsumptionRate(): float
    {
        return $this->fuelConsumptionRate;
    }

    public function calculateFuelUsed($kmDriven): float
    {
        $fuelUsed = ($kmDriven / 100) * $this->getfuelConsumptionRate();
        return round($fuelUsed, 2); // Round to one decimal place
    }

    public function calculateSubtractedLiters($newFuelRemaining): float
    {
        $lastEntry = $this->getLastEntry();
        $lastFuelRemaining = $lastEntry ? $lastEntry['FuelRemaining'] : self::FULL_TANK_CAPACITY;
        return $lastFuelRemaining - $newFuelRemaining;
    }

    public function getTotalPerMonth(): array
    {
        $pdo = $this->DBCONNECT();
        if ($pdo) {
            try {
                $username = $_SESSION['username']; // Get the current user's username from the session
                $statement = $pdo->prepare("SELECT strftime('%m', Dato) as month, SUM(SamledeKmTal) as total FROM kiliometerliste WHERE strftime('%Y', Dato) = '2024' AND Initialer = :username GROUP BY month");
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->execute();
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Query error: ' . $e->getMessage();
                return [];
            }
        } else {
            echo 'Database connection failed';
            return [];
        }
    }
}