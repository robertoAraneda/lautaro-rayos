<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::orderBy('id')->get();
    }

    public function findById($id)
    {
        return User::find($id);
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function findByRut($rut)
    {
        return User::where('rut', $rut)->first();
    }

    public function update($userModel, $request)
    {
        $userModel->rut = $request->rut;
        $userModel->name = $request->name;
        $userModel->lastname= $request->lastname;
        $userModel->mother_lastname = $request->mother_lastname;
        $userModel->phone = $request->phone;
        $userModel->email = $request->email;
        $userModel->password = bcrypt($request->password);

        $userModel->save();

        return $userModel->fresh();
    }

    public function store($request)
    {
        $userModel =  new User;

        $userModel->rut = $request->rut;
        $userModel->name = $request->name;
        $userModel->lastname= $request->lastname;
        $userModel->mother_lastname = $request->mother_lastname;
        $userModel->phone = $request->phone;
        $userModel->email = $request->email;
        $userModel->password = bcrypt($request->password);

        $userModel->save();

        return $userModel->fresh();
    }
}
