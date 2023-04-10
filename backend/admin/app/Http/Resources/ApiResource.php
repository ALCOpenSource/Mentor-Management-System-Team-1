<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ApiResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
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

            // 100 series status codes are informational and is not considered successful or failure in this context,
            // 200 series status codes are considered successful,
            // 300 series are redirection, and is not considered successful or failure in this context,
            // 400 series are client errors,
            // 500 series are server errors
            'success' => $response->getStatusCode() >= 200 && $response->getStatusCode() < 300,

            // Metadata
            'links' => [],
            'meta' => [],
            'errors' => [],
            'message' => '',
            'code' => '',
        ];

        // Removes the default meta data from the response
        foreach ($default as $key => $value) {
            if (isset($this->collection[$key])) {
                $default[$key] = $this->collection[$key];
                unset($this->collection[$key]);
            }
        }

        // If response is paginated then add pagination data
        if ($this->resource instanceof AbstractPaginator) {
            $default['pagination'] = [
                'total' => $this->resource->total(),
                'count' => $this->resource->count(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage(),
                'links' => [
                    'previous' => $this->resource->previousPageUrl(),
                    'next' => $this->resource->nextPageUrl(),
                ],
            ];
        }

        // Merge the default meta data with the response data
        $response_data = array_merge(
            $default,
            [
                'data' => $this->collection->toArray(),
            ]
        );

        // Remove empty values
        $response_data = array_filter($response_data, function ($value) {
            if (is_array($value)) {
                return count($value) > 0;
            }

            if (is_bool($value) || is_numeric($value) || is_null($value)) {
                return true;
            }

            return ! empty($value);
        });

        // If the response is successful and data is not set then set it to an empty array
        if (true === $response_data['success'] && ! isset($response_data['data'])) {
            $response_data['data'] = [];
        }

        // Set the response status code
        $response->setStatusCode($response_data['status']);

        // Sets the response content
        $response->setContent(
            json_encode($response_data)
        );
    }
}
