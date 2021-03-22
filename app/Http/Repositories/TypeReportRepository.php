<?php

namespace App\Http\Repositories;

use App\Models\TypeReport;

class TypeReportRepository
{
    public function all()
    {
        return TypeReport::orderBy('id')->where('active', 1)->get();
    }

    public function findById($id)
    {
        return TypeReport::find($id);
    }

    public function store($request)
    {
        $model =  new TypeReport;

        $model->description = strtoupper($request->description);
        $model->user_created_id = auth()->id();

        $model->save();

        return $model->fresh();
    }


    public function update($model, $request)
    {
        $model->description = strtoupper($request->description);
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
