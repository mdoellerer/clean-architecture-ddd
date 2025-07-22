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

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS websites (
            id TEXT PRIMARY KEY,
            company_id TEXT NOT NULL,
            address TEXT NOT NULL,
            source TEXT NOT NULL
        )");
    }

    public function save(Website $website): void
    {
        $stmt = $this->pdo->prepare("REPLACE INTO websites (id, company_id, address, source) VALUES (:id, :company_id, :address, :source)");
        $stmt->execute([
            ':id' => $website->getId(),
            ':company_id' => $website->getCompanyId(),
            ':address' => $website->getAddress(),
            ':source' => $website->getSource()
        ]);
    }

    public function getById(string $id): ?Website
    {
        $stmt = $this->pdo->prepare("SELECT * FROM websites WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);       

        if (!$row) return null;

        return new Website( $row["company_id"], $row['address'], $row['source'], $row['id']);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM websites");
        $companies = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $companies[] = new Website( $row["company_id"], $row['address'], $row['source'], $row['id']);
        }
        return $companies;
    }

    public function delete(string $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM websites WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
