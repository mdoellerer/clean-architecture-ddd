<?php

namespace Domain\MainUrl;

interface MainUrlRepository
{
    public function save(MainUrl $mainUrl): void;
    public function getByCompanyId(string $companyId): ?MainUrl;
    public function deleteByCompanyId(string $companyId): void;
}