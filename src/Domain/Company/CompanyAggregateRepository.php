<?php

namespace Domain\Company;

interface CompanyAggregateRepository
{
    public function getById(string $id): ?CompanyAggregate;
    public function getWebsiteListByCompany(string $companyId): array;
    public function save(CompanyAggregate $companyAggregate): void;
}