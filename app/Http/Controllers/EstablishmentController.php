<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Response;
use App\Http\Repositories\EstablishmentRepository;
use App\Http\Resources\Collection\EstablishmentCollection;
use App\Http\Resources\Object\EstablishmentObject;
use Illuminate\Support\Facades\Validator;

class EstablishmentController extends Controller
{
    private $response;
    private $establishmentRepository;

    public function __construct(
        Response $response,
        EstablishmentRepository $establishmentRepository
    ) {
        $this->response = $response;
        $this->establishmentRepository = $establishmentRepository;
    }

    /**
     * Validate the description field.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function validateData($request)
    {
        return Validator::make($request, [
            'description' => 'required|string',
            'shortname' => 'required|string'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            $collection = new EstablishmentCollection($this->establishmentRepository->all());

            return $this->response->ok($collection);
        } catch (\Exception $exception) {
            return $this->response->internalServerError($exception);
        }
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

            $model = $this->establishmentRepository->store($request);

            return $this->response->created(new EstablishmentObject($model));
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
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($id)) {
                return $this->response->badRequest();
            }

            $findModel = $this->establishmentRepository->findById($id);
            if (!isset($findModel)) {
                return $this->response->noContent();
            }

            $model = $this->establishmentRepository->update($findModel, $request);

            return $this->response->ok(new EstablishmentObject($model));
        } catch (\Exception $exception) {
            return $this->response->internalServerError($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (!request()->isJson()) {
                return $this->response->unauthorized();
            }

            if (!is_numeric($id)) {
                return $this->response->badRequest();
            }

            $findedModel = $this->establishmentRepository->findById($id);

            if (!isset($findedModel)) {
                return $this->response->noContent();
            }

            $this->establishmentRepository->delete($findedModel, $id);


            return $this->response->ok(null);
        } catch (\Exception $exception) {
            return $this->response->internalServerError($exception);
        }
    }
}
