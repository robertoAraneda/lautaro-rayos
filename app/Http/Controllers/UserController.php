<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Response;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\Collection\UserCollection;

class UserController extends Controller
{
    private $response;
    private $userRepository;

    public function __construct(
        Response $response,
        UserRepository $userRepository
    ) {
        $this->response = $response;
        $this->userRepository = $userRepository;
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

            $collection = new UserCollection($this->userRepository->all());

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
}
