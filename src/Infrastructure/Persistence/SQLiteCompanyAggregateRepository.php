<?php

namespace Infrastructure\Persistence;

use Domain\Company\Company;
use Domain\Company\CompanyAggregate;
use Domain\Company\CompanyAggregateRepository;
use Domain\Website\Website;
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
        $stmt = $this->pdo->prepare("SELECT * FROM companies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);       

        if (!$row) return null;

        $websiteList = $this->getWebsiteListByCompany($id);
        $company = new Company($row['name'], $row['country'], $row['strategy_id'], $row['id']);

        return new CompanyAggregate($company, $websiteList);
    }

    public function getWebsiteListByCompany(string $companyId): array
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

    public function save(CompanyAggregate $companyAggregate): void
    {
        //$company = $companyAggregate->company;
        $websites = $companyAggregate->getWebsiteList();
        $deletedWebsites = $companyAggregate->getWebsiteDeletions();
        $mainUrl = $companyAggregate->mainUrl;


        // Wrap all Aggregate Changes in one Transaction 
        $this->pdo->beginTransaction();

        try 
        {
            foreach ($websites as $website){
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

            foreach ($deletedWebsites as $deletedWebsite){
                $stmt = $this->pdo->prepare("DELETE FROM websites WHERE id = :id");
                $stmt->execute([':id' => $deletedWebsite]);
            }

            if ($mainUrl?->websiteId){
                $stmt = $this->pdo
                    ->prepare("REPLACE INTO company_main_url (company_id, website_id) VALUES (:company_id, :website_id)");
                
                $stmt->execute([
                    ':company_id' => $mainUrl->companyId,
                    ':website_id' => $mainUrl->websiteId
                ]);                
            }

            $this->pdo->commit();

        } catch (\Exception $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }
}