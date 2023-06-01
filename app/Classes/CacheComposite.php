<?php

namespace App\Classes;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class CacheComposite
{
    public function updateCache($collection, string $type, array $columns): void
    {
        Cache::forget($type);
        Cache::forever(
            $type,
            $this->query($collection, $type, $columns)
        );
    }

    public function getCacheOrCreate(string $type, $collection = null, array $columns): Collection
    {
        if (Cache::has($type)) {
            $cache = Cache::get($type);
        } else {
            $cache = $this->query($collection, $type, $columns);
            Cache::put($type, $cache);
        }

        return $cache;
    }

    private function query($class, string $type, array $columns): Collection
    {
        if ($type === 'products')
            $collection = $class::select($columns)
                ->with(['category' => fn ($q) => $q->select('id', 'name')])
                ->get();

        if ($type === 'productsTrash')
            $collection = $class::withTrashed()
                ->select($columns)
                ->whereNotNull('deleted_at')
                ->with(['category' => fn ($q) => $q->select('id', 'name')])
                ->get();

        if ($type === 'categories' || 'files')
            $collection = $class::select($columns)->get();

        return $collection;
    }
}
