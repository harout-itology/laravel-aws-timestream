<?php

namespace HaroutItology\AwsTimestream\Contract;

interface CanBuildQueryContract
{
    /**
     * Build SQL query
     */
    public function builder(): void;
}
