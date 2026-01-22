<?php

declare(strict_types=1);

namespace App\Data\Admin;

use Spatie\LaravelData\Data;

class UserUpdateData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public int $roleId,
    ) {}
}
