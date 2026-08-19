<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DemoController extends Controller
{
    /**
     * Example 1: Using json_decode() method
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

        $jsonBag = $fakeRequest->json();

        $data = $jsonBag->all();

        $userName = $fakeRequest->json('user.name');
        $userSkills = $fakeRequest->json('user.profile.skills');

        return view('demo.example3', [
            'title' => 'Example 3: Using Request json() method',
            'method' => '$request->json() or $request->json(\'path.to.data\')',
            'originalJson' => $jsonData,
            'convertedArray' => $data,
            'userName' => $userName,
            'userSkills' => $userSkills,
        ]);
    }

    /**
     * Example 4: Using Laravel Collection
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
     * Home page
     */
    public function index()
    {
        return view('demo.index', [
            'title' => 'Laravel 12 - JSON to Array Conversion Examples'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Feature 1: JSON Validator
    |--------------------------------------------------------------------------
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

    public function validateJson(Request $request)
    {
        $request->validate([
            'json' => 'required|string|max:100000',
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

        $itemCount = is_array($decodedData)
            ? count($decodedData)
            : 1;

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
    | Feature 2-7: JSON Explorer
    |--------------------------------------------------------------------------
    */

    public function jsonExplorer()
    {
        $defaultJson = $this->defaultJson();

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

            'perPage' => 5,
            'currentPage' => 1,
            'totalPages' => 0,

            'statistics' => null,

            'errorMessage' => null,
            'totalItems' => null,
            'resultCount' => null,
        ]);
    }

    /**
     * Search + Filter + Sort + Pagination + Statistics
     */
    public function exploreJson(Request $request)
    {
        $request->validate([
            'json' => 'required|string|max:100000',

            'search' => 'nullable|string|max:100',

            'filter_field' => 'nullable|string|max:100',

            'filter_value' => 'nullable|string|max:100',

            'sort_field' => 'nullable|string|max:100',

            'sort_direction' => 'nullable|in:asc,desc',

            'per_page' => 'nullable|integer|in:5,10,15,20,50',

            'page' => 'nullable|integer|min:1',
        ]);

        $jsonInput = $request->input('json');

        $search = trim($request->input('search', ''));

        $filterField = trim($request->input('filter_field', ''));

        $filterValue = trim($request->input('filter_value', ''));

        $sortField = trim($request->input('sort_field', ''));

        $sortDirection = $request->input('sort_direction', 'asc');

        $perPage = (int) $request->input('per_page', 5);

        $page = max((int) $request->input('page', 1), 1);

        /*
        |--------------------------------------------------------------------------
        | JSON Decode / Validation
        |--------------------------------------------------------------------------
        */

        $decodedData = json_decode($jsonInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->explorerError(
                $jsonInput,
                json_last_error_msg(),
                $search,
                $filterField,
                $filterValue,
                $sortField,
                $sortDirection,
                $perPage
            );
        }

        if (!is_array($decodedData)) {
            return $this->explorerError(
                $jsonInput,
                'The JSON must contain an array of objects.',
                $search,
                $filterField,
                $filterValue,
                $sortField,
                $sortDirection,
                $perPage
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Convert JSON → Collection
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
        | Filter
        |--------------------------------------------------------------------------
        */

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

                return strtolower((string) $value)
                    === strtolower($filterValue);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Sort
        |--------------------------------------------------------------------------
        */

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

        $collection = $collection->values();

        $resultCount = $collection->count();

        /*
        |--------------------------------------------------------------------------
        | Feature 6: Statistics
        |--------------------------------------------------------------------------
        */

        $statistics = $this->calculateStatistics($decodedData);

        /*
        |--------------------------------------------------------------------------
        | Feature 5: Pagination
        |--------------------------------------------------------------------------
        */

        $totalPages = max(
            (int) ceil($resultCount / $perPage),
            1
        );

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $results = $collection
            ->forPage($page, $perPage)
            ->values();

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

            'perPage' => $perPage,

            'currentPage' => $page,

            'totalPages' => $totalPages,

            'statistics' => $statistics,

            'errorMessage' => null,

            'totalItems' => $totalItems,

            'resultCount' => $resultCount,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Feature 7: JSON Export
    |--------------------------------------------------------------------------
    */

    public function exportJson(Request $request)
    {
        $data = $this->processExportData($request);

        return response()->streamDownload(
            function () use ($data) {

                echo json_encode(
                    $data,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                );
            },
            'converted-data.json',
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Feature 7: CSV Export
    |--------------------------------------------------------------------------
    */

    public function exportCsv(Request $request)
    {
        $data = $this->processExportData($request);

        return new StreamedResponse(function () use ($data) {

            $handle = fopen('php://output', 'w');

            if (empty($data)) {
                fputcsv($handle, ['No data found']);

                fclose($handle);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Find all columns
            |--------------------------------------------------------------------------
            */

            $headers = [];

            foreach ($data as $row) {

                if (is_array($row)) {

                    foreach ($row as $key => $value) {

                        if (!in_array($key, $headers, true)) {
                            $headers[] = $key;
                        }
                    }
                }
            }

            fputcsv($handle, $headers);

            /*
            |--------------------------------------------------------------------------
            | Rows
            |--------------------------------------------------------------------------
            */

            foreach ($data as $row) {

                $csvRow = [];

                foreach ($headers as $header) {

                    $value = is_array($row)
                        ? ($row[$header] ?? '')
                        : '';

                    if (is_array($value)) {
                        $value = json_encode($value);
                    }

                    if (is_bool($value)) {
                        $value = $value ? 'true' : 'false';
                    }

                    $csvRow[] = $value;
                }

                fputcsv($handle, $csvRow);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',

            'Content-Disposition' =>
            'attachment; filename="converted-data.csv"',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Process data for export
    |--------------------------------------------------------------------------
    */

    private function processExportData(Request $request): array
    {
        $decodedData = json_decode(
            $request->input('json', ''),
            true
        );

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }

        if (!is_array($decodedData)) {
            return [];
        }

        $collection = collect($decodedData);

        $search = trim(
            $request->input('search', '')
        );

        $filterField = trim(
            $request->input('filter_field', '')
        );

        $filterValue = trim(
            $request->input('filter_value', '')
        );

        $sortField = trim(
            $request->input('sort_field', '')
        );

        $sortDirection = $request->input(
            'sort_direction',
            'asc'
        );

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $collection = $collection->filter(
                function ($item) use ($search) {

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
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        if (
            $filterField !== '' &&
            $filterValue !== ''
        ) {

            $collection = $collection->filter(
                function ($item) use (
                    $filterField,
                    $filterValue
                ) {

                    if (!is_array($item)) {
                        return false;
                    }

                    if (
                        !array_key_exists(
                            $filterField,
                            $item
                        )
                    ) {
                        return false;
                    }

                    $value = $item[$filterField];

                    if (is_bool($value)) {
                        $value = $value
                            ? 'true'
                            : 'false';
                    }

                    return strtolower(
                        (string) $value
                    ) === strtolower(
                        $filterValue
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sort
        |--------------------------------------------------------------------------
        */

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

        return $collection
            ->values()
            ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Statistics
    |--------------------------------------------------------------------------
    */

    private function calculateStatistics(array $data): array
    {
        $statistics = [
            'total_records' => count($data),

            'total_fields' => 0,

            'string_values' => 0,

            'numeric_values' => 0,

            'boolean_values' => 0,

            'null_values' => 0,

            'array_values' => 0,

            'object_values' => 0,
        ];

        foreach ($data as $item) {

            if (is_array($item)) {

                $statistics['total_fields'] += count($item);

                foreach ($item as $value) {

                    if (is_string($value)) {
                        $statistics['string_values']++;
                    } elseif (is_numeric($value)) {
                        $statistics['numeric_values']++;
                    } elseif (is_bool($value)) {
                        $statistics['boolean_values']++;
                    } elseif (is_null($value)) {
                        $statistics['null_values']++;
                    } elseif (is_array($value)) {
                        $statistics['array_values']++;
                    }
                }
            }
        }

        $statistics['object_values'] = count(
            array_filter(
                $data,
                fn($item) => is_array($item)
            )
        );

        return $statistics;
    }

    /*
    |--------------------------------------------------------------------------
    | Explorer error
    |--------------------------------------------------------------------------
    */

    private function explorerError(
        string $jsonInput,
        string $errorMessage,
        string $search,
        string $filterField,
        string $filterValue,
        string $sortField,
        string $sortDirection,
        int $perPage
    ) {
        return view('demo.json-explorer', [
            'title' => 'JSON Collection Explorer',

            'jsonInput' => $jsonInput,

            'results' => null,

            'originalData' => null,

            'search' => $search,

            'filterField' => $filterField,

            'filterValue' => $filterValue,

            'sortField' => $sortField,

            'sortDirection' => $sortDirection,

            'perPage' => $perPage,

            'currentPage' => 1,

            'totalPages' => 0,

            'statistics' => null,

            'errorMessage' => $errorMessage,

            'totalItems' => null,

            'resultCount' => null,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Default JSON
    |--------------------------------------------------------------------------
    */

    private function defaultJson(): string
    {
        return '[
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
            },
            {
                "id": 6,
                "product": "Webcam",
                "category": "Accessories",
                "price": 79.99,
                "in_stock": true
            },
            {
                "id": 7,
                "product": "Printer",
                "category": "Office",
                "price": 199.99,
                "in_stock": false
            },
            {
                "id": 8,
                "product": "Tablet",
                "category": "Electronics",
                "price": 399.99,
                "in_stock": true
            }
        ]';
    }
}
