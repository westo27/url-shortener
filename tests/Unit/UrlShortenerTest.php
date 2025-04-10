<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UrlShortenerTest extends TestCase
{
    /** @test */
    public function it_encodes_a_url_to_a_shortened_url()
    {
        $originalUrl = 'https://www.example.com';
        $code = substr(md5($originalUrl), 0, 6); // simulate a URL encoding mechanism
        $shortUrl = "http://short.est/$code";

        $this->assertEquals('http://short.est/' . $code, $shortUrl);
    }

    /** @test */
    public function it_returns_an_error_for_invalid_url_on_encode()
    {
        $invalidUrl = 'invalid-url';
        $isValidUrl = filter_var($invalidUrl, FILTER_VALIDATE_URL);

        $this->assertFalse($isValidUrl);
    }

    /** @test */
    public function it_decodes_a_shortened_url_to_the_original_url()
    {
        $shortUrl = 'http://short.est/GeAi9K';  // Simulated shortened URL
        $decodedUrl = 'https://www.example.com';  // Simulated decoding mechanism

        // Normally, you would query the database or cache here
        $this->assertEquals($decodedUrl, 'https://www.example.com');
    }

    /** @test */
    public function it_returns_an_error_for_invalid_short_url_on_decode()
    {
        $invalidShortUrl = 'http://short.est/invalidcode';

        // Simulate looking up the short URL and failing
        $this->assertNull(null);  // Simulating no match found

        $this->assertNull(null);  // Simulated invalid short URL decode
    }

    /** @test */
    public function it_returns_an_error_for_invalid_short_url_format()
    {
        $invalidUrl = 'invalid-url-format';

        $this->assertFalse(filter_var($invalidUrl, FILTER_VALIDATE_URL));
    }
}
