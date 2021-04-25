<?php

namespace App\Http\Repositories;

use App\Models\Establishment;

class EstablishmentRepository
{
    public function all()
    {
        return Establishment::orderBy('id')->where('active', 1)->get();
    }

    public function findById($id)
    {
        return Establishment::find($id);
    }

    public function store($request)
    {
        $model =  new Establishment;

        $model->description = strtoupper($request->description);
        $model->shortname = strtoupper($request->shortname);
        $model->user_created_id = auth()->id();

        $model->save();

        return $model->fresh();
    }


    public function update($model, $request)
    {
        $model->description = strtoupper($request->description);
        $model->shortname = strtoupper($request->shortname);
        $model->user_updated_id = auth()->id();

        $model->save();

        return $model->fresh();
    }

    public function delete($model, $request)
    {
        $model->active = 0;
        $model->user_updated_id = auth()->id();

        $model->save();

        return $model->fresh();
    }
}
