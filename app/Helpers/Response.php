<?php

namespace App\Helpers;

use Carbon\Carbon;

class Response
{
    public function ok($data)
    {
        return $this->parseResponse('Consulta exitosa', 200, $data, true, false);
    }

    public function pagination($data)
    {
        return response()->json([
            'success' => true,
            'response' => $data,
            'message' => "Consulta exitosa",
            'error' => false,
            'timestamp' => Carbon::now()->format('d-m-Y H:i:s'),
            'statusCode' => 200
        ], 200);
    }

    public function created($data)
    {
        return $this->parseResponse('Recurso creado con éxito', 201, $data, true, false);
    }

    public function noContent()
    {
        return $this->parseResponse('No Content', 204, null, true, false);
    }

    public function badRequest($error = null)
    {
        return $this->parseResponse('Bad Request', 400);
    }

    public function unauthorized()
    {
        return $this->parseResponse('Unauthorized', 401);
    }

    public function forbbiden()
    {
        return $this->parseResponse('Forbidden', 403);
    }

    public function methodNotAllowed()
    {
        return $this->parseResponse('Method Not Allowed', 405);
    }

    public function notFound()
    {
        return $this->parseResponse('Not Found', 404);
    }

    public function internalServerError($error)
    {
        return $this->parseResponse($error->getMessage(), 500);
    }

    private function parseResponse($message, $statusCode, $data = null, $success = false, $error = true)
    {
        return response()->json([
      'success' => $success,
      'data' => $data,
      'message' => $message,
      'error' => $error,
      'timestamp' => Carbon::now()->format('d-m-Y H:i:s'),
      'statusCode' => $statusCode
    ], 200);
    }
}
