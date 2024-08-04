<?php


class Database
{
    const SELECTSINGLE = 1;
    const SELECTALL = 2;
    const EXECUTE = 3;
    const QUERY_GET_PAGES = "SELECT url, status FROM pages";
    const QUERY_INSERT_PAGE = "INSERT INTO pages (url, status) VALUES (:url, :status)";
    const QUERY_DELETE_ALL_PAGES = "DELETE FROM pages";
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME,
            DB_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /* valuesToBind espera un array de arrays, donde cada array interno sea del estilo
     * [string bindName, mixed value] */
    public function query(string $sql, string $type, array $valuesToBind = []): mixed
    {
        $result = false;
        $stmt = $this->pdo->prepare($sql);

        foreach ($valuesToBind as $valueToBind) {
            $stmt->bindValue($valueToBind[0], $valueToBind[1]);
        }

        $stmt->execute();

        switch ($type) {
            case self::SELECTSINGLE:
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                break;
            case self::SELECTALL:
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
        }

        return $result;
    }
}