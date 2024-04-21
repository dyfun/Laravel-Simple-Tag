<?php

namespace Dyfun\Tags;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

trait HasTags
{
    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(self::getTagClassName(), "taggable", "taggables")->withTimestamps();
    }

    public function attachTag(string $value, string $description = null)
    {
        return $this->attachTags([$value], $description);
    }

    public function attachTags(array $values, string $description = null)
    {
        $className = static::getTagClassName();

        $tags = $className::findOrCreate($values, $description);

        $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        return $this;
    }

    public function detachTag(string $value)
    {
        return $this->detachTags([$value]);
    }

    public function detachTags(array $values)
    {
        $tags = $this->convertTags($values);

        collect($tags)->filter()->each(function ($tag) {
            $this->tags()->detach($tag);
        });

        return $this;
    }

    protected static function convertTags(array $values)
    {
        $className = static::getTagClassName();

        return collect($values)->map(function ($value) use ($className) {
            return $className::findTag($value);
        });
    }
}
