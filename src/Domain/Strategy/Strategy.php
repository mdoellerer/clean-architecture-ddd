<?php

namespace Domain\Strategy;

interface Strategy
{
    public function getName(): string;
    public function setWebsites(array $websiteList): void;
    public function apply(): bool;
}