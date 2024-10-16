<?php

namespace App\Services;

use App\Models\Code;
use App\Models\User;
use Illuminate\Support\Str;

class CodeService
{
    /**
     * Generate a single random code.
     */
    public function random(): string
    {
        return strtoupper(implode('-', [
            Str::random(4),
            rand(101, 999),
            Str::random(4)
        ]));
    }

    /**
     * Generate multiple codes.
     */
    public function generate(int $count = 5): array
    {
        $codes = [];

        for ($i = 1; $i <= $count; $i++) {
            $codes[] = new Code(['code' => $this->random()]);
        }

        return $codes;
    }

    /**
     * Mark given code as consumed.
     */
    public function markAsConsumed(string $code, User $consumedBy): void
    {
        Code::whereCode($code)->update([
            'consumed_at' => now(),
            'guest_id' => $consumedBy->id
        ]);
    }
}
