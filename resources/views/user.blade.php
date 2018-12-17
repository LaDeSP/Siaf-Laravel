@extends('master')

@section('conteudo')
<div class="col-md-auto">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <form action="usuario" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">Nome:<span style="color: red">*</span></label> 
                        <div class="col-8">
                            <input value="{{$usuario->name}}" id="nome" name="name" placeholder="Informe seu nome" class="form-control" required="required" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-3 col-form-label">Email:</label> 
                        <div class="col-8">
                            <input value="{{$usuario->email}}" id="email" name="email" placeholder="Informe seu email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email">
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="telefone" class="col-3 col-form-label">Telefone:</label> 
                        <div class="col-8">
                            <input value="{{$usuario->telefone}}" id="telefone" name="telefone" placeholder="Informe seu telefone" class="form-control {{ $errors->has('telefone') ? ' is-invalid' : '' }}" type="text">
                            @if ($errors->has('telefone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('telefone') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="senha" class="col-3 col-form-label">Senha:</label> 
                        <div class="col-8">
                            <input value="" id="senha" name="senha" placeholder="Informe sua senha com no (mínimo 6 caracteres)" class="form-control{{ $errors->has('senha') ? ' is-invalid' : '' }}" type="password">
                            @if ($errors->has('senha'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('senha') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirme_senha" class="col-3 col-form-label">Confirme a senha:</label> 
                        <div class="col-8">
                            <input value="" id="confirme_senha" name="confirme_senha" placeholder="Confirme a senha fornecida" class="form-control {{ $errors->has('confirme_senha') ? ' is-invalid' : '' }}" type="password">
                            @if ($errors->has('confirme_senha'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('confirme_senha') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-8">
                            <a class="btn btn-secondary" href="usuario" role="button">Cancelar</a>
                            <button type="submit" class="btn btn-success">Salvar</button>      
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection