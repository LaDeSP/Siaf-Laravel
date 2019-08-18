<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    protected $User;
    
    public function __construct(User $user){
        $this->user = $user;
    }
    
    public function create($attributes){
        return $this->user->create($attributes);
    }
    
    public function update($id, array $attributes){
        return $this->user->find($id)->update($attributes);
    }
    
    public function delete($id){
        return $this->user->find($id)->delete();
    }

    public function propriedades($id){
        return $this->user->find($id)->propriedades()->first();
    }
}