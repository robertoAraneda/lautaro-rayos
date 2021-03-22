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

    public function update($model, $request)
    {
        $model->rut = strtoupper($request->rut);
        $model->name =strtoupper($request->name);
        $model->lastname= strtoupper($request->lastname);
        $model->mother_lastname = strtoupper($request->mother_lastname);
        $model->phone = strtoupper($request->phone);
        $model->email = strtolower($request->email);
        $model->password = bcrypt($request->password);

        $model->save();

        return $model->fresh();
    }

    public function store($request)
    {
        $userModel =  new User;

        $model->rut = strtoupper($request->rut);
        $model->name =strtoupper($request->name);
        $model->lastname= strtoupper($request->lastname);
        $model->mother_lastname = strtoupper($request->mother_lastname);
        $model->phone = strtoupper($request->phone);
        $model->email = strtolower($request->email);
        $model->password = bcrypt($request->password);


        $model->save();

        return $model->fresh();
    }
}
