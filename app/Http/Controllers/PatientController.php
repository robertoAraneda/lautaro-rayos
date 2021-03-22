<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Response;
use App\Http\Repositories\PatientRepository;
use App\Http\Resources\Collection\PatientCollection;
use App\Http\Resources\Object\PatientObject;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    private $response;
    private $typeReportRepository;

    public function __construct(
        Response $response,
        PatientRepository $patientRepository
    ) {
        $this->response = $response;
        $this->patientRepository = $patientRepository;
    }

    /**
     * Validate the description field.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function validateData($request)
    {
        return Validator::make($request, [
            'rut'               => 'required',
            'bdup'              => 'required',
            'names'             => 'required',
            'lastname'          => 'required',
            'mother_lastname'   => 'required',
            'email'             => 'required',
            'phone'             => 'required',
        ]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $validate = $this->validateData(request()->all());

            if ($validate->fails()) {
                return $this->response->customMessageResponse(($validate->errors()), 406);
            }

            $model = $this->patientRepository->store($request);

            return $this->response->created(new PatientObject($model));
        } catch (\Exception $ex) {
            return $this->response->internalServerError($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function findPatientByDemographics(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }


            $names              = $request->names;
            $lastname           = $request->lastname;
            $mother_lastname    = $request->mother_lastname;

            $attributes         = [];

            if (!empty($names) &&  $names != '') {
                $attributes[] = [
                    'field' => 'names',
                    'value' =>  strtoupper($names)
            ];
            }
            if (!empty($lastname) && $lastname != '') {
                $attributes[] = [
                    'field' => 'lastname',
                    'value' =>  strtoupper($lastname)
                ];
            }
            if (!empty($mother_lastname) && $mother_lastname != '') {
                $attributes[] = [
                    'field' => 'mother_lastname',
                    'value' =>  strtoupper($mother_lastname)
                ];
            }

            $findedModels = $this->patientRepository->findByDemographics($attributes);

            if (!isset($findedModels)) {
                return $this->response->noContent();
            }
            // return $findedModels;

            return $this->response->ok(new PatientCollection($findedModels));
        } catch (\Exception $ex) {
            return $this->response->internalServerError($ex);
        }
    }

    public function findByRut(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $rut        = $request->rut;
            $findModel  =  $this->patientRepository->findByRut($rut);

            if (!isset($findModel)) {
                return $this->response->noContent();
            }
            return $this->response->ok(new PatientCollection([  $findModel ]));
        } catch (\Exception $ex) {
            return $this->response->internalServerError($ex);
        }
    }
    public function findByBdup(Request $request)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $bdup       = $request->bdup;
            $findModel  = $this->patientRepository->findByRut($bdup);

            if (!isset($findModel)) {
                return $this->response->noContent();
            }
            return $this->response->ok(new PatientCollection([  $findModel ]));
        } catch (\Exception $ex) {
            return $this->response->internalServerError($ex);
        }
    }
}
