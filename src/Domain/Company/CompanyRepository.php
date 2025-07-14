<?php

namespace Domain\Company;

interface CompanyRepository
{
    public function save(Company $company): void;
    public function getById(string $id): ?Company;
    public function getAll(): array;
    public function delete(string $id): void;
}
