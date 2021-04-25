<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Role;

class UserRepository
{
    public function all()
    {
        return User::orderBy('id')->get();
    }

    public function allRoles()
    {
        return Role::orderBy('id')->get();
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
        $model->role_id = $request->role_id;

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
        $model->role_id = $request->role_id;


        $model->save();

        return $model->fresh();
    }

    public function storeAdmin($request)
    {
        $userModel  =  new User;

        $rut        =  $request->input('rut');
        $name       =  $request->input('name');
        $password   =  $request->input('password');
        $role       =  $request->input('role_id');


        $userModel->rut = strtoupper($rut);
        $userModel->name =strtoupper($name);
        $userModel->password = bcrypt($password);
        $userModel->role_id = $role;



        $userModel->save();

        return $userModel->fresh();
    }
}
