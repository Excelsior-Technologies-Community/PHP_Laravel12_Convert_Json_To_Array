<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: #f4f6f9; font-family: 'Inter', -apple-system, sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .code-pre { background: #1e1e1e; color: #d4d4d4; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; max-height: 400px; overflow-y: auto; }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fa-solid fa-code text-primary me-2"></i>Laravel 12 JSON Studio
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-house me-1"></i> Home</a>
                <a href="{{ route('json.transformer') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-diagram-project me-1"></i> Transformer & Schema</a>
                <a href="{{ route('json.seeder') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-cloud-arrow-down me-1"></i> URL & Seeder</a>
                <a href="{{ route('json.converter') }}" class="btn btn-warning btn-sm text-dark fw-bold"><i class="fa-solid fa-shuffle me-1"></i> Converter & Mock</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 py-4">
        <!-- Header -->
        <div class="bg-white p-4 rounded-4 shadow-sm border mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-shuffle text-warning me-2"></i>Multi-Format Converter & Mock API Response Studio</h3>
                <p class="text-muted mb-0 small">Convert JSON to native PHP Array code, XML & YAML, test mock API endpoints with HTTP status codes, and perform array analytics</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard</a>
        </div>

        @if($errorMessage)
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ $errorMessage }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabs -->
        <ul class="nav nav-pills bg-white p-2 rounded-4 shadow-sm mb-4 border" id="converterTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'converter' ? 'active' : '' }} fw-bold" id="converter-tab" data-bs-toggle="tab" data-bs-target="#converter" type="button">
                    <i class="fa-solid fa-file-code me-1"></i> 1. Bi-Directional Format Converter
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'mock' ? 'active' : '' }} fw-bold" id="mock-tab" data-bs-toggle="tab" data-bs-target="#mock" type="button">
                    <i class="fa-solid fa-server me-1"></i> 2. Mock REST API Endpoint Simulator
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'aggregator' ? 'active' : '' }} fw-bold" id="aggregator-tab" data-bs-toggle="tab" data-bs-target="#aggregator" type="button">
                    <i class="fa-solid fa-chart-pie me-1"></i> 3. Array Aggregator & Group By Radar
                </button>
            </li>
        </ul>

        <div class="tab-content" id="converterTabsContent">
            <!-- Tab 1: Bi-Directional Format Converter -->
            <div class="tab-pane fade {{ $activeTab === 'converter' ? 'show active' : '' }}" id="converter">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-code text-primary me-2"></i>JSON Input</h5>
                            <form action="{{ route('json.converter.convert') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="json" rows="14" class="form-control font-monospace" style="font-size: 13px;" required>{{ $jsonInput }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary fw-bold w-100">
                                    <i class="fa-solid fa-rotate me-1"></i> Convert to PHP, XML & YAML
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-laptop-code text-success me-2"></i>Multi-Format Output Studio</h5>
                            @if($convertedFormats)
                                <ul class="nav nav-tabs mb-3" id="formatSubTabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active fw-bold small" id="php-tab" data-bs-toggle="tab" data-bs-target="#subPhp" type="button">PHP Array Code</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link fw-bold small" id="yaml-tab" data-bs-toggle="tab" data-bs-target="#subYaml" type="button">YAML</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link fw-bold small" id="xml-tab" data-bs-toggle="tab" data-bs-target="#subXml" type="button">XML</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="formatSubTabsContent">
                                    <div class="tab-pane fade show active" id="subPhp">
                                        <pre class="code-pre">{{ $convertedFormats['php_code'] }}</pre>
                                    </div>
                                    <div class="tab-pane fade" id="subYaml">
                                        <pre class="code-pre">{{ $convertedFormats['yaml_code'] }}</pre>
                                    </div>
                                    <div class="tab-pane fade" id="subXml">
                                        <pre class="code-pre">{{ $convertedFormats['xml_code'] }}</pre>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-brackets-curly fa-3x mb-3 opacity-50"></i>
                                    <h6>No Format Converted Yet</h6>
                                    <p class="small">Submit your JSON payload to convert into PHP native arrays, YAML, and XML.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Mock REST API Simulator -->
            <div class="tab-pane fade {{ $activeTab === 'mock' ? 'show active' : '' }}" id="mock">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-sliders text-info me-2"></i>Configure Mock API Endpoint</h5>
                            <form action="{{ route('json.converter.mock') }}" method="POST">
                                @csrf
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-bold small text-dark">HTTP Status Code</label>
                                        <select name="status_code" class="form-select">
                                            <option value="200">200 OK</option>
                                            <option value="201">201 Created</option>
                                            <option value="400">400 Bad Request</option>
                                            <option value="401">401 Unauthorized</option>
                                            <option value="404">404 Not Found</option>
                                            <option value="500">500 Server Error</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold small text-dark">Latency Delay</label>
                                        <select name="latency_ms" class="form-select">
                                            <option value="0">0 ms (Immediate)</option>
                                            <option value="200">200 ms</option>
                                            <option value="500">500 ms</option>
                                            <option value="1000">1000 ms (1s)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-dark">JSON Response Body</label>
                                    <textarea name="json" rows="10" class="form-control font-monospace" style="font-size: 13px;" required>{{ $jsonInput }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-info text-white fw-bold w-100">
                                    <i class="fa-solid fa-play me-1"></i> Simulate REST Endpoint Call
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-network-wired text-primary me-2"></i>Mock Endpoint Response Inspector</h5>
                            @if($mockResponse)
                                <div class="row g-2 mb-3 text-center">
                                    <div class="col-4">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Status Code</small>
                                            <span class="badge {{ $mockResponse['status_code'] < 400 ? 'bg-success' : 'bg-danger' }} fs-6">
                                                {{ $mockResponse['status_code'] }} {{ $mockResponse['status_text'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Simulated Delay</small>
                                            <strong class="text-dark">{{ $mockResponse['latency_ms'] }} ms</strong>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Engine</small>
                                            <strong class="text-primary">Laravel 12 API</strong>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="fw-bold small text-dark">Response Headers:</h6>
                                <div class="table-responsive mb-3">
                                    <table class="table table-sm table-bordered align-middle extra-small">
                                        <thead class="table-light">
                                            <tr><th>Header</th><th>Value</th></tr>
                                        </thead>
                                        <tbody>
                                            @foreach($mockResponse['headers'] as $hKey => $hVal)
                                                <tr><td><code>{{ $hKey }}</code></td><td>{{ $hVal }}</td></tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <h6 class="fw-bold small text-dark">Response Body:</h6>
                                <pre class="code-pre">{{ $mockResponse['body_json'] }}</pre>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-terminal fa-3x mb-3 opacity-50"></i>
                                    <h6>Endpoint Not Simulated</h6>
                                    <p class="small">Configure status code and response payload to simulate API behavior.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Array Aggregator & Group By Radar -->
            <div class="tab-pane fade {{ $activeTab === 'aggregator' ? 'show active' : '' }}" id="aggregator">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-simple text-warning me-2"></i>Configure Array Aggregations</h5>
                            <form action="{{ route('json.converter.aggregate') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-dark">Group By Field Name (Optional)</label>
                                    <input type="text" name="group_by" value="category" class="form-control" placeholder="category or status">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-dark">JSON Array Data</label>
                                    <textarea name="json" rows="11" class="form-control font-monospace" style="font-size: 13px;" required>{{ $jsonInput }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-warning text-dark fw-bold w-100">
                                    <i class="fa-solid fa-calculator me-1"></i> Calculate Aggregations & Grouping
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-pie text-dark me-2"></i>Array Aggregations & Metrics</h5>
                            @if($aggregationResult)
                                <div class="mb-3 bg-light p-3 rounded-3 border">
                                    <span class="small me-3">Total Records: <strong class="text-primary">{{ $aggregationResult['total_records'] }}</strong></span>
                                    <span class="small">Unique Keys: 
                                        @foreach($aggregationResult['unique_keys'] as $uKey)
                                            <span class="badge bg-secondary me-1">{{ $uKey }}</span>
                                        @endforeach
                                    </span>
                                </div>

                                @if(!empty($aggregationResult['numeric_metrics']))
                                    <h6 class="fw-bold small text-dark">Numeric Field Analytics (Sum, Avg, Min, Max):</h6>
                                    <div class="table-responsive mb-3">
                                        <table class="table table-sm table-bordered align-middle">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Field</th>
                                                    <th>Sum</th>
                                                    <th>Avg</th>
                                                    <th>Min</th>
                                                    <th>Max</th>
                                                    <th>Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($aggregationResult['numeric_metrics'] as $fKey => $metrics)
                                                    <tr>
                                                        <td><code class="text-primary fw-bold">{{ $fKey }}</code></td>
                                                        <td class="fw-bold text-success">{{ $metrics['sum'] }}</td>
                                                        <td>{{ $metrics['avg'] }}</td>
                                                        <td>{{ $metrics['min'] }}</td>
                                                        <td>{{ $metrics['max'] }}</td>
                                                        <td>{{ $metrics['count'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if(!empty($aggregationResult['grouped_data']))
                                    <h6 class="fw-bold small text-dark">Grouped Data Breakdown (Group By `{{ $aggregationResult['group_by_field'] }}`):</h6>
                                    <pre class="code-pre">{{ json_encode($aggregationResult['grouped_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                @endif
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-chart-area fa-3x mb-3 opacity-50"></i>
                                    <h6>No Aggregations Calculated</h6>
                                    <p class="small">Submit JSON data to compute sum, average, min, max metrics and group by fields.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
