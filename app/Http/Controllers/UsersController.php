<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Estado;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\PropriedadeService;
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

    public function update(Request $request, User $user) {
        $estados = Estado::orderBy('nome')->get();
        $data = $request->all();
        $messages = $this->messages(); 

        $validacao = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'], 
            'email' => 'max:100', 
        ], $messages);

        if ($validacao->fails()) {
            return view('painel.users.edit', ["user" => $user, 'errors' => $validacao->errors(), 'estados' => $estados, 'propriedade' => $this->userService->propriedadesUser()]);
        }if ($data['telefone']) {
            $validacao = Validator::make($data, [
                'telefone' => 'celular_com_ddd', 
            ], $messages);

            if ($validacao->fails()) {
                return view('painel.users.edit', ["user" => $user, 'errors' => $validacao->errors(), 'estados' => $estados, 'propriedade' => $this->userService->propriedadesUser()]);
            }

        }if ($data['senha']) {
            $validacao = Validator::make($data, [
                'senha' => 'min:6', 
                'confirme_senha' => 'min:6|same:senha'
            ], $messages);
            if ($validacao->fails()) {
                return view('painel.users.edit', ["user" => $user, 'errors' => $validacao->errors(), 'estados' => $estados, 'propriedade' => $this->userService->propriedadesUser()]);
            }
            
            $user->password = bcrypt($data['senha']);
        }
        $data['cpf'] = $user->cpf;
        $saved = $user->update($data);
        if ($saved) {
            $data=[
                'mensagem' => 'Perfil atualizado com sucesso!',
                'class' => 'info'
            ];
            return back()->with($data['class'], $data['mensagem']);
        } else {
            $data=[
                'mensagem' => 'Erro ao atualizar perfil, tente novamente!',
                'class' => 'danger'
            ];
            return back()->with($data['class'], $data['mensagem']);
        }
    }

    protected function messages() {
        return [
            'cpf.required' => 'CPF é obrigatório!', 
            'cpf.cpf' => 'CPF inválido!', 
            'cpf.unique' => 'Este CPF já está em uso!', 
            'name.required' => 'Nome é obrigatório!', 
            'name.string' => 'Nome deve conter somenete letras!', 
            'email.unique' => 'Este email já está em uso!',
            'telefone.celular_com_ddd' => 'Telefone inválido!',  
            'senha.required' => 'Senha é obrigatório!', 
            'senha.min' => 'Senha deve ter no mínimo 6 caracteres!', 
            'confirme_senha.same' => 'A senha deve ser igual!', 
            'confirme_senha.min' => 'Senha deve ter no mínimo 6 caracteres!', 
            'nome.required' => 'Nome é obrigatório!', 
            'localizacao.required' => 'Localização é obrigatório!', 
            'cidade.required' => 'Cidade é obrigatório!', 
        ];
    }
}
