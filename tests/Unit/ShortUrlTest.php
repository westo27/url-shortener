<?php

namespace Tests\Unit;

use App\Models\ShortUrl;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    /** @test */
    public function it_stores_url_in_cache()
    {
        $originalUrl = 'https://example.com';
        $code = 'abc123';

        ShortUrl::store($originalUrl, $code);

        $this->assertEquals($originalUrl, Cache::get("short_url:$code"));
    }

    /** @test */
    public function it_retrieves_url_from_cache()
    {
        $originalUrl = 'https://retrievable.com';
        $code = 'xyz789';

        Cache::put("short_url:$code", $originalUrl);

        $this->assertEquals($originalUrl, ShortUrl::get($code));
    }

    /** @test */
    public function it_returns_null_if_url_not_in_cache()
    {
        $this->assertNull(ShortUrl::get('missingcode'));
    }
}
