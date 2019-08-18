<?php

namespace App\Traits;
use Storage;
use Auth;

trait UserTrait {
    public function getProfilelinkAttribute()
    {
        return route('painel.users.edit', ['user' => $this->id]);
    }

    public function getAvatarlinkAttribute()
    {
        if(Storage::disk('public')->exists($this->avatar))
        {
            return Storage::disk('public')->url($this->avatar);
        }
        return asset('assets/img/avatar/agr.png');
    }
}
