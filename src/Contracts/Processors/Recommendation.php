<?php

namespace App\Contracts\Processors;

interface Recommendation
{
    public function recommends(): array;
}
