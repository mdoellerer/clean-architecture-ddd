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
            source TEXT NOT NULL,
            roi INT NULL,
            subscribers INT NULL,
            updated_at INT NOT NULL
        )");
    }

    public function save(Website $website): void
    {
        $stmt = $this->pdo
            ->prepare("REPLACE INTO websites (id, company_id, address, source, roi, subscribers, updated_at) VALUES (:id, :company_id, :address, :source, :roi, :subscribers, :updated_at)");
        
        $stmt->execute([
            ':id' => $website->getId(),
            ':company_id' => $website->getCompanyId(),
            ':address' => $website->getAddress(),
            ':source' => $website->getSource()->getName(),
            ':roi' => $website->getRoi(),
            ':subscribers' => $website->getSubscribers(),
            ':updated_at' => $website->getUpdatedAt()
        ]);
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

    public function getAllByCompanyId($companyId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM websites WHERE company_id = :company_id");
                $stmt->execute(['company_id' => $companyId]);
        $websites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $websites[] = new Website( 
                                $row["company_id"], 
                                $row['address'], 
                                $row['source'], 
                                $row['id'], 
                                $row['roi'], 
                                $row['subscribers'], 
                                $row['updated_at']
                            );
        }
        return $websites;
    }

    public function delete(string $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM websites WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
