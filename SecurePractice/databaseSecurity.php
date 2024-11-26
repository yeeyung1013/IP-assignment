<?php
/**
 * Description of databaseSecurity
 *
 * @author Loh JW
 */

// Strongly typed parameterized queries.
// Use of encrypted configuration files for sensitive information.
// Minimal privilege principle for database access.

class databaseSecurity
{

    private $pdo;
    private $configFile = __DIR__ . '/../SecurePractice/config.json';

    public function __construct()
    {
        $config = $this->loadConfig($this->configFile);
        $this->connect($config);
    }

    private function loadConfig($file)
    {
        $encryptedConfig = file_get_contents($file);
        $config = json_decode($this->decryptConfig($encryptedConfig), true);
        return $config;
    }

    public function encryptConfigFile($configFile)
    {
        $key = 'abc123';
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt(file_get_contents($configFile), 'aes-256-cbc', $key, 0, $iv);
        file_put_contents($configFile, base64_encode($iv . $encryptedData));

        return $configFile;
    }

    private function decryptConfig($encryptedConfig)
    {
        $key = 'abc123';
        $data = base64_decode($encryptedConfig);
        $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
        return $decryptedData;
    }

    private function connect(array $config)
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $config['host'], $config['dbname']);

        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password']);
            echo "<p>Connect Successfully " . "</p>";

        } catch (PDOException $ex) {
            echo "<p>ERROR: " . $ex->getMessage() . "</p>";
            exit;
        }
    }

    public function query(string $sql, array $params = [])
    {
        $this->validateInput($params);
        $stmt = $this->pdo->prepare($sql);
        $this->bindParams($stmt, $params);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            echo "<p>ERROR: " . $ex->getMessage() . "</p>";
            exit;
        }

        return $stmt->fetchAll();
    }

    public function insert(string $table, array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute($data);
        } catch (PDOException $ex) {
            throw new Exception('Insert failed: ' . $ex->getMessage());
        }

        return $this->pdo->lastInsertId();
    }

    public function update(string $table, string $setClauseStr, string $whereClause, array $whereParams = [])
    {

        $sql = "UPDATE $table SET $setClauseStr WHERE $whereClause";
        $stmt = $this->pdo->prepare($sql);

        foreach ($whereParams as $key => $value) {
            $stmt->bindValue(":$key", $value, $this->getPDOType($value));
        }

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            throw new Exception('Update failed: ' . $ex->getMessage());
        }
        return $stmt->rowCount();
    }


    private function validateInput(array &$params)
    {
        foreach ($params as &$param) {
            if (!is_scalar($param)) {
                throw new InvalidArgumentException('Invalid parameter.');
            }
        }
    }

    private function getPDOType($value)
    {
        switch (gettype($value)) {
            case 'integer':
                return PDO::PARAM_INT;
            case 'boolean':
                return PDO::PARAM_BOOL;
            case 'NULL':
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }

    private function bindParams(PDOStatement $stmt, array $params)
    {
        foreach ($params as $key => &$value) {
            $stmt->bindValue(is_int($key) ? $key + 1 : ':' . $key, $value, $this->getPDOType($value));
        }
    }

    public function close()
    {
        $this->pdo = null;
    }

}

// Testing
/*
try {
    $db = new databaseSecurity();
    // Encrypt file
    $configFile = _DIR_ . '/../SecurePractice/config.json';
    $db->encryptConfigFile($configFile);

    // Testing retrieve data
    $results = $db->query('SELECT * FROM customer WHERE cust_id = :cust_id', ['cust_id' => 1]);
    print_r($results);
    // Testing insert data
    $data = [
        'passenger_id' => 'P10001',
        'cust_id' => '1',
        'method' => 'paypal',
        'amount'=> 100,
        'quantity'=>1,
        'date'=>date('Y-m-d'),
    ];
    $insertedId = $db->insert('payment', $data);
    echo "Inserted ID: " . $insertedId . "<br>";
    $db->close();
} catch (Exception $ex) {
    echo $ex->getMessage();
}*/