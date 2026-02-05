# Debugging serversideup/php #649
This is a blank Laravel project to debug https://github.com/serversideup/docker-php/issues/649

# Specific change
The main change is adding this to `routes/web.php`:

```php
Route::get('/.well-known/openid-configuration', function () {
    $appUrl = config('app.url');

    return response()->json([
        'issuer' => $appUrl,
        'authorization_endpoint' => $appUrl . '/oauth/authorize',
        'token_endpoint' => $appUrl . '/oauth/token',
        'userinfo_endpoint' => $appUrl . '/oauth/userinfo',
        'jwks_uri' => $appUrl . '/.well-known/jwks.json',
    ]);
});
```

This will test the endpoint at `http://localhost/.well-known/openid-configuration`.

# Build and run
This project uses `spin` to build and run the project.

#### Ensure Docker is running and all other services are stopped
```
docker stop $(docker ps -q)
```

#### Clone the repository
```bash
git clone https://github.com/serversideup/docker-php-issue-649.git
cd docker-php-issue-649
```

#### Copy the `.env.example` file
```bash
cp .env.example .env
```

#### Install dependencies
```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml run --rm php composer install
```

### Bring the services up
```bash
./vendor/bin/spin up
```

### Test the endpoint
```bash
curl http://localhost/.well-known/openid-configuration
```

Or visit http://localhost/.well-known/openid-configuration in your browser.