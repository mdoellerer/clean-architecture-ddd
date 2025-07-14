<?php

namespace Application\Company;

use Domain\Company\Company;
use Domain\Company\CompanyRepository;

class CompanyService
{
    public function __construct(private CompanyRepository $repo) {}

    public function create(string $name, string $country): Company
    {
        $company = new Company($name, $country, null);
        $this->repo->save($company);
        return $company;
    }

    public function update(string $name, string $country, string $id): Company
    {
        $company = new Company($name, $country, $id);
        $this->repo->save($company);
        return $company;
    }

    public function get(string $id): ?Company
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
