<?php

namespace Domain\Company;

interface CompanyAggregateRepository
{
    public function save(CompanyAggregate $companyAggregate): void;
    public function getById(string $id): ?CompanyAggregate;
}