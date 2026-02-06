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

#### Clone the repository and change into the project directory
```bash
git clone https://github.com/jaydrogers/docker-php-649-apache-well-known.git
```
#### Copy the `.env.example` file
```bash
cp docker-php-649-apache-well-known/.env.example docker-php-649-apache-well-known/.env
```

#### Change permissions to `www-data`
This is very important if you're running this on a Linux machine. You need the files to be owned by `www-data`.

```bash
sudo chown -R 33:33 docker-php-649-apache-well-known
```

#### Change directory into the project
```bash
cd docker-php-649-apache-well-known
```

#### Install dependencies
```bash
docker compose run --rm php composer install
```

#### Generate the application key
```bash
docker compose run --rm php artisan key:generate
```

#### Run migrations
```bash
docker compose run --rm php artisan migrate
```

### Bring the services up
```bash
docker compose up
```

### Test the endpoint
```bash
curl http://localhost/.well-known/openid-configuration
```

Or visit http://localhost/.well-known/openid-configuration in your browser.