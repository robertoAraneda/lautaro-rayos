<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::orderBy('id')->get();
    }
}
