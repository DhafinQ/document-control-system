# Document Management

## How To Run
1. Create Database name <b>db_dcs</b>
2. Clone this project (branch develop for development)
3. Run command "<b>composer install</b>" to cloned project folder
4. Run command "<b>cp .env.example .env</b>"
5. Run command "<b>php artisan key:generate</b>"
6. Run command "<b>php artisan migrate:fresh --seed</b>"
7. Run command "<b>php artisan serve</b>"
8. Open browser to url "<b>http://127.0.0.1:8000/login</b>" and Login with admin Account

## Account
Email : <b>admin@gmail.com</b>
Password : <b>password</b>

# Implementasi RBAC dan Authentication

## RBAC
Menggunakan package [laravel-rbac](https://github.com/itstructure/laravel-rbac).

### Konfigurasi
1. Instal package menggunakan composer:
   ```bash
   composer require itstructure/laravel-rbac "^3.0.15"
   php artisan rbac:publish
2. Konfigurasi model User:
     ```php
   <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Itstructure\LaRbac\Interfaces\RbacUserInterface;
    use Itstructure\LaRbac\Traits\Administrable;
    
    class User extends Authenticatable implements RbacUserInterface
    {
        use HasFactory, Notifiable, Administrable;
    
        protected $fillable = [
            'name',
            'email',
            'password',
            'roles'
        ];
    
        protected $hidden = [
            'password',
            'remember_token',
        ];
    
        protected $casts = [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    
        public function isRole($roles): bool
        {
            $roles = is_array($roles) ? $roles : [$roles];
            return $this->roles()->whereIn('slug', $roles)->exists();
        }
    }
      ```


4. Konfigurasi file config/rbac.php:
   <?php

    return [
        'layout' => 'layout.master',
        'userModelClass' => App\Models\User::class,
        'adminUserId' => null,
        'routesMainPermission' => Itstructure\LaRbac\Models\Permission::ADMINISTRATE_PERMISSION,
        'routesAuthMiddlewares' => ['auth'],
        'memberNameAttributeKey' => function ($row) {
            return $row->name;
        },
        'rowsPerPage' => 10,
    ];

5. Seeder
   <?php
    
    namespace Database\Seeders;
    
    use Illuminate\Database\Seeder;
    
    class DatabaseSeeder extends Seeder
    {
        public function run(): void
        {
            $this->call([
                CustomSeeder::class,
                UserSeeder::class,
            ]);
        }
    }

## Catatan
Package RBAC ini memiliki fitur bawaan seperti model Role, Permission, dan CRUD untuk Role, Permission, dan User (kecuali create untuk User perlu dibuat manual).


## Authentication
Menggunakan Laravel Fortify.

## Konfigurasi
1. Instal package menggunakan composer:
   composer require laravel/fortify
    php artisan fortify:install

2. Konfigurasi file FortifyServiceProvider.php:

    <?php
    
    namespace App\Providers;
    
    use App\Actions\Fortify\CreateNewUser;
    use App\Actions\Fortify\ResetUserPassword;
    use App\Actions\Fortify\UpdateUserPassword;
    use App\Actions\Fortify\UpdateUserProfileInformation;
    use Illuminate\Cache\RateLimiting\Limit;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\RateLimiter;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Str;
    use Laravel\Fortify\Fortify;
    use Laravel\Fortify\Contracts\LogoutResponse;
    use Laravel\Fortify\Contracts\LoginResponse;
    
    class FortifyServiceProvider extends ServiceProvider
    {
        public function register(): void
        {
            Fortify::loginView(fn() => view('auth.login'));
    
            $this->app->instance(LoginResponse::class, new class implements LoginResponse {
                public function toResponse($request)
                {
                    return redirect('/dashboard');
                }
            });
    
            $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
                public function toResponse($request)
                {
                    return redirect('/');
                }
            });
        }
    
        public function boot(): void
        {
            Fortify::createUsersUsing(CreateNewUser::class);
            Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
            Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
            Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    
            RateLimiter::for('login', function (Request $request) {
                $key = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
                return Limit::perMinute(5)->by($key);
            });
    
            RateLimiter::for('two-factor', function (Request $request) {
                return Limit::perMinute(5)->by($request->session()->get('login.id'));
            });
        }
    }


## Catatan
Fortify memiliki fitur bawaan seperti:

Two-Factor Authentication
Reset Password
Email Verification
Password Confirmation
Namun, dalam implementasi ini hanya digunakan untuk autentikasi dasar.

## Catatan Keseluruhan
Package RBAC memiliki konfigurasi yang terbatas dan kurang dinamis.
Solusi sementara:
Membuat seeder baru untuk Role dan Permission.
Menggunakan middleware CheckRole untuk routing.

## Middleware CheckRole
    <?php
    
    namespace App\Http\Middleware;
    
    use Closure;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Illuminate\Support\Facades\Auth;
    
    class CheckRole
    {
       public function handle(Request $request, Closure $next, $role): Response
       {
           $user = Auth::user();
    
           if ($user && ($user->isRole('Admin') || $user->isRole($role))) {
               return $next($request);
           }
    
           abort(403, 'Unauthorized action.');
       }
    }

## Kesimpulan
Implementasi RBAC dan autentikasi saat ini masih dalam tahap pengembangan, terutama pada bagian middleware dan konfigurasi role/permission. Untuk sementara, gunakan pendekatan yang telah dijelaskan di atas, sambil mengeksplorasi opsi lebih optimal.
