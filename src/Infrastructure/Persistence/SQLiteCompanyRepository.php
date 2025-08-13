<?php

namespace Infrastructure\Persistence;

use PDO;
use Domain\Company\Company;
use Domain\Company\CompanyRepository;


class SQLiteCompanyRepository implements CompanyRepository
{
    private PDO $pdo;

    public function __construct(string $dbPath = __DIR__ . '/../../../' . SQLITE_FILE_PATH)
    {
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function save(Company $company): void
    {
        $stmt = $this->pdo->prepare("REPLACE INTO companies (id, name, country, strategy_id) VALUES (:id, :name, :country, :strategy_id)");
        $stmt->execute([
            ':id' => $company->getId(),
            ':name' => $company->getName(),
            ':country' => $company->getCountry()->getName(),
            ':strategy_id' => $company->getStrategyId()
        ]);
    }

    public function getById(string $id): ?Company
    {
        $stmt = $this->pdo->prepare("SELECT * FROM companies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);       

        if (!$row) return null;

        return new Company($row['name'], $row['country'], $row['strategy_id'], $row['id']);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM companies");
        $companies = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $companies[] = new Company($row['name'], $row['country'], $row['strategy_id'], $row['id']);
        }
        return $companies;
    }

    public function delete(string $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM companies WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
