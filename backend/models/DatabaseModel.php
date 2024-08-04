<?php

class DatabaseModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME,
            DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function selectAll(string $query, array $params = []): array
    {
        $stmt = $this->execute($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //TODO: es necesario hacer $stmt->close()???
    }

    // $valueToBind is an array [":valueName", value]
    public function execute(string $query, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $valueToBind) {
            $stmt->bindValue($valueToBind[0], $valueToBind[1]);
        }

        $stmt->execute();

        return $stmt;
    }
}