<?php

namespace Domain\Strategy\MainUrl;

use Domain\MainUrl\MainUrl;

interface Strategy
{
    public function getName(): string;
    public function apply(): ?MainUrl;
}