<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonTransformerController extends Controller
{
    /**
     * Display Transformer Studio
     */
    public function index(Request $request)
    {
        $defaultJson = json_encode([
            'user' => [
                'id' => 101,
                'first_name' => 'Hardik',
                'last_name' => 'Patel',
                'contact' => [
                    'email' => 'hardik@example.com',
                    'phone' => '+91 9876543210',
                ],
                'address' => [
                    'city' => 'Ahmedabad',
                    'state' => 'Gujarat',
                    'country' => 'India',
                    'postal_code' => 380001,
                ],
                'is_active' => true,
                'roles' => ['Admin', 'Developer'],
            ],
            'settings' => [
                'theme' => 'dark',
                'notifications' => true,
            ]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return view('json_transformer.index', [
            'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
            'jsonInput' => $defaultJson,
            'action' => 'flatten',
            'flattenedArray' => null,
            'unflattenedJson' => null,
            'mappingKeys' => null,
            'mappedResult' => null,
            'schema' => null,
            'errorMessage' => null,
            'activeTab' => 'flattener',
        ]);
    }

    /**
     * Process Flatten / Unflatten
     */
    public function processFlatten(Request $request)
    {
        $jsonInput = $request->input('json', '');
        $action = $request->input('action', 'flatten');

        try {
            if ($action === 'flatten') {
                $decoded = json_decode($jsonInput, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON syntax: ' . json_last_error_msg());
                }

                $flattened = $this->flattenArray($decoded);

                return view('json_transformer.index', [
                    'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
                    'jsonInput' => $jsonInput,
                    'action' => 'flatten',
                    'flattenedArray' => $flattened,
                    'unflattenedJson' => null,
                    'mappingKeys' => null,
                    'mappedResult' => null,
                    'schema' => null,
                    'errorMessage' => null,
                    'activeTab' => 'flattener',
                ]);
            } else {
                $decoded = json_decode($jsonInput, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON input: ' . json_last_error_msg());
                }

                $unflattened = $this->unflattenArray($decoded);

                return view('json_transformer.index', [
                    'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
                    'jsonInput' => $jsonInput,
                    'action' => 'unflatten',
                    'flattenedArray' => null,
                    'unflattenedJson' => json_encode($unflattened, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                    'mappingKeys' => null,
                    'mappedResult' => null,
                    'schema' => null,
                    'errorMessage' => null,
                    'activeTab' => 'flattener',
                ]);
            }
        } catch (\Exception $e) {
            return view('json_transformer.index', [
                'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
                'jsonInput' => $jsonInput,
                'action' => $action,
                'flattenedArray' => null,
                'unflattenedJson' => null,
                'mappingKeys' => null,
                'mappedResult' => null,
                'schema' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'flattener',
            ]);
        }
    }

    /**
     * Process Interactive Key Mapper
     */
    public function processKeyMapper(Request $request)
    {
        $jsonInput = $request->input('json', '');
        $mappings = $request->input('mappings', []);

        try {
            $decoded = json_decode($jsonInput, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON syntax: ' . json_last_error_msg());
            }

            // Extract all keys
            $allKeys = $this->extractAllKeys($decoded);

            if (!empty($mappings)) {
                $mappedResult = $this->applyKeyMappings($decoded, $mappings);
            } else {
                $mappedResult = $decoded;
            }

            return view('json_transformer.index', [
                'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
                'jsonInput' => $jsonInput,
                'action' => 'mapper',
                'flattenedArray' => null,
                'unflattenedJson' => null,
                'mappingKeys' => $allKeys,
                'mappedResult' => $mappedResult,
                'schema' => null,
                'errorMessage' => null,
                'activeTab' => 'mapper',
            ]);
        } catch (\Exception $e) {
            return view('json_transformer.index', [
                'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
                'jsonInput' => $jsonInput,
                'action' => 'mapper',
                'flattenedArray' => null,
                'unflattenedJson' => null,
                'mappingKeys' => [],
                'mappedResult' => null,
                'schema' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'mapper',
            ]);
        }
    }

    /**
     * Process Automatic JSON Schema Generator
     */
    public function processSchemaGenerator(Request $request)
    {
        $jsonInput = $request->input('json', '');

        try {
            $decoded = json_decode($jsonInput, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON syntax: ' . json_last_error_msg());
            }

            $schema = [
                '$schema' => 'http://json-schema.org/draft-07/schema#',
                'title' => 'Auto-Generated JSON Schema',
                'type' => is_array($decoded) ? (array_is_list($decoded) ? 'array' : 'object') : gettype($decoded),
            ];

            if (is_array($decoded)) {
                if (array_is_list($decoded)) {
                    $schema['items'] = !empty($decoded) ? $this->generateNodeSchema($decoded[0]) : ['type' => 'object'];
                    $schema['minItems'] = count($decoded);
                } else {
                    $schemaProperties = $this->generateNodeSchema($decoded);
                    $schema['properties'] = $schemaProperties['properties'] ?? [];
                    $schema['required'] = $schemaProperties['required'] ?? [];
                }
            }

            return view('json_transformer.index', [
                'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
                'jsonInput' => $jsonInput,
                'action' => 'schema',
                'flattenedArray' => null,
                'unflattenedJson' => null,
                'mappingKeys' => null,
                'mappedResult' => null,
                'schema' => json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'errorMessage' => null,
                'activeTab' => 'schema',
            ]);
        } catch (\Exception $e) {
            return view('json_transformer.index', [
                'title' => 'Dynamic Nested JSON Dot-Notation Transformer & Schema Builder',
                'jsonInput' => $jsonInput,
                'action' => 'schema',
                'flattenedArray' => null,
                'unflattenedJson' => null,
                'mappingKeys' => null,
                'mappedResult' => null,
                'schema' => null,
                'errorMessage' => $e->getMessage(),
                'activeTab' => 'schema',
            ]);
        }
    }

    /**
     * Helper: Flatten Array into Dot Notation
     */
    private function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = $prefix === '' ? (string)$key : $prefix . '.' . $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->flattenArray($value, $newKey));
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }

    /**
     * Helper: Unflatten Dot Notation Array back to Multi-Dimensional Array
     */
    private function unflattenArray(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $parts = explode('.', $key);
            $current = &$result;

            foreach ($parts as $i => $part) {
                if ($i === count($parts) - 1) {
                    $current[$part] = $value;
                } else {
                    if (!isset($current[$part]) || !is_array($current[$part])) {
                        $current[$part] = [];
                    }
                    $current = &$current[$part];
                }
            }
        }

        return $result;
    }

    /**
     * Helper: Extract all unique keys from array recursively
     */
    private function extractAllKeys($data, string $prefix = ''): array
    {
        $keys = [];
        if (!is_array($data)) return [];

        foreach ($data as $key => $val) {
            if (is_string($key)) {
                $keys[] = $key;
            }
            if (is_array($val)) {
                $keys = array_merge($keys, $this->extractAllKeys($val));
            }
        }

        return array_unique($keys);
    }

    /**
     * Helper: Apply Key Mappings Recursively
     */
    private function applyKeyMappings($data, array $mappings)
    {
        if (!is_array($data)) return $data;

        $newArr = [];
        foreach ($data as $key => $val) {
            $newKey = isset($mappings[$key]) && trim($mappings[$key]) !== '' ? trim($mappings[$key]) : $key;

            if (is_array($val)) {
                $newArr[$newKey] = $this->applyKeyMappings($val, $mappings);
            } else {
                $newArr[$newKey] = $val;
            }
        }

        return $newArr;
    }

    /**
     * Helper: Generate JSON Schema Node
     */
    private function generateNodeSchema($data): array
    {
        if (is_null($data)) {
            return ['type' => 'null'];
        }
        if (is_bool($data)) {
            return ['type' => 'boolean'];
        }
        if (is_int($data)) {
            return ['type' => 'integer'];
        }
        if (is_float($data)) {
            return ['type' => 'number'];
        }
        if (is_string($data)) {
            return ['type' => 'string'];
        }

        if (is_array($data)) {
            if (array_is_list($data)) {
                return [
                    'type' => 'array',
                    'items' => !empty($data) ? $this->generateNodeSchema($data[0]) : ['type' => 'string']
                ];
            }

            $properties = [];
            $required = [];
            foreach ($data as $key => $val) {
                $properties[$key] = $this->generateNodeSchema($val);
                $required[] = $key;
            }

            return [
                'type' => 'object',
                'properties' => $properties,
                'required' => $required,
            ];
        }

        return ['type' => 'string'];
    }
}
