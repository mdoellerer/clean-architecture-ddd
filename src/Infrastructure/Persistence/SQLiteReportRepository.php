<?php

namespace Infrastructure\Persistence;

use PDO;
use Domain\Company\Company;
use Domain\Company\CompanyRepository;


class SQLiteReportRepository 
{
    private PDO $pdo;

    public function __construct(string $dbPath = __DIR__ . '/../../../' . SQLITE_FILE_PATH)
    {
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function list(): array
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
}