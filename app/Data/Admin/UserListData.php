<?php

declare(strict_types=1);

namespace App\Data\Admin;

use App\Models\User;
use Spatie\LaravelData\Data;

class UserListData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $emailVerifiedAt,
        public string $createdAt,
        public ?int $roleId,
        public ?string $roleName,
    ) {}

    public static function fromModel(User $user): self
    {
        $role = $user->roles->first();

        return new self(
            $user->id,
            $user->name,
            $user->email,
            $user->email_verified_at?->toDateTimeString(),
            $user->created_at?->toDateTimeString() ?? '',
            $role?->id,
            $role?->name,
        );
    }
}
