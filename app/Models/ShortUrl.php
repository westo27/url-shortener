<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * ShortUrl Model
 *
 * This model is responsible for storing and retrieving shortened URLs in cache.
 */
class ShortUrl extends Model
{
    /**
     * Store the original URL in the cache with a shortened code.
     *
     * @param string $originalUrl The original URL to shorten.
     * @param string $code The unique shortened code for the URL.
     *
     * @return void
     */
    public static function store(string $originalUrl, string $code): void
    {
        Cache::put("short_url:$code", $originalUrl, now()->addDays(1));
    }

    /**
     * Retrieve the original URL from the cache using the shortened code.
     *
     * @param string $code The shortened code for the URL.
     *
     * @return string|null The original URL if found, or null if not found.
     */
    public static function get(string $code): ?string
    {
        return Cache::get("short_url:$code");
    }
}
