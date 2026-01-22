<?php

declare(strict_types=1);

namespace App\Data\Admin;

use Spatie\LaravelData\Data;

class RoleUpdateData extends Data
{
    public function __construct(
        public string $name,
        /**
         * @var array<int, int>
         */
        public array $permissions = [],
    ) {}
}
