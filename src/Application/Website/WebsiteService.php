<?php

namespace Application\Website;

use Domain\Website\Website;
use Domain\Website\WebsiteRepository;

class WebsiteService
{
    public function __construct(private WebsiteRepository $repo) {}

    public function create(string $companyId, string $address, string $source, ?int $roi, ?int $subscribers): Website
    {
        $website = new Website($companyId, $address, $source, null, $roi, $subscribers, null);
        $this->repo->save($website);
        return $website;
    }

    public function update(string $companyId, string $address, string $source, string $id, ?int $roi, ?int $subscribers): Website
    {
        $website = new Website($companyId, $address, $source, $id, $roi, $subscribers, null);
        $this->repo->save($website);
        return $website;
    }

    public function get(string $id): ?Website
    {
        return $this->repo->getById($id);
    }

    public function all(?string $companyId): array
    {
        return $this->repo->getAll($companyId);
    }

    public function delete(string $id): void
    {
        $this->repo->delete($id);
    }
}
