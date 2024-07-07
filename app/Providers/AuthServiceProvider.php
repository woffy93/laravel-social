<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Contracts\Likable;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('like', function (User $user, Likable $likable) {
            if(!$likable->exists){
                return Response::deny("You can't like an unexisting obj");
            }
            if($user->hasLiked($likable)){
                return Response::deny("Multiple likes are not allowed, you already liked this");
            }

            return Response::allow();
        });

        Gate::define('removeLike', function (User $user, Likable $likable) {
            if(!$likable->exists){
                return Response::deny("You can't remove a like from an unexisting obj");
            }
            if(!$user->hasLiked($likable)){
                return Response::deny("You can't remove a like from something you haven't liked");
            }

            return Response::allow();
        });
    }
}
