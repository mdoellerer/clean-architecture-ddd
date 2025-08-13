<?php

namespace Application\Website;

use Domain\Company\CompanyAggregateRepository;
use Domain\Website\Website;
use Domain\Website\WebsiteRepository;

class WebsiteService
{
    public function __construct(
        private WebsiteRepository $repository,
        private CompanyAggregateRepository $aggregateRepository
        ) {}

    public function create(string $companyId, string $address, string $source, ?int $roi, ?int $subscribers): Website
    {
        $website = new Website($companyId, $address, $source, null, $roi, $subscribers, null);

        $companyAggregate = $this->aggregateRepository->getById($companyId);
        $companyAggregate->addWebsite($website);
        $this->aggregateRepository->save($companyAggregate);

        return $website;
    }

    public function update(string $companyId, string $address, string $source, string $id, ?int $roi, ?int $subscribers): Website
    {
        $website = new Website($companyId, $address, $source, $id, $roi, $subscribers, null);
        
        $companyAggregate = $this->aggregateRepository->getById($companyId);
        $companyAggregate->updateWebsite($website);
        $this->aggregateRepository->save($companyAggregate);

        return $website;
    }

    public function get(string $id): ?Website
    {
        return $this->repository->getById($id);
    }

    public function all(?string $companyId): array
    {
        return $this->aggregateRepository->getWebsiteListByCompany($companyId);
    }

    public function delete(string $websiteId, string $companyId): void
    {
        $companyAggregate = $this->aggregateRepository->getById($companyId);
        $companyAggregate->removeWebsite($websiteId);
        $this->aggregateRepository->save($companyAggregate);
    }
}
