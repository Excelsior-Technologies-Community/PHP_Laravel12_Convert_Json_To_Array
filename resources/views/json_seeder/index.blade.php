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
                <h3 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-database text-success me-2"></i>Multi-Source JSON Parser, URL Fetcher & Database Seeder Studio</h3>
                <p class="text-muted mb-0 small">Fetch JSON directly from remote API endpoints, upload `.json` files with memory profiling, and generate DB Seeders</p>
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
        <ul class="nav nav-pills bg-white p-2 rounded-4 shadow-sm mb-4 border" id="seederTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'url' ? 'active' : '' }} fw-bold" id="url-tab" data-bs-toggle="tab" data-bs-target="#url" type="button">
                    <i class="fa-solid fa-globe me-1"></i> 1. Remote API & URL Fetcher
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'file' ? 'active' : '' }} fw-bold" id="file-tab" data-bs-toggle="tab" data-bs-target="#file" type="button">
                    <i class="fa-solid fa-file-arrow-up me-1"></i> 2. JSON File Uploader & Memory Monitor
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'seeder' ? 'active' : '' }} fw-bold" id="seeder-tab" data-bs-toggle="tab" data-bs-target="#seeder" type="button">
                    <i class="fa-solid fa-table-cells me-1"></i> 3. 1-Click Database Seeder Generator
                </button>
            </li>
        </ul>

        <div class="tab-content" id="seederTabsContent">
            <!-- Tab 1: Remote URL Fetcher -->
            <div class="tab-pane fade {{ $activeTab === 'url' ? 'show active' : '' }}" id="url">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-cloud-down text-primary me-2"></i>Fetch External JSON API</h5>
                            <form action="{{ route('json.seeder.fetch') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-dark">API Endpoint URL</label>
                                    <input type="url" name="url" value="{{ $urlResult['url'] ?? 'https://jsonplaceholder.typicode.com/users' }}" class="form-control" required placeholder="https://api.example.com/data.json">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-muted">Quick Sample Presets:</label>
                                    <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                                        @foreach($sampleUrls as $sampleUrl => $label)
                                            <button type="button" class="list-group-item list-group-item-action small py-2 d-flex justify-content-between align-items-center" onclick="document.querySelector('input[name=url]').value='{{ $sampleUrl }}';">
                                                <span>{{ $label }}</span>
                                                <i class="fa-solid fa-chevron-right text-muted extra-small"></i>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary fw-bold w-100 mt-2">
                                    <i class="fa-solid fa-bolt me-1"></i> Fetch Remote JSON Payload
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-network-wired text-success me-2"></i>API Response & Parsed Array</h5>
                            @if($urlResult)
                                <div class="row g-2 mb-3 text-center">
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">HTTP Status</small>
                                            <span class="badge bg-success fw-bold">{{ $urlResult['status'] }} OK</span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Latency</small>
                                            <strong class="text-dark">{{ $urlResult['latency_ms'] }} ms</strong>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Total Records</small>
                                            <strong class="text-primary">{{ $urlResult['total_count'] }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Payload Size</small>
                                            <strong class="text-dark">{{ round($urlResult['size_bytes'] / 1024, 2) }} KB</strong>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="fw-bold small text-dark">Parsed Collection Preview (First 10 Items):</h6>
                                <pre class="code-pre">{{ json_encode($urlResult['array_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-cloud-sun fa-3x mb-3 opacity-50"></i>
                                    <h6>No API Call Executed</h6>
                                    <p class="small">Enter an API URL on the left to inspect parsed HTTP responses.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: File Uploader & Memory Monitor -->
            <div class="tab-pane fade {{ $activeTab === 'file' ? 'show active' : '' }}" id="file">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-file-arrow-up text-success me-2"></i>Upload JSON File</h5>
                            <form action="{{ route('json.seeder.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-dark">Select .json File</label>
                                    <input type="file" name="json_file" accept=".json" class="form-control" required>
                                    <small class="text-muted extra-small d-block mt-1">Supports JSON files up to 10MB.</small>
                                </div>
                                <button type="submit" class="btn btn-success fw-bold w-100">
                                    <i class="fa-solid fa-microchip me-1"></i> Upload & Benchmark Memory
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-gauge-high text-warning me-2"></i>Memory Profile & Parsed Data</h5>
                            @if($fileResult)
                                <div class="row g-2 mb-3 text-center">
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">File Size</small>
                                            <strong class="text-dark">{{ $fileResult['file_size_kb'] }} KB</strong>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Parse Time</small>
                                            <strong class="text-success">{{ $fileResult['latency_ms'] }} ms</strong>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Peak Memory</small>
                                            <strong class="text-warning">{{ $fileResult['peak_memory_mb'] }} MB</strong>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="bg-light p-2 rounded-3 border">
                                            <small class="text-muted d-block extra-small">Items Count</small>
                                            <strong class="text-primary">{{ $fileResult['item_count'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="fw-bold small text-dark">Converted PHP Array Preview:</h6>
                                <pre class="code-pre">{{ json_encode($fileResult['array_preview'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-hard-drive fa-3x mb-3 opacity-50"></i>
                                    <h6>No File Uploaded Yet</h6>
                                    <p class="small">Upload a <code>.json</code> file to measure execution speed and RAM memory consumption.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Database Seeder Generator -->
            <div class="tab-pane fade {{ $activeTab === 'seeder' ? 'show active' : '' }}" id="seeder">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-database text-warning me-2"></i>Generate Database Seeder</h5>
                            <form action="{{ route('json.seeder.generate') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-dark">Database Table Name</label>
                                    <input type="text" name="table_name" value="products" class="form-control" required placeholder="users or products">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-dark">JSON Array Data</label>
                                    <textarea name="json" rows="10" class="form-control font-monospace" style="font-size: 13px;" required>[
  {"id": 1, "title": "MacBook Pro M4", "price": 1999.00, "status": "active"},
  {"id": 2, "title": "Wireless Headphones", "price": 299.50, "status": "active"},
  {"id": 3, "title": "Gaming Monitor", "price": 699.99, "status": "inactive"}
]</textarea>
                                </div>
                                <button type="submit" class="btn btn-warning text-dark fw-bold w-100">
                                    <i class="fa-solid fa-code me-1"></i> Generate Seeder Class
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-file-code text-dark me-2"></i>Generated Laravel Seeder Class</h5>
                            @if($seederCode)
                                <div class="mb-2 d-flex justify-content-between align-items-center bg-light p-2 rounded-3 border">
                                    <span class="small">Class Name: <strong class="text-primary">{{ $seederCode['class_name'] }}</strong></span>
                                    <span class="badge bg-secondary">{{ $seederCode['row_count'] }} Rows Included</span>
                                </div>
                                <pre class="code-pre">{{ $seederCode['code'] }}</pre>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-table fa-3x mb-3 opacity-50"></i>
                                    <h6>Seeder Code Not Generated</h6>
                                    <p class="small">Enter table name and JSON array to generate a ready-to-run Database Seeder file.</p>
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
