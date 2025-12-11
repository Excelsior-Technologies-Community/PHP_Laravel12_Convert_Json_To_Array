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
        .highlight {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
        }
        .method-example {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
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
            <strong>Note:</strong> This example demonstrates how to handle JSON data in incoming HTTP requests using Laravel's Request object.
            The <code>$request->json()</code> method returns an <code>InputBag</code> object, not a plain array.
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">Method Used</h4>
            </div>
            <div class="card-body">
                <code>{{ $method }}</code>
                <p class="mt-2">The Request object's <code>json()</code> method returns an <code>InputBag</code> object that can be accessed like an array.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Original JSON Data</h4>
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
                        <h4 class="mb-0">InputBag Data Structure</h4>
                    </div>
                    <div class="card-body">
                        <div class="array-container">
                            <p><strong>Type:</strong> {{ gettype($convertedArray) }}</p>
                            <p><strong>Class:</strong> {{ get_class($convertedArray) }}</p>
                            <p><strong>All data as array:</strong></p>
                            <pre>@print_r($convertedArray->all(), true)</pre>
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
// JSON data (simulating incoming request)
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

// Get entire JSON as InputBag object
$data = $fakeRequest->json();

// Access data using array syntax on InputBag
$userData = $data->all();

// Get specific values using dot notation
$userName = $fakeRequest->json('user.name');
$userAge = $fakeRequest->json('user.profile.age');
$userSkills = $fakeRequest->json('user.profile.skills');
$nonExistent = $fakeRequest->json('user.email', 'default@example.com');

// Alternative: Convert InputBag to array
$dataArray = $fakeRequest->json()->all();
                </code></pre>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Accessing Data Examples</h4>
            </div>
            <div class="card-body">
                <div class="method-example mb-3">
                    <h5>Using Dot Notation with json() method</h5>
                    <p>The <code>$request->json()</code> method supports dot notation directly:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6><code>$request->json('user.name')</code></h6>
                                    <div class="highlight">
                                        Result: <strong>"{{ $userName }}"</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6><code>$request->json('user.profile.city')</code></h6>
                                    <div class="highlight">
                                        @php
                                            $city = request()->json('user.profile.city') ?? ($convertedArray['user']['profile']['city'] ?? 'N/A');
                                        @endphp
                                        Result: <strong>"{{ $city }}"</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6><code>$request->json('user.profile.age')</code></h6>
                                    <div class="highlight">
                                        Result: <strong>{{ $convertedArray->get('user')['profile']['age'] ?? ($convertedArray['user']['profile']['age'] ?? 'N/A') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6><code>$request->json('user.profile.skills')</code></h6>
                                    <div class="highlight">
                                        Result: 
                                        @php
                                            $skills = $userSkills ?? ($convertedArray->get('user')['profile']['skills'] ?? ($convertedArray['user']['profile']['skills'] ?? []));
                                        @endphp
                                        @if(is_array($skills) && count($skills) > 0)
                                            <ul class="mb-0">
                                                @foreach($skills as $skill)
                                                    <li>{{ $skill }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="method-example">
                    <h5>Convert InputBag to Array</h5>
                    <p>You can convert the InputBag to a plain array using <code>all()</code> method:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6><code>$dataArray = $request->json()->all();</code></h6>
                                    <div class="highlight">
                                        @php
                                            $dataArray = $convertedArray->all();
                                        @endphp
                                        <strong>Type:</strong> {{ gettype($dataArray) }}<br>
                                        <strong>User Name:</strong> {{ $dataArray['user']['name'] ?? 'N/A' }}<br>
                                        <strong>User City:</strong> {{ $dataArray['user']['profile']['city'] ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6><code>$request->json('user.email', 'default@example.com')</code></h6>
                                    <div class="highlight">
                                        Result: <strong>"default@example.com"</strong> (key doesn't exist in original JSON)
                                    </div>
                                    <p class="mt-2 mb-0"><small>The second parameter provides a default value if the key doesn't exist.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="method-example mt-3">
                    <h5>Accessing InputBag Data</h5>
                    <p>Different ways to access data from InputBag:</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6><code>$bag->get('key')</code></h6>
                                    <div class="small">
                                        @php
                                            $userId = $convertedArray->get('user')['id'] ?? 'N/A';
                                        @endphp
                                        User ID: {{ $userId }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6><code>$bag['key']</code></h6>
                                    <div class="small">
                                        @php
                                            $userNameAlt = $convertedArray['user']['name'] ?? 'N/A';
                                        @endphp
                                        User Name: {{ $userNameAlt }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6><code>$bag->has('key')</code></h6>
                                    <div class="small">
                                        Has user.email? {{ $convertedArray->has('user.email') ? 'Yes' : 'No' }}<br>
                                        Has user.name? {{ $convertedArray->has('user.name') ? 'Yes' : 'No' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Real-world Use Case</h4>
            </div>
            <div class="card-body">
                <p>In a real Laravel application, you would use this in a controller method like:</p>
                <pre><code>
// app/Http/Controllers/UserController.php

public function store(Request $request)
{
    // Validate JSON data
    $validated = $request->validate([
        'user.name' => 'required|string',
        'user.profile.age' => 'required|integer|min:18',
        'user.profile.skills' => 'array'
    ]);

    // Access validated JSON data (returns InputBag)
    $jsonData = $request->json();
    
    // Get specific values
    $name = $jsonData->get('user.name');
    $age = $jsonData->get('user.profile.age');
    $skills = $jsonData->get('user.profile.skills', []);
    
    // Or convert to array
    $dataArray = $jsonData->all();

    // Process the data...
    return response()->json([
        'message' => 'User created successfully',
        'data' => [
            'name' => $name,
            'age' => $age,
            'skills' => $skills,
            'full_data' => $dataArray
        ]
    ]);
}
                </code></pre>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary mb-4">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>