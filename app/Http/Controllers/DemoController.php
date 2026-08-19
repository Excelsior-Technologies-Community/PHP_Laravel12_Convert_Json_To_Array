<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DemoController extends Controller
{
    /**
     * Example 1: Using json_decode() method
     *
     * @return response()
     */
    public function example1()
    {
        $jsonData = '[
            { "id": 1, "name": "Hardik", "email": "hardik@gmail.com"},
            { "id": 2, "name": "Vimal", "email": "vimal@gmail.com"},
            { "id": 3, "name": "Harshad", "email": "harshad@gmail.com"}
        ]';

        $data = json_decode($jsonData, true);

        return view('demo.example1', [
            'title' => 'Example 1: Using json_decode()',
            'method' => 'json_decode($json, true)',
            'originalJson' => $jsonData,
            'convertedArray' => $data
        ]);
    }

    /**
     * Example 2: Using json() method of HTTP response
     *
     * @return response()
     */
    public function example2()
    {
        try {
            $response = Http::get(
                'https://jsonplaceholder.typicode.com/posts/1'
            );

            $data = $response->json();

            return view('demo.example2', [
                'title' => 'Example 2: Using json() method',
                'method' => '$response->json()',
                'originalJson' => $response->body(),
                'convertedArray' => $data
            ]);
        } catch (\Exception $e) {
            return view('demo.error', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Example 3: Using Request's json() method
     *
     * @return response()
     */
    public function example3(Request $request)
    {
        $jsonData = '{
        "user": {
            "id": 101,
            "name": "John Doe",
            "profile": {
                "age": 28,
                "city": "New York",
                "skills": ["PHP", "Laravel", "JavaScript"]
            }
        }
    }';

        $fakeRequest = Request::create(
            '/',
            'GET',
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $jsonData
        );

        // Request::json() returns an InputBag.
        $jsonBag = $fakeRequest->json();

        // Convert InputBag into a normal PHP array.
        $data = $jsonBag->all();

        // Access nested values using Laravel's dot notation.
        $userName = $fakeRequest->json('user.name');
        $userSkills = $fakeRequest->json('user.profile.skills');

        return view('demo.example3', [
            'title' => 'Example 3: Using Request json() method',
            'method' => '$request->json() or $request->json(\'path.to.data\')',
            'originalJson' => $jsonData,

            // Send normal array to Blade.
            'convertedArray' => $data,

            'userName' => $userName,
            'userSkills' => $userSkills,
        ]);
    }
    /**
     * Example 4: Using Laravel Collection
     *
     * @return response()
     */
    public function example4()
    {
        $jsonData = '[
            {"id": 1, "product": "Laptop", "price": 999.99, "in_stock": true},
            {"id": 2, "product": "Mouse", "price": 29.99, "in_stock": true},
            {"id": 3, "product": "Keyboard", "price": 89.99, "in_stock": false},
            {"id": 4, "product": "Monitor", "price": 299.99, "in_stock": true}
        ]';

        $collection = collect(json_decode($jsonData, true));

        $inStockProducts = $collection->where('in_stock', true);
        $totalValue = $collection->sum('price');
        $averagePrice = $collection->avg('price');

        return view('demo.example4', [
            'title' => 'Example 4: Using Laravel Collection',
            'method' => 'collect(json_decode($json, true))',
            'originalJson' => $jsonData,
            'convertedArray' => $collection->toArray(),
            'inStockProducts' => $inStockProducts->toArray(),
            'totalValue' => $totalValue,
            'averagePrice' => $averagePrice
        ]);
    }

    /**
     * Home page with all examples
     *
     * @return response()
     */
    public function index()
    {
        return view('demo.index', [
            'title' => 'Laravel 12 - JSON to Array Conversion Examples'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | New Functionality 1: JSON Validator & Diagnostics
    |--------------------------------------------------------------------------
    */

    /**
     * Display JSON Validator page.
     *
     * @return response()
     */
    public function jsonValidator()
    {
        return view('demo.json-validator', [
            'title' => 'JSON Validator & Diagnostics',
            'jsonInput' => null,
            'isValid' => null,
            'errorMessage' => null,
            'errorCode' => null,
            'decodedData' => null,
            'jsonType' => null,
            'itemCount' => null,
        ]);
    }

    /**
     * Validate and decode JSON.
     *
     * @param Request $request
     * @return response()
     */
    public function validateJson(Request $request)
    {
        $request->validate([
            'json' => [
                'required',
                'string',
                'max:100000',
            ],
        ]);

        $jsonInput = $request->input('json');

        $decodedData = json_decode($jsonInput, true);

        $errorCode = json_last_error();
        $errorMessage = json_last_error_msg();

        if ($errorCode !== JSON_ERROR_NONE) {
            return view('demo.json-validator', [
                'title' => 'JSON Validator & Diagnostics',
                'jsonInput' => $jsonInput,
                'isValid' => false,
                'errorMessage' => $errorMessage,
                'errorCode' => $errorCode,
                'decodedData' => null,
                'jsonType' => null,
                'itemCount' => null,
            ]);
        }

        $jsonType = gettype($decodedData);

        if (is_array($decodedData)) {
            $itemCount = count($decodedData);
        } else {
            $itemCount = 1;
        }

        return view('demo.json-validator', [
            'title' => 'JSON Validator & Diagnostics',
            'jsonInput' => $jsonInput,
            'isValid' => true,
            'errorMessage' => $errorMessage,
            'errorCode' => $errorCode,
            'decodedData' => $decodedData,
            'jsonType' => $jsonType,
            'itemCount' => $itemCount,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | New Functionality 2: JSON Collection Explorer
    |--------------------------------------------------------------------------
    */

    /**
     * Display JSON Collection Explorer.
     *
     * @return response()
     */
    public function jsonExplorer()
    {
        $defaultJson = '[
    {
        "id": 1,
        "product": "Laptop",
        "category": "Electronics",
        "price": 999.99,
        "in_stock": true
    },
    {
        "id": 2,
        "product": "Mouse",
        "category": "Accessories",
        "price": 29.99,
        "in_stock": true
    },
    {
        "id": 3,
        "product": "Keyboard",
        "category": "Accessories",
        "price": 89.99,
        "in_stock": false
    },
    {
        "id": 4,
        "product": "Monitor",
        "category": "Electronics",
        "price": 299.99,
        "in_stock": true
    },
    {
        "id": 5,
        "product": "Headphones",
        "category": "Audio",
        "price": 149.99,
        "in_stock": true
    }
]';

        return view('demo.json-explorer', [
            'title' => 'JSON Collection Explorer',
            'jsonInput' => $defaultJson,
            'results' => null,
            'originalData' => null,
            'search' => '',
            'filterField' => '',
            'filterValue' => '',
            'sortField' => '',
            'sortDirection' => 'asc',
            'errorMessage' => null,
            'totalItems' => null,
            'resultCount' => null,
        ]);
    }

    /**
     * Convert JSON to Collection and explore the data.
     *
     * @param Request $request
     * @return response()
     */
    public function exploreJson(Request $request)
    {
        $request->validate([
            'json' => [
                'required',
                'string',
                'max:100000',
            ],
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],
            'filter_field' => [
                'nullable',
                'string',
                'max:100',
            ],
            'filter_value' => [
                'nullable',
                'string',
                'max:100',
            ],
            'sort_field' => [
                'nullable',
                'string',
                'max:100',
            ],
            'sort_direction' => [
                'nullable',
                'in:asc,desc',
            ],
        ]);

        $jsonInput = $request->input('json');

        $decodedData = json_decode($jsonInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return view('demo.json-explorer', [
                'title' => 'JSON Collection Explorer',
                'jsonInput' => $jsonInput,
                'results' => null,
                'originalData' => null,
                'search' => $request->input('search', ''),
                'filterField' => $request->input('filter_field', ''),
                'filterValue' => $request->input('filter_value', ''),
                'sortField' => $request->input('sort_field', ''),
                'sortDirection' => $request->input('sort_direction', 'asc'),
                'errorMessage' => json_last_error_msg(),
                'totalItems' => null,
                'resultCount' => null,
            ]);
        }

        if (!is_array($decodedData)) {
            return view('demo.json-explorer', [
                'title' => 'JSON Collection Explorer',
                'jsonInput' => $jsonInput,
                'results' => null,
                'originalData' => $decodedData,
                'search' => $request->input('search', ''),
                'filterField' => $request->input('filter_field', ''),
                'filterValue' => $request->input('filter_value', ''),
                'sortField' => $request->input('sort_field', ''),
                'sortDirection' => $request->input('sort_direction', 'asc'),
                'errorMessage' => 'The JSON must contain an array of objects.',
                'totalItems' => null,
                'resultCount' => null,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Convert decoded JSON array into Laravel Collection
        |--------------------------------------------------------------------------
        */

        $collection = collect($decodedData);

        $originalData = $collection->values()->toArray();

        $totalItems = $collection->count();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search = trim($request->input('search', ''));

        if ($search !== '') {
            $collection = $collection->filter(function ($item) use ($search) {
                if (!is_array($item)) {
                    return str_contains(
                        strtolower((string) $item),
                        strtolower($search)
                    );
                }

                foreach ($item as $value) {
                    if (is_array($value)) {
                        continue;
                    }

                    if (
                        str_contains(
                            strtolower((string) $value),
                            strtolower($search)
                        )
                    ) {
                        return true;
                    }
                }

                return false;
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by field/value
        |--------------------------------------------------------------------------
        */

        $filterField = trim($request->input('filter_field', ''));
        $filterValue = trim($request->input('filter_value', ''));

        if ($filterField !== '' && $filterValue !== '') {
            $collection = $collection->filter(function ($item) use (
                $filterField,
                $filterValue
            ) {
                if (!is_array($item)) {
                    return false;
                }

                if (!array_key_exists($filterField, $item)) {
                    return false;
                }

                $value = $item[$filterField];

                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                }

                return strtolower((string) $value) === strtolower($filterValue);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $sortField = trim($request->input('sort_field', ''));
        $sortDirection = $request->input('sort_direction', 'asc');

        if ($sortField !== '') {
            if ($sortDirection === 'desc') {
                $collection = $collection->sortByDesc(
                    fn($item) => is_array($item)
                        ? ($item[$sortField] ?? null)
                        : null
                );
            } else {
                $collection = $collection->sortBy(
                    fn($item) => is_array($item)
                        ? ($item[$sortField] ?? null)
                        : null
                );
            }
        }

        $results = $collection->values();

        return view('demo.json-explorer', [
            'title' => 'JSON Collection Explorer',
            'jsonInput' => $jsonInput,
            'results' => $results,
            'originalData' => $originalData,
            'search' => $search,
            'filterField' => $filterField,
            'filterValue' => $filterValue,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'errorMessage' => null,
            'totalItems' => $totalItems,
            'resultCount' => $results->count(),
        ]);
    }
}
