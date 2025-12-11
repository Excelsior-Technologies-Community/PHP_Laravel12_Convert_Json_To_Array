<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .json-container {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .array-container {
            background-color: #e8f4f8;
            border-left: 4px solid #28a745;
            padding: 15px;
            font-family: 'Courier New', monospace;
        }
        pre {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
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
        
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Method Used</h4>
            </div>
            <div class="card-body">
                <code>{{ $method }}</code>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Original JSON</h4>
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
// JSON data as string
$jsonData = '[
    { "id": 1, "name": "Hardik", "email": "hardik@gmail.com"},
    { "id": 2, "name": "Vimal", "email": "vimal@gmail.com"},
    { "id": 3, "name": "Harshad", "email": "harshad@gmail.com"}
]';

// Convert JSON to array using json_decode()
$data = json_decode($jsonData, true);

// Access array elements
foreach ($data as $item) {
    echo $item['name'] . ': ' . $item['email'];
}
                </code></pre>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Accessing Array Data</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($convertedArray as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary mb-4">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>