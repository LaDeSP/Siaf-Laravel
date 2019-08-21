<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 13 Aug 2019 12:50:10 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use App\Traits\UserTrait;

class User extends Authenticatable
{
	use Notifiable;
	use SoftDeletes;
	use UserTrait;

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'email_verified_at',
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
		'profilelink',
	];

	protected $fillable = [
		'cpf',
		'name',
		'email',
		'telefone',
		'email_verified_at',
		'password',
		'remember_token'
	];

	protected $appends = ['profilelink', 'avatarlink'];

	public function propriedades()
	{
		return $this->hasMany(\App\Models\Propriedade::class, 'users_id');
	}
}
