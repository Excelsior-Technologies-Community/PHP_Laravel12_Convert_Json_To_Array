<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .json-container, .array-container {
            padding: 15px;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .json-container {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
        .array-container {
            background-color: #e8f4f8;
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </nav>

        <h1 class="mb-4">{{ $title }}</h1>
        
        <div class="alert alert-info">
            <strong>Note:</strong> This example fetches real data from 
            <a href="https://jsonplaceholder.typicode.com/posts/1" target="_blank">JSONPlaceholder API</a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Method Used</h4>
            </div>
            <div class="card-body">
                <code>{{ $method }}</code>
                <p class="mt-2">The <code>json()</code> method automatically converts the HTTP response to an array.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Original JSON Response</h4>
                    </div>
                    <div class="card-body">
                        <div class="json-container">
                            {{ $originalJson }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Converted Array</h4>
                    </div>
                    <div class="card-body">
                        <div class="array-container">
                            <pre>@print_r($convertedArray, true)</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Controller Code</h4>
            </div>
            <div class="card-body">
                <pre><code>
// Make HTTP request
$response = Http::get('https://jsonplaceholder.typicode.com/posts/1');

// Convert JSON response to array
$data = $response->json();

// Handle errors automatically
if ($response->successful()) {
    // Use the array data
    $title = $data['title'];
    $body = $data['body'];
}
                </code></pre>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Accessing Array Data</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">User ID</h5>
                                <p class="card-text">{{ $convertedArray['userId'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Post ID</h5>
                                <p class="card-text">{{ $convertedArray['id'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <h5>Title:</h5>
                    <p>{{ $convertedArray['title'] ?? 'N/A' }}</p>
                    
                    <h5>Body:</h5>
                    <p>{{ $convertedArray['body'] ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary mb-4">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>