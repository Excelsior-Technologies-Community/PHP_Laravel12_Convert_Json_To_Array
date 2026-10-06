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
                <h3 class="fw-bold mb-1 text-dark"><i class="fa-solid fa-sitemap text-primary me-2"></i>Dynamic Nested JSON Dot-Notation Transformer & Schema Builder</h3>
                <p class="text-muted mb-0 small">Flatten deep JSON paths, interactively rename array keys, and auto-generate Draft 7 JSON Schema</p>
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
        <ul class="nav nav-pills bg-white p-2 rounded-4 shadow-sm mb-4 border" id="transformerTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'flattener' ? 'active' : '' }} fw-bold" id="flattener-tab" data-bs-toggle="tab" data-bs-target="#flattener" type="button">
                    <i class="fa-solid fa-route me-1"></i> 1. Path Flattener & Unflattener
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'mapper' ? 'active' : '' }} fw-bold" id="mapper-tab" data-bs-toggle="tab" data-bs-target="#mapper" type="button">
                    <i class="fa-solid fa-key me-1"></i> 2. Array Key Mapper & Renamer
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link {{ $activeTab === 'schema' ? 'active' : '' }} fw-bold" id="schema-tab" data-bs-toggle="tab" data-bs-target="#schema" type="button">
                    <i class="fa-solid fa-file-code me-1"></i> 3. Auto JSON Schema Generator
                </button>
            </li>
        </ul>

        <div class="tab-content" id="transformerTabsContent">
            <!-- Tab 1: Flattener & Unflattener -->
            <div class="tab-pane fade {{ $activeTab === 'flattener' ? 'show active' : '' }}" id="flattener">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-code me-2 text-primary"></i>JSON Input Payload</h5>
                            <form action="{{ route('json.transformer.flatten') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="json" rows="14" class="form-control font-monospace text-sm" style="font-size: 13px;" required>{{ $jsonInput }}</textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" name="action" value="flatten" class="btn btn-primary fw-bold px-4">
                                        <i class="fa-solid fa-compress me-1"></i> Flatten to Dot Notation
                                    </button>
                                    <button type="submit" name="action" value="unflatten" class="btn btn-outline-dark fw-bold px-4">
                                        <i class="fa-solid fa-expand me-1"></i> Unflatten Dot Notation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-table-list me-2 text-success"></i>Transformation Result</h5>
                            @if($flattenedArray)
                                <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Dot-Notation Path</th>
                                                <th>Converted Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($flattenedArray as $path => $val)
                                                <tr>
                                                    <td><code class="text-primary fw-bold">{{ $path }}</code></td>
                                                    <td>
                                                        @if(is_bool($val))
                                                            <span class="badge bg-warning text-dark">{{ $val ? 'true' : 'false' }}</span>
                                                        @elseif(is_null($val))
                                                            <span class="badge bg-secondary">null</span>
                                                        @else
                                                            <span class="text-dark small">{{ (string)$val }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($unflattenedJson)
                                <pre class="code-pre">{{ $unflattenedJson }}</pre>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-network-wired fa-3x mb-3 opacity-50"></i>
                                    <h6>No Transformation Processed Yet</h6>
                                    <p class="small">Click "Flatten" or "Unflatten" to see dot notation conversions.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Key Mapper & Renamer -->
            <div class="tab-pane fade {{ $activeTab === 'mapper' ? 'show active' : '' }}" id="mapper">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-sliders me-2 text-info"></i>Detect & Map Array Keys</h5>
                            <form action="{{ route('json.transformer.mapper') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">JSON Input</label>
                                    <textarea name="json" rows="8" class="form-control font-monospace" style="font-size: 13px;" required>{{ $jsonInput }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-info text-white fw-bold w-100 mb-3">
                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Scan & Extract Keys
                                </button>

                                @if($mappingKeys)
                                    <h6 class="fw-bold text-dark border-top pt-3">Rename Discovered Keys:</h6>
                                    <div style="max-height: 220px; overflow-y: auto;">
                                        @foreach($mappingKeys as $keyName)
                                            <div class="mb-2 d-flex align-items-center gap-2">
                                                <code class="badge bg-light text-dark border px-2 py-1" style="min-width: 120px;">{{ $keyName }}</code>
                                                <i class="fa-solid fa-arrow-right text-muted small"></i>
                                                <input type="text" name="mappings[{{ $keyName }}]" value="{{ $keyName }}" class="form-control form-control-sm" placeholder="New Key Name">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-success fw-bold w-100 mt-3">
                                        <i class="fa-solid fa-check me-1"></i> Apply Key Renaming
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-file-export me-2 text-success"></i>Mapped Array Output</h5>
                            @if($mappedResult)
                                <pre class="code-pre">{{ json_encode($mappedResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-key fa-3x mb-3 opacity-50"></i>
                                    <h6>No Keys Mapped Yet</h6>
                                    <p class="small">Scan JSON input on the left to customize key names.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Auto JSON Schema Generator -->
            <div class="tab-pane fade {{ $activeTab === 'schema' ? 'show active' : '' }}" id="schema">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-wand-magic-sparkles me-2 text-warning"></i>Generate JSON Schema</h5>
                            <form action="{{ route('json.transformer.schema') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">JSON Payload</label>
                                    <textarea name="json" rows="12" class="form-control font-monospace" style="font-size: 13px;" required>{{ $jsonInput }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-warning text-dark fw-bold w-100">
                                    <i class="fa-solid fa-gears me-1"></i> Generate Draft 7 Schema
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card p-4 h-100">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-code-branch me-2 text-dark"></i>Generated JSON Schema Specification</h5>
                            @if($schema)
                                <pre class="code-pre">{{ $schema }}</pre>
                            @else
                                <div class="text-center text-muted py-5">
                                    <i class="fa-solid fa-file-circle-check fa-3x mb-3 opacity-50"></i>
                                    <h6>Schema Not Generated</h6>
                                    <p class="small">Submit your JSON payload to automatically construct schema rules.</p>
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
