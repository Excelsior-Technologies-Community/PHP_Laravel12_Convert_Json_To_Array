<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class JsonConverterMockController extends Controller
{
    /**
     * Display Format Converter & Mock API Studio
     */
    public function index(Request $request)
    {
        $defaultJson = json_encode([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data retrieved successfully',
            'data' => [
                ['id' => 1, 'name' => 'Laravel Framework', 'version' => 12.0, 'category' => 'Backend', 'stars' => 76000],
                ['id' => 2, 'name' => 'Vue.js', 'version' => 3.4, 'category' => 'Frontend', 'stars' => 207000],
                ['id' => 3, 'name' => 'Tailwind CSS', 'version' => 3.4, 'category' => 'Styling', 'stars' => 78000],
                ['id' => 4, 'name' => 'React', 'version' => 18.2, 'category' => 'Frontend', 'stars' => 220000],
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return view('json_converter.index', [
            'title' => 'Multi-Format Converter & Mock API Response Studio',
            'jsonInput' => $defaultJson,
            'convertedFormats' => null,
            'mockResponse' => null,
            'aggregationResult' => null,
            'errorMessage' => null,
            'activeTab' => 'converter',
        ]);
    }

    /**
     * Process Bi-Directional Format Converter (JSON ⇄ XML ⇄ YAML ⇄ PHP Code)
     */
    public function convertFormat(Request $request)
    {
        $jsonInput = $request->input('json', '');

        try {
            $decoded = json_decode($jsonInput, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON syntax: ' . json_last_error_msg());
            }

            // 1. PHP Native Array Code Representation
            $phpCode = "<?php\n\n\$array = " . var_export($decoded, true) . ";";

            // 2. YAML Conversion
            $yamlCode = class_exists(Yaml::class)
                ? Yaml::dump($decoded, 4, 2)
                : $this->arrayToYamlFallback($decoded);

            // 3. XML Conversion
            $xmlCode = $this->arrayToXml($decoded);

            $convertedFormats = [
                'php_code' => $phpCode,
                'yaml_code' => $yamlCode,
                'xml_code' => $xmlCode,
                'json_pretty' => json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ];

            return view('json_converter.index', [
                'title' => 'Multi-Format Converter & Mock API Response Studio',
                'jsonInput' => $jsonInput,
                'convertedFormats' => $convertedFormats,
                'mockResponse' => null,
                'aggregationResult' => null,
                'errorMessage' => null,
                'activeTab' => 'converter',
            ]);
        } catch (\Exception $e) {
            return view('json_converter.index', [
                'title' => 'Multi-Format Converter & Mock API Response Studio',
                'jsonInput' => $jsonInput,
                'convertedFormats' => null,
                'mockResponse' => null,
                'aggregationResult' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'converter',
            ]);
        }
    }

    /**
     * Process Mock API Endpoint Simulator
     */
    public function simulateApi(Request $request)
    {
        $jsonInput = $request->input('json', '');
        $statusCode = (int) $request->input('status_code', 200);
        $latencyMs = (int) $request->input('latency_ms', 0);

        try {
            $decoded = json_decode($jsonInput, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON syntax for Mock API response.');
            }

            if ($latencyMs > 0) {
                usleep(min($latencyMs, 2000) * 1000); // Sleep up to 2 seconds
            }

            $headers = [
                'Content-Type' => 'application/json; charset=UTF-8',
                'X-Mock-Engine' => 'Laravel 12 API Simulator',
                'X-Response-Time' => "{$latencyMs}ms",
                'Cache-Control' => 'no-cache, private',
                'Access-Control-Allow-Origin' => '*',
            ];

            $mockResponse = [
                'status_code' => $statusCode,
                'status_text' => $this->getStatusText($statusCode),
                'latency_ms' => $latencyMs,
                'headers' => $headers,
                'body_json' => json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            ];

            return view('json_converter.index', [
                'title' => 'Multi-Format Converter & Mock API Response Studio',
                'jsonInput' => $jsonInput,
                'convertedFormats' => null,
                'mockResponse' => $mockResponse,
                'aggregationResult' => null,
                'errorMessage' => null,
                'activeTab' => 'mock',
            ]);
        } catch (\Exception $e) {
            return view('json_converter.index', [
                'title' => 'Multi-Format Converter & Mock API Response Studio',
                'jsonInput' => $jsonInput,
                'convertedFormats' => null,
                'mockResponse' => null,
                'aggregationResult' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'mock',
            ]);
        }
    }

    /**
     * Process Advanced Array Aggregator & Group By Radar
     */
    public function processAggregation(Request $request)
    {
        $jsonInput = $request->input('json', '');
        $groupByField = trim($request->input('group_by', ''));

        try {
            $decoded = json_decode($jsonInput, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new \Exception('Invalid JSON input for Array Aggregation. Provide an array or object.');
            }

            // Extract data items
            $data = isset($decoded['data']) && is_array($decoded['data']) ? $decoded['data'] : $decoded;

            $collection = collect($data);
            $totalRecords = $collection->count();

            // Extract unique keys
            $uniqueKeys = [];
            foreach ($collection as $row) {
                if (is_array($row)) {
                    $uniqueKeys = array_unique(array_merge($uniqueKeys, array_keys($row)));
                }
            }

            // Perform Group By
            $groupedData = [];
            if (!empty($groupByField)) {
                $groupedData = $collection->groupBy($groupByField)->toArray();
            }

            // Numeric aggregation metrics
            $numericMetrics = [];
            foreach ($uniqueKeys as $key) {
                $values = $collection->pluck($key)->filter(fn($v) => is_numeric($v));
                if ($values->isNotEmpty()) {
                    $numericMetrics[$key] = [
                        'sum' => round($values->sum(), 2),
                        'avg' => round($values->avg(), 2),
                        'min' => round($values->min(), 2),
                        'max' => round($values->max(), 2),
                        'count' => $values->count(),
                    ];
                }
            }

            $aggregationResult = [
                'total_records' => $totalRecords,
                'unique_keys' => $uniqueKeys,
                'group_by_field' => $groupByField,
                'grouped_data' => $groupedData,
                'numeric_metrics' => $numericMetrics,
            ];

            return view('json_converter.index', [
                'title' => 'Multi-Format Converter & Mock API Response Studio',
                'jsonInput' => $jsonInput,
                'convertedFormats' => null,
                'mockResponse' => null,
                'aggregationResult' => $aggregationResult,
                'errorMessage' => null,
                'activeTab' => 'aggregator',
            ]);
        } catch (\Exception $e) {
            return view('json_converter.index', [
                'title' => 'Multi-Format Converter & Mock API Response Studio',
                'jsonInput' => $jsonInput,
                'convertedFormats' => null,
                'mockResponse' => null,
                'aggregationResult' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'aggregator',
            ]);
        }
    }

    /**
     * Helper: Array to XML String
     */
    private function arrayToXml(array $data, string $rootNode = 'root'): string
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><{$rootNode}/>");
        $this->arrayToXmlRecursive($data, $xml);

        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;
        return $dom->saveXML();
    }

    private function arrayToXmlRecursive(array $data, \SimpleXMLElement &$xml)
    {
        foreach ($data as $key => $value) {
            $nodeKey = is_numeric($key) ? "item{$key}" : preg_replace('/[^a-z0-9_]/i', '_', $key);

            if (is_array($value)) {
                $subNode = $xml->addChild($nodeKey);
                $this->arrayToXmlRecursive($value, $subNode);
            } else {
                $valStr = is_bool($value) ? ($value ? 'true' : 'false') : (string)$value;
                $xml->addChild($nodeKey, htmlspecialchars($valStr));
            }
        }
    }

    private function arrayToYamlFallback(array $data, int $indent = 0): string
    {
        $yaml = '';
        $prefix = str_repeat('  ', $indent);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $yaml .= "{$prefix}{$key}:\n" . $this->arrayToYamlFallback($value, $indent + 1);
            } else {
                $valStr = is_bool($value) ? ($value ? 'true' : 'false') : (string)$value;
                $yaml .= "{$prefix}{$key}: {$valStr}\n";
            }
        }

        return $yaml;
    }

    private function getStatusText(int $code): string
    {
        $statusTexts = [
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
        ];

        return $statusTexts[$code] ?? 'Unknown Status';
    }
}
