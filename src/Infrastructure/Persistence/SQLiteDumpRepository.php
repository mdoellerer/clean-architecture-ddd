<?php

namespace Infrastructure\Persistence;

use PDO;


class SQLiteDumpRepository 
{
    private PDO $pdo;

    public function __construct(string $dbPath = __DIR__ . '/../../../' . SQLITE_FILE_PATH)
    {
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function dumpCompanyMainUrl(): array
    {
        $stmt = $this->pdo->query(
            "SELECT c.name, w.address, w.updated_at FROM companies c INNER JOIN company_main_url cmu ON c.id = cmu.company_id INNER JOIN websites w ON cmu.website_id = w.id"
        );
        $companies = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $companies[] = [$row['name'] => [$row['address'], $row['updated_at']]];
        }
        return $companies;
    }

    public function dumpCompany(): array
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM companies "
        );
        $companies = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $companies[$row['id']] = [$row['name'] => [$row['country'], $row['strategy_id']]];
        }
        return $companies;
    }

    public function dumpWebsites(): array
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM websites "
        );
        $companies = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $companies[$row['id']] = [$row['company_id'] => [$row['address'], $row['source'],$row['roi'], $row['subscribers'],$row['updated_at']]];
        }
        return $companies;
    }
}