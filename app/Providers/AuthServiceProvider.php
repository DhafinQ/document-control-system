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

        // Permission tambahan
        Gate::define('active-document', function (RbacUserInterface $user) {
            return $user->hasAccess(['active-document']);
        });

        Gate::define('view-approval', function (RbacUserInterface $user) {
            return $user->hasAccess(['view-approval']);
        });

        Gate::define('edit-approval', function (RbacUserInterface $user) {
            return $user->hasAccess(['edit-approval']);
        });

        Gate::define('create-revisions', function (RbacUserInterface $user) {
            return $user->hasAccess(['create-revisions']);
        });
    }
}
