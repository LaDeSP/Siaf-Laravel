<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\PropriedadeService;
use App\Http\Requests\UserFormRequest;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller {
    protected $userService;
    protected $propriedadeService;
    
    public function __construct(UserService $userService, PropriedadeService $propriedadeService) {
        $this->userService = $userService;
        $this->propriedadeService = $propriedadeService;
    }
    
    public function edit(User $user) {
        $estados = Estado::orderBy('nome')->get();
        return view('painel.users.edit', ['user' => $user, 'estados' => $estados, 'propriedade' => $this->userService->propriedadesUser() ]);
    }
    
    public function update(UserFormRequest $request, User $user) {
        $userUpdate = $this->userService->update($request->all(), $user);
        $propriedadeUpdate = $this->propriedadeService->update($request->all(), $this->userService->propriedadesUser());
        
        if($userUpdate && $propriedadeUpdate){
            $data=[
                'mensagem' => 'Perfil atualizado com sucesso!',
                'class' => 'info'
            ];
            return back()->with($data['class'], $data['mensagem']);
        }else{
            $data=[
                'mensagem' => 'Erro ao atualizar perfil, tente novamente!',
                'class' => 'danger'
            ];
            return back()->with($data['class'], $data['mensagem']);
        }
    }
}
