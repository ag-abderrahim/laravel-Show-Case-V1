<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    public static function getValue(
        string $key,
        mixed $default = null
    ): mixed {
        return static::query()
            ->where('key', $key)
            ->first()?->value ?? $default;
    }

    public static function setValue(
        string $key,
        mixed $value,
        string $group = 'general',
        string $type = 'text'
    ): self {
        return static::query()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
            ]
        );
    }
}
