<?php

namespace Infrastructure\Persistence;

use Domain\Company\CompanyAggregate;
use Domain\Company\CompanyAggregateRepository;
use PDO;

class SQLiteCompanyAggregateRepository implements CompanyAggregateRepository
{
    private PDO $pdo;

    public function __construct(string $dbPath = __DIR__ . '/../../../' . SQLITE_FILE_PATH)
    {
        $this->pdo = new PDO('sqlite:' . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function getById(string $id): ?CompanyAggregate
    {
        return null;
    }

    public function save(CompanyAggregate $companyAggregate): void
    {

    }
}