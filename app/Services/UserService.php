<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $user){
        $this->userRepository = $user;
    }
    
    public function index(){
        return $this->userRepository->all();
    }
    
    public function create(array $attributes){
        return $this->userRepository->create($attributes);
    }
    
    public function update(Request $request, $id){
        $attributes = $request->all();  
        return $this->userRepository->update($id, $attributes);
    }

    public function propriedadesUser(){
        $id = Auth::user()->id;
        return $this->userRepository->propriedades($id);
    }
}