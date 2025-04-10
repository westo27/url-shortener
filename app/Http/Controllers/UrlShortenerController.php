<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Class UrlShortenerController
 *
 * This controller handles the encoding and decoding of URLs for the URL shortening service.
 */
class UrlShortenerController extends Controller
{
    /**
     * Encode the given URL to a shortened URL.
     *
     * @param Request $request The incoming request containing the original URL.
     *
     * @return JsonResponse A JSON response containing the shortened URL.
     */
    public function encode(Request $request): JsonResponse
    {
        try {
            $request->validate(['original_url' => 'required|url']);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid URL provided'], 422);
        }

        $originalUrl = $request->input('original_url');
        $code = Str::random(6);

        ShortUrl::store($originalUrl, $code);

        return response()->json(['short_url' => "http://short.est/$code"]);
    }

    /**
     * Decode the given shortened URL back to the original URL.
     *
     * @param Request $request The incoming request containing the shortened URL.
     *
     * @return JsonResponse A JSON response containing the original URL.
     */
    public function decode(Request $request): JsonResponse
    {
        try {
            $request->validate(['short_url' => 'required|url']);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid URL provided'], 422);
        }

        $parsed = parse_url($request->input('short_url'));
        $code = trim($parsed['path'] ?? '', '/short.est/');

        $originalUrl = ShortUrl::get($code);

        if (!$originalUrl) {
            return response()->json(['error' => 'Original URL not found'], 404);
        }

        return response()->json(['original_url' => $originalUrl]);
    }
}
