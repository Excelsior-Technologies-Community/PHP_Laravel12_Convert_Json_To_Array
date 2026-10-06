<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JsonSourceSeederController extends Controller
{
    /**
     * Display Source & Seeder Studio
     */
    public function index(Request $request)
    {
        $sampleUrls = [
            'https://jsonplaceholder.typicode.com/users' => 'JSONPlaceholder Users API',
            'https://jsonplaceholder.typicode.com/posts' => 'JSONPlaceholder Posts API',
            'https://dummyjson.com/products?limit=5' => 'DummyJSON Products API',
        ];

        return view('json_seeder.index', [
            'title' => 'Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio',
            'sampleUrls' => $sampleUrls,
            'urlResult' => null,
            'fileResult' => null,
            'seederCode' => null,
            'errorMessage' => null,
            'activeTab' => 'url',
        ]);
    }

    /**
     * Process External API / Remote URL Fetcher
     */
    public function fetchUrl(Request $request)
    {
        $url = trim($request->input('url', ''));
        $sampleUrls = [
            'https://jsonplaceholder.typicode.com/users' => 'JSONPlaceholder Users API',
            'https://jsonplaceholder.typicode.com/posts' => 'JSONPlaceholder Posts API',
            'https://dummyjson.com/products?limit=5' => 'DummyJSON Products API',
        ];

        try {
            if (empty($url)) {
                throw new \Exception('Please enter a valid HTTP/HTTPS API URL.');
            }

            $startTime = microtime(true);
            $response = Http::timeout(10)->headers([
                'User-Agent' => 'Laravel-JSON-Parser-Agent/1.0'
            ])->get($url);
            $executionMs = round((microtime(true) - $startTime) * 1000, 2);

            if ($response->failed()) {
                throw new \Exception("HTTP Request failed with status: {$response->status()}");
            }

            $jsonData = $response->json();
            $collection = collect(is_array($jsonData) ? $jsonData : [$jsonData]);

            $urlResult = [
                'url' => $url,
                'status' => $response->status(),
                'latency_ms' => $executionMs,
                'content_type' => $response->header('Content-Type', 'application/json'),
                'size_bytes' => strlen($response->body()),
                'array_data' => $collection->take(10)->toArray(),
                'total_count' => $collection->count(),
                'raw_json' => $response->body(),
            ];

            return view('json_seeder.index', [
                'title' => 'Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio',
                'sampleUrls' => $sampleUrls,
                'urlResult' => $urlResult,
                'fileResult' => null,
                'seederCode' => null,
                'errorMessage' => null,
                'activeTab' => 'url',
            ]);
        } catch (\Exception $e) {
            return view('json_seeder.index', [
                'title' => 'Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio',
                'sampleUrls' => $sampleUrls,
                'urlResult' => null,
                'fileResult' => null,
                'seederCode' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'url',
            ]);
        }
    }

    /**
     * Process File Uploader & Memory Usage Benchmark
     */
    public function uploadFile(Request $request)
    {
        $sampleUrls = [
            'https://jsonplaceholder.typicode.com/users' => 'JSONPlaceholder Users API',
            'https://jsonplaceholder.typicode.com/posts' => 'JSONPlaceholder Posts API',
            'https://dummyjson.com/products?limit=5' => 'DummyJSON Products API',
        ];

        try {
            $request->validate([
                'json_file' => 'required|file|max:10240', // Max 10MB
            ]);

            $file = $request->file('json_file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            $memBefore = memory_get_usage();
            $startTime = microtime(true);

            $contents = file_get_contents($file->getPathname());
            $decoded = json_decode($contents, true);

            $executionMs = round((microtime(true) - $startTime) * 1000, 2);
            $memAfter = memory_get_usage();
            $peakMemory = memory_get_peak_usage();
            $memoryUsedMb = round(($memAfter - $memBefore) / 1024 / 1024, 4);
            $peakMemoryMb = round($peakMemory / 1024 / 1024, 2);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON File Parse Error: ' . json_last_error_msg());
            }

            $fileResult = [
                'file_name' => $fileName,
                'file_size_kb' => round($fileSize / 1024, 2),
                'latency_ms' => $executionMs,
                'memory_used_mb' => $memoryUsedMb,
                'peak_memory_mb' => $peakMemoryMb,
                'data_type' => gettype($decoded),
                'item_count' => is_array($decoded) ? count($decoded) : 1,
                'array_preview' => is_array($decoded) ? array_slice($decoded, 0, 10) : $decoded,
                'raw_json' => $contents,
            ];

            return view('json_seeder.index', [
                'title' => 'Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio',
                'sampleUrls' => $sampleUrls,
                'urlResult' => null,
                'fileResult' => $fileResult,
                'seederCode' => null,
                'errorMessage' => null,
                'activeTab' => 'file',
            ]);
        } catch (\Exception $e) {
            return view('json_seeder.index', [
                'title' => 'Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio',
                'sampleUrls' => $sampleUrls,
                'urlResult' => null,
                'fileResult' => null,
                'seederCode' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'file',
            ]);
        }
    }

    /**
     * Process 1-Click Database Persistence / Seeder Generator
     */
    public function generateSeeder(Request $request)
    {
        $jsonInput = $request->input('json', '');
        $tableName = Str::snake($request->input('table_name', 'json_records'));

        $sampleUrls = [
            'https://jsonplaceholder.typicode.com/users' => 'JSONPlaceholder Users API',
            'https://jsonplaceholder.typicode.com/posts' => 'JSONPlaceholder Posts API',
            'https://dummyjson.com/products?limit=5' => 'DummyJSON Products API',
        ];

        try {
            $decoded = json_decode($jsonInput, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new \Exception('Invalid JSON array input provided for Database Seeder.');
            }

            $className = Str::studly($tableName) . 'Seeder';
            $exportedArray = var_export($decoded, true);

            $seederClassCode = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\\Facades\\DB;\n\nclass {$className} extends Seeder\n{\n    /**\n     * Run the database seeds converted from JSON.\n     */\n    public function run(): void\n    {\n        \$data = {$exportedArray};\n\n        foreach (array_chunk(\$data, 100) as \$chunk) {\n            DB::table('{$tableName}')->insert(\$chunk);\n        }\n    }\n}\n";

            return view('json_seeder.index', [
                'title' => 'Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio',
                'sampleUrls' => $sampleUrls,
                'urlResult' => null,
                'fileResult' => null,
                'seederCode' => [
                    'class_name' => $className,
                    'table_name' => $tableName,
                    'row_count' => count($decoded),
                    'code' => $seederClassCode,
                ],
                'errorMessage' => null,
                'activeTab' => 'seeder',
            ]);
        } catch (\Exception $e) {
            return view('json_seeder.index', [
                'title' => 'Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio',
                'sampleUrls' => $sampleUrls,
                'urlResult' => null,
                'fileResult' => null,
                'seederCode' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'seeder',
            ]);
        }
    }
}
