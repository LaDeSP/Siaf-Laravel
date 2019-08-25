<?php
namespace App\Services;

use Illuminate\Http\Request;

class UserService{
    
    public function update(Request $request, $id){
        $attributes = $request->all();  
        return $this->userRepository->update($id, $attributes);
    }

    public function propriedadesUser(){
        return auth()->user()->propriedades()->get()->first();
    }
}