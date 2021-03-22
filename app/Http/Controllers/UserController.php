<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Response;
use App\Http\Repositories\UserRepository;
use App\Http\Resources\Collection\UserCollection;
use App\Http\Resources\Object\UserObject;

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

            $userModel = $this->userRepository->findById($id);
            if (!isset($userModel)) {
                return $this->response->noContent();
            }

            $enail = \strtolower($request->email);

            $checkEmailUser = $this->userRepository->findByEmail($enail);

            if ($checkEmailUser) {
                if ($userModel->id != $checkEmailUser->id) {
                    return $this->response->customMessageResponse('Email ya existe', 406);
                }
            }

            $user = $this->userRepository->update($userModel, $request);

            return $this->response->ok(new UserObject($user));
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

            $userModel = $this->userRepository->findById($id);

            if (!isset($userModel)) {
                return $this->response->noContent();
            }

            $userModel->delete();

            return $this->response->ok(null);
        } catch (\Exception $exception) {
            return $this->response->internalServerError($exception);
        }
    }
}
