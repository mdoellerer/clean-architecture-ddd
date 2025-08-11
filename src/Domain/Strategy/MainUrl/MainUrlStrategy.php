<?php

namespace Domain\Strategy\MainUrl;

interface MainUrlStrategy
{
    public function getName(): string;
    public function setWebsites(array $websiteList): void;
    public function apply(): bool;
}