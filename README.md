# URL Shortener App

A simple Laravel-based URL shortener that allows encoding long URLs to shortened versions and decoding them back to the original URLs.

## Installation

1. Clone the repo:

   ```bash
   git clone https://your-repository-url.git
   cd your-repository-directory
   ```
2. Serve the app:

   ```bash
   php artisan serve
   ```

## Endpoints

- **POST** `/encode`: Encode a URL to a shortened URL.
- **POST** `/decode`: Decode a shortened URL to the original URL.

## Example Requests

- **Encode URL**:

  ```bash
  curl -X POST http://127.0.0.1:8000/api/encode -d "original_url=https://www.example.com?extra-param=1"
  ```

  Response:
  ```json
  { "short_url": "http://short.est/GeAi9K" }
  ```

- **Decode URL**:

  ```bash
  curl -X POST http://127.0.0.1:8000/api/decode -d "short_url=http://short.est/GeAi9K"
  ```

  Response:
  ```json
  { "original_url": "https://www.example.com" }
  ```

## Running Tests

1. Run tests:

   ```bash
   php artisan test
   ```
