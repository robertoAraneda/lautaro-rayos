<?php

namespace App\Http\Repositories;

use App\Models\Patient;

class PatientRepository
{
    public function findById($id)
    {
        return Patient::find($id);
    }

    public function findByRut($rut)
    {
        return Patient::where('rut', $rut)->first();
    }

    public function findByBdup($bdup)
    {
        return Patient::where('bdup', $bdup)->first();
    }

    public function findByDemographics($demographics)
    {
        $numberOfAttributes = count($demographics);

        $query = Patient::query();
        $query->where('active', 1);

        for ($i=0; $i < $numberOfAttributes ; $i++) {
            $value = "%{$demographics[$i]['value']}%";
            $operator = 'like';

            $query = $query->where($demographics[$i]['field'], $operator, $value);
        }

        return $query->get();
    }

    public function store($request)
    {
        $model =  new Patient;

        $model->rut = strtoupper($request->rut);
        $model->bdup = strtoupper($request->bdup);
        $model->names = strtoupper($request->names);
        $model->lastname = strtoupper($request->lastname);
        $model->mother_lastname = strtoupper($request->mother_lastname);
        $model->birthdate = strtoupper($request->birthdate);
        $model->email = strtolower($request->email);
        $model->phone = strtoupper($request->phone);
        $model->user_created_id = auth()->id();
        $model->user_created_ip = $request->ip();

        $model->save();

        return $model->fresh();
    }
}
