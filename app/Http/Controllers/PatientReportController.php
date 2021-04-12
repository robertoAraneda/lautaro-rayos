<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Response;
use Illuminate\Support\Facades\Storage;

class PatientReportController extends Controller
{
    private $response;

    public function __construct(
        Response $response,
    ) {
        $this->response = $response;
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
        //
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

    public function uploadFileReport(Request $request)
    {
        try {
            $upload_path    = storage_path('app');
            $name           = $request->file->getClientOriginalName();
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
