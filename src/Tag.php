<?php

namespace Dyfun\Tags;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Tag extends Model
{
    protected $fillable = ['tag', 'description'];

    public static function findOrCreate(array $values, string $description = null)
    {
        return collect($values)->map(function ($value) use ($description) {
            $tag = static::findTag($value);

            if (!$tag) {
                $tag = static::create([
                      'tag' => $value,
                      'description' => $description,
                  ]);
            }

            return $tag;
        });
    }

    public static function findTag(string $name)
    {
        return static::query()->where('tag', $name)->first();
    }
}
