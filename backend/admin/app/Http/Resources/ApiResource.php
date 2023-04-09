<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * Add the additional meta data to the response.
     *
     * @return void
     */
    public function withResponse(Request $request, JsonResponse $response)
    {
        $default = [
            'status' => $response->getStatusCode(),

            // 200 series status codes are considered successful,
            // 300 series are redirection, and is considered successful,
            // 400 series are client errors, 500 series are server errors
            'success' => $response->getStatusCode() >= 200 && $response->getStatusCode() < 300,
        ];

        $response->setContent(
            json_encode(
                array_merge($default, json_decode($response->getContent(), true))
            )
        );
    }
}
