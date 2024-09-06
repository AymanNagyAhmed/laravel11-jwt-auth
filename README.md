# JWT Authentication system

01- install api
```
php artisan install:api
```

02- install jwt package
```
composer require tymon/jwt-auth
```
03- Register the provider in:
```
// bootstrap\providers.php
<?php

return [
    App\Providers\AppServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
];
```

04- Publish in vendor folder
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
05- Generate jwt secret key:
```
php artisan jwt:secret
```
06- Run migrations
```
php artisan migrate
```
07- Import the interface in User Model
```
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): int|string|null
    {
        return $this->getKey();
    }

    /**
     * Get the custom claims for the JWT token.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
```
08- Configure the default api guard
```
// config\auth.php

<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'api'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
            'hash' => false
        ],
    ],


];

```
09- Generate UserController
```
php artisan make:controller Api/UserController --api
```
10-01 Add app\Exceptions\Handler.php
```
php artisan make:exception Handler
```
10-02
```
// bootstrap\app.php

use Illuminate\Auth\AuthenticationException;
use App\Helpers\ResponseHelper;

return Application::configure(basePath: dirname(__DIR__))
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (AuthenticationException $e) {
        return ResponseHelper::failResponse('Authentication failed.', $e->getMessage(), 401);
    });

```

11-01 Add global response structuer

```
// app\Helpers\ResponseHelper.php

<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function successResponse($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function failResponse($message = 'Failed', $errors = [], $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}


```
11-02- Edit 
```
// composer.json

"autoload": {
    "files": [
        "app/Helpers/ResponseHelper.php"
    ]
},

```
