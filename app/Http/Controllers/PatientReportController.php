<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\PatientReport;
use Carbon\Carbon;

class PatientReportController extends Controller
{
    private $response;

    public function __construct(
        Response $response,
    ) {
        $this->response = $response;
    }
    /**
     * Validate the description field.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function validateData($request)
    {
        return Validator::make($request, [
            'patient_id' => 'required',
            'link_file' => 'required',
            'name_file' => 'required',
            'date_report' => 'required',
            'type_report_id' => 'required|integer',
            'establishment_id' => 'required|integer'
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

            $validate = $this->validateData($request->all());

            if ($validate->fails()) {
                return $this->response->internalServerError($exception);
            }

            $patientReport = new PatientReport;

            $patientReport->patient_id = $request->patient_id;
            $patientReport->link_file = $request->link_file;
            $patientReport->date_report = $request->date_report;
            $patientReport->name_file = $request->name_file;
            $patientReport->type_report_id = $request->type_report_id;
            $patientReport->establishment_id = $request->establishment_id;
            $patientReport->user_created_id = auth()->id();

            $patientReport->save();

            return $this->response->ok($patientReport->fresh());
        } catch (\Exception $exception) {
            return $this->response->exception($exception->getMessage());
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

    public function findByPatient($patient_id)
    {
        $patientReport = PatientReport::where('patient_id', $patient_id)
        ->with(['patient', 'typeReport', 'userCreated', 'establishment'])
        ->get();

        return $this->response->ok($patientReport);
    }

    public function downloadReportFile(Request $request)
    {
        //  return $request->all();
        return Storage::download($request->name);
    }

    public function uploadFileReport(Request $request)
    {
        try {
            $originalName   =  $request->file->getClientOriginalName();
            $upload_path    = storage_path('app');
            $name           = Carbon::now()->format('YmdHis')."-".$originalName;
            $file           = $request->file->move($upload_path, $name);
            $url            = Storage::url($name);
            $size           = Storage::size($name);
            $mime           = $request->file->getClientMimeType();

            $data = [
                'url' => $url,
                'name' => $name,
                'size' => $size,
                'mime' => $mime
            ];

            return $this->response->ok($data);
        } catch (\Exception $exception) {
            return $this->response->internalServerError($exception);
        }
    }


    public function removeFileReport(Request $request)
    {
        try {
            Storage::delete($request->name);

            return $this->response->ok(true);
        } catch (\Exception $exception) {
            return $this->response->internalServerError($exception);
        }
    }
}
