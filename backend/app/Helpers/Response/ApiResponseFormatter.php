<?php

namespace App\Helpers\Response;

trait ApiResponseFormatter
{
    /**
     * Format data for API response.
     * @param array $data
     * @param string $customMessage
     * @param null $statusCode
     * @param bool $error
     * @param null $meta
     * @return array
     */
    public function formatDataForApiResponse($data = [], $customMessage = '', $statusCode = null, $error = false, $meta = null)
    {
        $final = [];

        if (!empty($data)) {
            if ($error) {
                $final = array_merge($final, ['errors' => $data]);
            } else {
                $final = array_merge($final, ['data' => $data]);
            }
        }

        $final = array_merge($final, [
            'code' => $statusCode
        ]);

        $message = null;

        if (!empty($customMessage)) {
            $message = $customMessage;
        }

        if ($message) {
            $final = array_merge($final, ['message' => $message]);
        }

        if ($meta) {
            $final = array_merge($final, ['meta' => $meta]);
        }

        return $final;
    }
}
