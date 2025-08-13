<?php

namespace Infrastructure\Persistence;

use PDO;
use Domain\Website\Website;
use Domain\Website\WebsiteRepository;


class SQLiteWebsiteRepository implements WebsiteRepository
{
    private PDO $pdo;

    public function __construct(string $dbPath = __DIR__ . '/../../../' . SQLITE_FILE_PATH)
    {
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function getById(string $id): ?Website
    {
        $stmt = $this->pdo->prepare("SELECT * FROM websites WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);       

        if (!$row) return null;

        return new Website( 
            $row["company_id"], 
            $row['address'], 
            $row['source'], 
            $row['id'], 
            $row['roi'], 
            $row['subscribers'], 
            $row['updated_at']
        );
    }

}
