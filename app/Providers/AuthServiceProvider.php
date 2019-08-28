<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Produto;
use App\Models\User;
use App\Models\Propriedade;
use App\Models\Plantio;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-produto', function(User $user, Produto $produto){ 
            return $user->propriedades()->first()->id == $produto->propriedade_id;
        });

        Gate::define('view-manejos-plantio', function(User $user, Plantio $plantio){ 
            $talhoes = $user->propriedades()->first()->talhoes()->get();
            
            foreach($talhoes as $talhao){
                if($talhao->plantios()->where('id', $plantio->id)->first()){
                    return true;
                }
            }
            abort(404);
        });
    }
}
