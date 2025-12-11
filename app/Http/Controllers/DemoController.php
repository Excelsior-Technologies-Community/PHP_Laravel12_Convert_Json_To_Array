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
        // JSON data as string
        $jsonData = '[
            { "id": 1, "name": "Hardik", "email": "hardik@gmail.com"},
            { "id": 2, "name": "Vimal", "email": "vimal@gmail.com"},
            { "id": 3, "name": "Harshad", "email": "harshad@gmail.com"}
        ]';

        // Convert JSON to array using json_decode()
        $data = json_decode($jsonData, true);

        // Return view with data
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
            // Fetch data from API
            $response = Http::get('https://jsonplaceholder.typicode.com/posts/1');

            // Convert JSON response to array using json() method
            $data = $response->json();

            // Return view with data
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
        // JSON data for demonstration
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

        // Create a request with JSON content
        $fakeRequest = Request::create('/', 'GET', [], [], [], [], $jsonData);

        // Get JSON as InputBag
        $data = $fakeRequest->json();

        // Get specific values using dot notation
        $userName = $fakeRequest->json('user.name');
        $userSkills = $fakeRequest->json('user.profile.skills');

        return view('demo.example3', [
            'title' => 'Example 3: Using Request json() method',
            'method' => '$request->json() or $request->json(\'path.to.data\')',
            'originalJson' => $jsonData,
            'convertedArray' => $data, // This is an InputBag object
            'userName' => $userName,
            'userSkills' => $userSkills
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

        // Convert JSON to collection
        $collection = collect(json_decode($jsonData, true));

        // Use collection methods
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
}