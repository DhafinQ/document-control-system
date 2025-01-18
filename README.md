# Document Management

**PENTING !!**
Branch dan instruksi dalam branch dibawah ini sudah tidak sesuai
https://github.com/DhafinQ/document-control-system/tree/feature-rbac-new

Instruksi pada branch sekarang merupakan pengimplementasian dari awal untuk package :
https://github.com/itstructure/laravel-rbac
Dalam instruksi ini dapat dicustomize sesuai kebutuhan

## How To Run
    1. Create Database name db_dcs
    2. Clone this project (branch develop for development)
    3. Run command "composer install" to cloned project folder
    4. Run command "cp .env.example .env"
    5. Run command "php artisan key:generate"
    6. Run command "php artisan migrate:fresh --seed"
    7. Run command "php artisan serve"
    8. Open browser to url "http://127.0.0.1:8000/login" and Login with admin Account

## Account
Email : **admin@gmail.com**
Password : **password**

# Implementasi RBAC dan Authentication

## RBAC
Menggunakan package [laravel-rbac](https://github.com/itstructure/laravel-rbac).

**Package RBAC ini memiliki fitur bawaan seperti model Role, Permission, dan CRUD untuk Role, Permission, dan User (kecuali create untuk User perlu dibuat manual).**

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
    
    }
      ```


4. Konfigurasi file config/rbac.php:
     ```php
   <?php

    return [
        'layout' => 'layout.layout',
        'userModelClass' => App\Models\User::class,
        'adminUserId' => null,
        'routesMainPermission' => Itstructure\LaRbac\Models\Permission::ADMINISTRATE_PERMISSION,
        'routesAuthMiddlewares' => ['auth'],
        'memberNameAttributeKey' => 'name',
        'rowsPerPage' => 10,
    ];
    ```

6. Seeder
     ```php
   <?php
    
    namespace Database\Seeders;
    
    use Illuminate\Database\Seeder;
    
    class DatabaseSeeder extends Seeder
    {
        public function run(): void
        {
            $this->call([
                CustomSeeder::class,
                CategorySeeder::class,
                UserSeeder::class,
            ]);
        }
    }
     ```
6. Custom Seeder ( Bisa disetting )
     ```php
    <?php
    
    namespace Database\Seeders;
    
    use Illuminate\Database\Seeder;
    use Itstructure\LaRbac\Models\{Role, Permission};
    
    class CustomSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run()
        {
            // Custom permissions
            $permissions = [
                ['slug' => Permission::ADMINISTRATE_PERMISSION, 'name' => 'Administrate', 'description' => 'Izin untuk mengatur sistem'],
    
                ['slug' => 'create-users', 'name' => 'Create Users', 'description' => 'Izin untuk membuat pengguna'],
    
                ['slug' => 'manage-categories', 'name' => 'Manage Categories', 'description' => 'Izin untuk mengelola kategori'],
    
                ['slug' => 'view-documents', 'name' => 'View Documents', 'description' => 'Izin untuk melihat dokumen'],
                ['slug' => 'create-documents', 'name' => 'Create Documents', 'description' => 'Izin untuk membuat dokumen'],
                ['slug' => 'edit-documents', 'name' => 'Edit Documents', 'description' => 'Izin untuk mengedit dokumen'],
                ['slug' => 'delete-documents', 'name' => 'Delete Documents', 'description' => 'Izin untuk menghapus dokumen'],
    
                ['slug' => 'view-revisions', 'name' => 'View Revisions', 'description' => 'Izin untuk melihat revisi dokumen'],
                ['slug' => 'edit-revisions', 'name' => 'Edit Revisions', 'description' => 'Izin untuk mengedit revisi dokumen'],
                ['slug' => 'create-revisions', 'name' => 'Create Revisions', 'description' => 'Izin untuk membuat revisi dokumen'],
    
                ['slug' => 'view-histories', 'name' => 'View Histories', 'description' => 'Izin untuk melihat riwayat dokumen'],
    
                ['slug' => 'active-document', 'name' => 'Active Document', 'description' => 'Izin untuk mengakses dokumen aktif'],
                ['slug' => 'view-approval', 'name' => 'View Approval', 'description' => 'Izin untuk melihat approval dokumen'],
                ['slug' => 'edit-approval', 'name' => 'Edit Approval', 'description' => 'Izin untuk mengedit approval dokumen'],
            ];
    
            foreach ($permissions as $permission) {
                Permission::updateOrCreate(['slug' => $permission['slug']], $permission);
            }
    
            // Custom roles
            $roles = [
                'Administrator' => [
                    'name' => 'Administrator',
                    'permissions' => [
                        Permission::ADMINISTRATE_PERMISSION,
                        'create-users',
                        'manage-categories',
                        'view-documents',
                        'create-documents',
                        'edit-documents',
                        'delete-documents',
                        'view-revisions',
                        'create-revisions',
                        'edit-revisions',
                        'view-histories',
                        'active-document',
                        'view-approval',
                        'edit-approval',
                    ],
                ],
                'Reviewer' => [
                    'name' => 'Reviewer',
                    'permissions' => [
                        'view-documents',
                        'view-revisions',
                        'edit-revisions',
                        'view-approval',
                        'edit-approval',
                    ],
                ],
                'Staff' => [
                    'name' => 'Staff',
                    'permissions' => [
                        'view-documents',
                        'create-documents',
                    ],
                ],
            ];
    
            foreach ($roles as $slug => $data) {
                $this->createRole($slug, $data['name'], $data['permissions']);
            }
        }
    
        /**
         * Create a role and attach permissions.
         *
         * @param string $slug
         * @param string $name
         * @param array $permissionSlugs
         * @return void
         */
        private function createRole(string $slug, string $name, array $permissionSlugs): void
        {
            $role = Role::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'description' => "{$name} role"]
            );
    
            $permissionIds = Permission::whereIn('slug', $permissionSlugs)->pluck('id');
            $role->permissions()->sync($permissionIds);
        }
    
    }
   ```
6. Setelah diseeder, maka buat AuthServiceProvider dengan :
   ```
   php artisan make:provider AuthServiceProvider
   ```
   
7. Provider tersebut berisikan permission yang dibuat menjadi **Gate**
    ```php
    <?php
    
    namespace App\Providers;
    
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
    use Itstructure\LaRbac\Models\Permission;
    use Itstructure\LaRbac\Interfaces\{RbacUserInterface, RbacModelInterface};
    use Itstructure\LaRbac\Classes\MemberToRole;
    
    
    class AuthServiceProvider extends ServiceProvider
    {
        /**
         * Register services.
         */
        public function register(): void
        {
            // Tidak perlu register policies secara eksplisit jika tidak menggunakan laravel default policies
        }
    
        /**
         * Bootstrap services.
         */
        public function boot(): void
        {
            $this->registerPolicies();
    
    
            Gate::define('administrate', function (RbacUserInterface $user) {
                return $user->hasAccess([Permission::ADMINISTRATE_PERMISSION]);
            });
    
            Gate::define('create-users', function (RbacUserInterface $user) {
                return $user->hasAccess(['create-users']);
            });
    
            Gate::define('view-histories', function (RbacUserInterface $user) {
                return $user->hasAccess(['view-histories']);
            });
    
            Gate::define('manage-categories', function (RbacUserInterface $user) {
                return $user->hasAccess(['manage-categories']);
            });
    
            Gate::define('view-revisions', function (RbacUserInterface $user) {
                return $user->hasAccess(['view-revisions']);
            });
    
            Gate::define('edit-revisions', function (RbacUserInterface $user) {
                return $user->hasAccess(['edit-revisions']);
            });
    
            Gate::define('view-documents', function (RbacUserInterface $user) {
                return $user->hasAccess(['view-documents']);
            });
    
            Gate::define('create-documents', function (RbacUserInterface $user) {
                return $user->hasAccess(['create-documents']);
            });
    
            Gate::define('edit-documents', function (RbacUserInterface $user) {
                return $user->hasAccess(['edit-documents']);
            });
    
            Gate::define('delete-documents', function (RbacUserInterface $user) {
                return $user->hasAccess(['delete-documents']);
            });
        }
    }
    ```

Read more in [Laravel gates](https://laravel.com/docs/9.x/authorization#gates)

8 Untuk **Route** menggunakan **can:(namapermission)**. Contohnya :
    ```php

    Route::middleware(['auth'])->group(function () {
    
        Route::get('/dashboards', function () {
            return view('admin.dashboard');
        });
    
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/user/profile-information', [\Laravel\Fortify\Http\Controllers\ProfileInformationController::class, 'update']);
    
        Route::get('/active_document', [DocumentController::class, 'indexActive'])->name('document.active')->middleware('can:active-document');
        Route::get('/dashboard', [DocumentController::class, 'dashboard'])->name('dashboard');
    
        Route::get('/users/create', [UserController::class, 'create'])->name('create_users')->middleware('can:create-users');
        Route::post('rbac/users/store', [UserController::class, 'store'])->name('store_user')->middleware('can:create-users');
    
        Route::get('/document_histories', [DocumentHistoryController::class, 'index'])->name('document_histories.index')->middleware('can:view-histories');
        Route::get('/document_histories/{document_history}', [DocumentHistoryController::class, 'show'])->name('document_histories.show')->middleware('can:view-histories');
    
    
        Route::middleware('can:manage-categories')->group(function () {
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });
    
    
        Route::get('/document_revision', [DocumentRevisionController::class, 'index'])->name('document_revision.index')->middleware('can:view-revisions');
        Route::get('/document_approval', [DocumentRevisionController::class, 'indexApproval'])->name('document_approval.index')->middleware('can:view-approval');
        Route::get('/document_revision/{documentRevision}/edit', [DocumentRevisionController::class, 'edit'])->name('document_revision.edit')->middleware('can:edit-revisions');
        Route::get('/document_approval/{documentRevision}/edit', [DocumentRevisionController::class, 'editApproval'])->name('document_approval.edit')->middleware('can:edit-approval');
        Route::put('/document_revision/{documentRevision}', [DocumentRevisionController::class, 'update'])->name('document_revision.update')->middleware('can:edit-revisions');
        Route::put('/document_approval/{documentRevision}', [DocumentRevisionController::class, 'updateApproval'])->name('document_approval.update')->middleware('can:edit-approval');
        Route::get('/file/dokumen/{filename}', [DocumentRevisionController::class, 'showFile'])->name('document_revision.show-file')->middleware('can:view-revisions');
    
    
        Route::get('/document_revision/create', [DocumentRevisionController::class, 'create'])->name('document_revision.create')->middleware('can:create-revisions');
        Route::post('/document_revision/store', [DocumentRevisionController::class, 'store'])->name('document_revision.store')->middleware('can:create-revisions');
    
        
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index')->middleware('can:view-documents');
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create')->middleware('can:create-documents');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store')->middleware('can:create-documents');
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit')->middleware('can:edit-documents');
        Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update')->middleware('can:edit-documents');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy')->middleware('can:delete-documents');
        Route::get('/documents/download/{filename}', [DocumentController::class, 'downloadDocument'])->name('file.dokumen')->middleware('can:view-documents');
    });
    
    ```

## Authentication
Pada Authentication menggunakan package Laravel Fortify.

**Fortify memiliki fitur bawaan seperti:**
- Two-Factor Authentication
- Reset Password
- Email Verification
- Password Confirmation
- Namun, dalam implementasi ini hanya digunakan untuk autentikasi dasar.

## Konfigurasi
1. Instal package menggunakan composer:
   ```
   1. composer require laravel/fortify
   2. php artisan fortify:install
   ```
   
3. Konfigurasi file FortifyServiceProvider.php:
   
   ```php
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
   ```
