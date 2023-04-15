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
        // This is the default response
        $request->headers->set('Accept', 'application/json');

        return $this->collection->toArray();
    }

    /**
     * Add the additional meta data to the response.
     *
     * @param mixed $collection
     */
    protected function addHeaders(JsonResponse $response, $collection): void
    {
        if (isset($collection['headers'])) {
            foreach ($collection['headers'] as $key => $value) {
                $response->header($key, $value);
            }
            unset($collection['headers']);
        }
    }

    /**
     * Add the pagination meta data to the response.
     *
     * @param mixed $collection
     * @param mixed $default
     * @param mixed $resource
     */
    protected function addPaginator($resource, $default): void
    {
        if ($resource instanceof AbstractPaginator) {
            $default['meta']['pagination'] = [
                'total' => $resource->total(),
                'count' => $resource->count(),
                'per_page' => $resource->perPage(),
                'current_page' => $resource->currentPage(),
                'total_pages' => $resource->lastPage(),
                'links' => [
                    'previous' => $resource->previousPageUrl(),
                    'next' => $resource->nextPageUrl(),
                ],
            ];
        }
    }

    /**
     * Remove empty values from the response.
     *
     * @param array<string, mixed> $response_data
     */
    protected function removeEmptyData(&$response_data): void
    {
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
    }

    /**
     * Add the additional meta data to the response.
     */
    public function withResponse(Request $request, JsonResponse $response)
    {
        // Call the parent method
        // This servers to fix Codacy warning issue since we are currently overriding the method
        parent::withResponse($request, $response);

        // Default meta data
        $default = [
            'status' => $response->getStatusCode(),

            // Metadata
            'links' => [],
            'meta' => [],
            'errors' => [],
            'error' => '',
            'message' => '',
            'code' => '',
        ];

        // Removes the default meta data from the response
        foreach ($default as $key => $value) {
            if (isset($this->collection[$key])) {
                $default[$key] = $this->collection[$key];
                unset($this->collection[$key]);
            } elseif (! isset($this->collection[$key])) {
                // Set the default value, serves to fix Codacy warning issue
                $default[$key] = $value;
            }
        }

        // Get headers from the resource
        $this->addHeaders($response, $this->collection);
        $this->addPaginator($this->resource, $default);

        // Merge the default meta data with the response data
        $response_data = array_merge(
            $default,
            [
                'data' => $this->collection->toArray(),
            ]
        );

        // Sets the response status code
        /*
         * 100 series status codes are informational and is not considered successful or failure in this context,
         * 200 series status codes are considered successful,
         * 300 series are redirection, and is not considered successful or failure in this context,
         * 400 series are client errors,
         * 500 series are server errors
         * @see https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
         */
        $response_data['success'] = $response_data['status'] >= 200 && $response_data['status'] < 300;
        $response->setStatusCode($response_data['status'] ?? $response->getStatusCode());
        $this->removeEmptyData($response_data);

        // Sets the response content
        $response->header('Content-Type', 'application/json');
        $response->setContent(
            json_encode($response_data)
        );
    }
}
