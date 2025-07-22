<?php

namespace Application\Website;

use Domain\Website\Website;
use Domain\Website\WebsiteRepository;

class WebsiteService
{
    public function __construct(private WebsiteRepository $repo) {}

    public function create(string $name, string $country): Website
    {
        $website = new Website($name, $country, null);
        $this->repo->save($website);
        return $website;
    }

    public function update(string $name, string $country, string $id): Website
    {
        $website = new Website($name, $country, $id);
        $this->repo->save($website);
        return $website;
    }

    public function get(string $id): ?Website
    {
        return $this->repo->getById($id);
    }

    public function all(): array
    {
        return $this->repo->getAll();
    }

    public function delete(string $id): void
    {
        $this->repo->delete($id);
    }
}
