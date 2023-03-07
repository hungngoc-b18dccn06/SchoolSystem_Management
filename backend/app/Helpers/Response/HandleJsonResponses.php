<?php

namespace App\Helpers\Response;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HandleJsonResponses
{
    use ApiResponseFormatter;

    /**
     * The response status code.
     *
     * @var int
     */
    protected $customResponse;

    /**
     * The response message.
     *
     * @var string
     */
    protected $message;

    /**
     * The latest response returned.
     *
     * @var \Illuminate\Http\JsonResponse
     */
    public $response;

    /**
     * The addition data
     *
     * @var object
     */
    public $meta;

    /**
     * Response OK (200).
     *
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_OK, $data['message'])->withoutErrors($params, $headers);
    }

    /**
     * Response Created (201)
     *
     * @param array $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_CREATED, $data['message'])->withoutErrors($params, $headers);
    }

    /**
     * Response Bad Request (400).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondBadRequest($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_BAD_REQUEST, $data['message'])->withErrors($params, $headers);
    }

    /**
     * Response Unauthorized (401).
     *
     * @param  array $data
     * @param  array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnauthorized($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_UNAUTHORIZED, $data['message'])->withErrors($params, $headers);
    }

    /**
     * Response forbidden (403).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondForbidden($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_FORBIDDEN, $data['message'])->withErrors($params, $headers);
    }

    /**
     * Response Not Found (404).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_NOT_FOUND, $data['message'])->withErrors($params, $headers);
    }

    /**
     * Response Unprocessable Entity (422).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnprocessableEntity($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $data['message'])->withErrors($params, $headers);
    }

    /**
     * Response Method Not Allowed (405).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondMethodNotAllowed($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_METHOD_NOT_ALLOWED, $data['message'])->withErrors($params, $headers);
    }

    /**
     * Response Internal Server Error (500).
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalServerError($data = [], $headers = [])
    {
        $params = $data['data'] ?? [];

        return $this->customResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $data['message'])->withErrors($params, $headers);
    }

    /**
     * Generic JSON response.
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data = [], $headers = [])
    {
        $this->response = new JsonResponse($data, $this->customResponse, $headers);

        return $this->response;
    }

    /**
     * Generic error response.
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withErrors($data = [], $headers = [])
    {
        return $this->respond($this->formatResponse($data, true), $headers);
    }

    /**
     * Generic success response.
     *
     * @param  array $data
     * @param  array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withoutErrors($data = [], $headers = [])
    {
        return $this->respond($this->formatResponse($data, false), $headers);
    }

    /**
     * Format the data for the response.
     *
     * @param  array $data
     * @param  boolean $error
     *
     * @return array
     */
    public function formatResponse($data = [], $error = false)
    {
        return $this->formatDataForApiResponse($data, $this->message, $this->customResponse, $error, $this->meta);
    }

    /**
     * Set the message for the response.
     *
     * @param string $message
     *
     * @return $this
     */
    public function message($message = '')
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param null $meta
     * @return $this
     */
    public function meta($meta = null)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Set the custom response
     *
     * @param int $code
     * @param string $message
     *
     * @return $this
     */
    public function customResponse($code, $message)
    {
        $this->customResponse = $code;
        $this->message = $message;

        return $this;
    }
}
