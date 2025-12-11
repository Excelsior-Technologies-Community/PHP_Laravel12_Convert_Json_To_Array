<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .example-card {
            transition: transform 0.2s;
        }
        .example-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center mb-3">{{ $title }}</h1>
                <p class="text-center text-muted">
                    Laravel 12 provides multiple ways to convert JSON data into arrays.
                    Here are 4 different methods:
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card example-card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Method 1: json_decode()</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            The classic PHP function <code>json_decode()</code> with the second parameter set to <code>true</code> to get an associative array.
                        </p>
                        <ul>
                            <li>Simple and straightforward</li>
                            <li>Native PHP function</li>
                            <li>Requires explicit error handling</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('example1') }}" class="btn btn-primary">View Example</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card example-card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Method 2: HTTP Response json()</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Laravel's HTTP Client provides a <code>json()</code> method that automatically converts JSON responses to arrays.
                        </p>
                        <ul>
                            <li>Built-in error handling</li>
                            <li>Automatic conversion</li>
                            <li>Perfect for API calls</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('example2') }}" class="btn btn-success">View Example</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card example-card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Method 3: Request json()</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Laravel's Request object has a <code>json()</code> method to access JSON request data as an array.
                        </p>
                        <ul>
                            <li>Access JSON request data</li>
                            <li>Dot notation support</li>
                            <li>Type-safe data access</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('example3') }}" class="btn btn-info">View Example</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card example-card h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Method 4: Laravel Collection</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            Convert JSON to a Laravel Collection for powerful data manipulation and transformation.
                        </p>
                        <ul>
                            <li>Rich collection methods</li>
                            <li>Fluent data manipulation</li>
                            <li>Chainable operations</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('example4') }}" class="btn btn-warning">View Example</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Best Practices</h5>
                        <ul>
                            <li>Always validate JSON data before conversion</li>
                            <li>Use try-catch blocks for external API calls</li>
                            <li>Consider using Laravel's built-in validation for JSON requests</li>
                            <li>Use Collections for complex data manipulation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>