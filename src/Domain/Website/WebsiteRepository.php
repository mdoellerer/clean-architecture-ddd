<?php

namespace Domain\Website;

interface WebsiteRepository
{
    public function getById(string $id): ?Website;
}
