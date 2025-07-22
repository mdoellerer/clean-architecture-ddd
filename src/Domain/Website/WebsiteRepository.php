<?php

namespace Domain\Website;

interface WebsiteRepository
{
    public function save(Website $website): void;
    public function getById(string $id): ?Website;
    public function getAll(?string $companyId): array;
    public function delete(string $id): void;
}
