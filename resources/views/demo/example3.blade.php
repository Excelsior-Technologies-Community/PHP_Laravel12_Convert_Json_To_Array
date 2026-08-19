<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .json-container,
        .array-container {
            padding: 15px;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
            border-radius: 5px;
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

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        code {
            word-break: break-word;
        }
    </style>
</head>

<body>

    <div class="container mt-4">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="breadcrumb-item active">
                    {{ $title }}
                </li>

            </ol>

        </nav>


        {{-- Page Title --}}
        <h1 class="mb-4">
            {{ $title }}
        </h1>


        {{-- Explanation --}}
        <div class="alert alert-info">

            <strong>Note:</strong>

            This example demonstrates how to handle JSON data in
            incoming HTTP requests using Laravel's Request object.

            The
            <code>$request->json()</code>
            method returns a Symfony
            <code>InputBag</code>
            object.

            You can convert it into a normal PHP array using
            <code>->all()</code>.

        </div>


        {{-- Method Used --}}
        <div class="card mb-4">

            <div class="card-header bg-info text-white">

                <h4 class="mb-0">
                    Method Used
                </h4>

            </div>

            <div class="card-body">

                <code>
                    {{ $method }}
                </code>

                <p class="mt-3 mb-0">

                    Laravel's
                    <code>$request->json()</code>
                    method provides access to JSON request data.

                    For the complete JSON structure, use
                    <code>$request->json()->all()</code>
                    to convert the
                    <code>InputBag</code>
                    into a normal PHP array.

                </p>

            </div>

        </div>


        {{-- Original JSON + Converted Array --}}
        <div class="row">

            {{-- Original JSON --}}
            <div class="col-md-6">

                <div class="card mb-4">

                    <div class="card-header bg-primary text-white">

                        <h4 class="mb-0">
                            Original JSON Data
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="json-container">

                            {{ $originalJson }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- Converted Array --}}
            <div class="col-md-6">

                <div class="card mb-4">

                    <div class="card-header bg-success text-white">

                        <h4 class="mb-0">
                            Converted PHP Array
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="array-container">

                            <p>
                                <strong>Type:</strong>

                                {{ gettype($convertedArray) }}

                            </p>

                            <p>
                                <strong>Structure:</strong>
                            </p>

                            <pre>{{ print_r($convertedArray, true) }}</pre>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Controller Code --}}
        <div class="card mb-4">

            <div class="card-header bg-secondary text-white">

                <h4 class="mb-0">
                    Controller Code
                </h4>

            </div>

            <div class="card-body">

                <pre><code>// JSON data simulating an incoming request

$jsonData = '{
    "user": {
        "id": 101,
        "name": "John Doe",
        "profile": {
            "age": 28,
            "city": "New York",
            "skills": [
                "PHP",
                "Laravel",
                "JavaScript"
            ]
        }
    }
}';


// Create a request with JSON content

$fakeRequest = Request::create(
    '/',
    'GET',
    [],
    [],
    [],
    [
        'CONTENT_TYPE' => 'application/json',
    ],
    $jsonData
);


// Get JSON data as InputBag

$jsonBag = $fakeRequest->json();


// Convert InputBag to normal PHP array

$data = $jsonBag->all();


// Get specific values using dot notation

$userName = $fakeRequest->json('user.name');

$userSkills = $fakeRequest->json(
    'user.profile.skills'
);


// Access the converted PHP array

$userId = $data['user']['id'];

$userCity = $data['user']['profile']['city'];</code></pre>

            </div>

        </div>


        {{-- Accessing Data Examples --}}
        <div class="card mb-4">

            <div class="card-header bg-warning text-dark">

                <h4 class="mb-0">
                    Accessing Data Examples
                </h4>

            </div>

            <div class="card-body">


                {{-- Dot Notation --}}
                <div class="method-example mb-4">

                    <h5>
                        Using Dot Notation with json()
                    </h5>

                    <p>

                        Laravel allows you to retrieve specific nested
                        values using dot notation.

                    </p>


                    <div class="row">


                        {{-- User Name --}}
                        <div class="col-md-6">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $request->json('user.name')
                                        </code>
                                    </h6>

                                    <div class="highlight">

                                        Result:

                                        <strong>
                                            "{{ $userName }}"
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- City --}}
                        <div class="col-md-6">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $request->json('user.profile.city')
                                        </code>
                                    </h6>

                                    <div class="highlight">

                                        @php
                                        $city = $convertedArray['user']['profile']['city'] ?? 'N/A';
                                        @endphp

                                        Result:

                                        <strong>
                                            "{{ $city }}"
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>


                    <div class="row">


                        {{-- Age --}}
                        <div class="col-md-6">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $request->json('user.profile.age')
                                        </code>
                                    </h6>

                                    <div class="highlight">

                                        @php
                                        $age = $convertedArray['user']['profile']['age'] ?? 'N/A';
                                        @endphp

                                        Result:

                                        <strong>
                                            {{ $age }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Skills --}}
                        <div class="col-md-6">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $request->json('user.profile.skills')
                                        </code>
                                    </h6>

                                    <div class="highlight">

                                        Result:

                                        @php
                                        $skills = $userSkills ?? [];
                                        @endphp

                                        @if(is_array($skills) && count($skills) > 0)

                                        <ul class="mb-0">

                                            @foreach($skills as $skill)

                                            <li>
                                                {{ $skill }}
                                            </li>

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


                {{-- Convert InputBag to Array --}}
                <div class="method-example mb-4">

                    <h5>
                        Convert InputBag to Array
                    </h5>

                    <p>

                        You can convert the InputBag into a normal PHP
                        array using the
                        <code>all()</code>
                        method.

                    </p>


                    <div class="row">


                        {{-- Array conversion --}}
                        <div class="col-md-6">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $dataArray = $request->json()->all();
                                        </code>
                                    </h6>

                                    <div class="highlight">

                                        <strong>
                                            Type:
                                        </strong>

                                        {{ gettype($convertedArray) }}

                                        <br>

                                        <strong>
                                            User Name:
                                        </strong>

                                        {{ $convertedArray['user']['name'] ?? 'N/A' }}

                                        <br>

                                        <strong>
                                            User City:
                                        </strong>

                                        {{ $convertedArray['user']['profile']['city'] ?? 'N/A' }}

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Default value --}}
                        <div class="col-md-6">

                            <div class="card mb-3">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $request->json(
                                            'user.email',
                                            'default@example.com'
                                            )
                                        </code>
                                    </h6>

                                    <div class="highlight">

                                        Result:

                                        <strong>
                                            "default@example.com"
                                        </strong>

                                        <p class="mt-2 mb-0">

                                            <small>

                                                The second parameter provides
                                                a default value when the
                                                requested key does not exist.

                                            </small>

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>


                {{-- Accessing Normal PHP Array --}}
                <div class="method-example">

                    <h5>
                        Accessing Converted PHP Array
                    </h5>

                    <p>

                        After calling
                        <code>$request->json()->all()</code>,
                        you can access nested values using normal
                        PHP array syntax.

                    </p>


                    <div class="row">


                        {{-- User ID --}}
                        <div class="col-md-4">

                            <div class="card">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $data['user']['id']
                                        </code>
                                    </h6>

                                    <div class="small">

                                        User ID:

                                        <strong>
                                            {{ $convertedArray['user']['id'] ?? 'N/A' }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- User Name --}}
                        <div class="col-md-4">

                            <div class="card">

                                <div class="card-body">

                                    <h6>
                                        <code>
                                            $data['user']['name']
                                        </code>
                                    </h6>

                                    <div class="small">

                                        User Name:

                                        <strong>
                                            {{ $convertedArray['user']['name'] ?? 'N/A' }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- User Email --}}
                        <div class="col-md-4">

                            <div class="card">

                                <div class="card-body">

                                    <h6>
                                        Checking Missing Key
                                    </h6>

                                    <div class="small">

                                        Has user.email?

                                        <strong>
                                            {{ isset($convertedArray['user']['email']) ? 'Yes' : 'No' }}
                                        </strong>

                                        <br>

                                        Has user.name?

                                        <strong>
                                            {{ isset($convertedArray['user']['name']) ? 'Yes' : 'No' }}
                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </div>


        {{-- InputBag vs Array --}}
        <div class="card mb-4">

            <div class="card-header bg-primary text-white">

                <h4 class="mb-0">
                    InputBag vs PHP Array
                </h4>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-light">

                            <tr>

                                <th>
                                    Operation
                                </th>

                                <th>
                                    Result
                                </th>

                                <th>
                                    Example
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>
                                    <code>$request->json()</code>
                                </td>

                                <td>
                                    Symfony InputBag
                                </td>

                                <td>
                                    <code>$jsonBag</code>
                                </td>

                            </tr>

                            <tr>

                                <td>
                                    <code>$request->json()->all()</code>
                                </td>

                                <td>
                                    PHP Array
                                </td>

                                <td>
                                    <code>$data</code>
                                </td>

                            </tr>

                            <tr>

                                <td>
                                    <code>$request->json('user.name')</code>
                                </td>

                                <td>
                                    Specific value
                                </td>

                                <td>
                                    <code>"John Doe"</code>
                                </td>

                            </tr>

                            <tr>

                                <td>
                                    <code>$data['user']['name']</code>
                                </td>

                                <td>
                                    Specific array value
                                </td>

                                <td>
                                    <code>"John Doe"</code>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Real World Use Case --}}
        <div class="card mb-4">

            <div class="card-header bg-dark text-white">

                <h4 class="mb-0">
                    Real-world Use Case
                </h4>

            </div>

            <div class="card-body">

                <p>

                    In a real Laravel application, you can receive
                    JSON data from an API client and access it through
                    the Request object.

                </p>

                <pre><code>// app/Http/Controllers/UserController.php

public function store(Request $request)
{
    // Validate JSON data

    $validated = $request->validate([
        'user.name' => 'required|string',
        'user.profile.age' => 'required|integer|min:18',
        'user.profile.skills' => 'array',
    ]);


    // Get JSON InputBag

    $jsonData = $request->json();


    // Convert InputBag to normal PHP array

    $dataArray = $jsonData->all();


    // Access values

    $name = $dataArray['user']['name'];

    $age = $dataArray['user']['profile']['age'];

    $skills = $dataArray['user']['profile']['skills'] ?? [];


    return response()->json([
        'message' => 'User created successfully',

        'data' => [
            'name' => $name,
            'age' => $age,
            'skills' => $skills,
            'full_data' => $dataArray,
        ],
    ]);
}</code></pre>

            </div>

        </div>


        {{-- Summary --}}
        <div class="card mb-4">

            <div class="card-header bg-success text-white">

                <h4 class="mb-0">
                    Summary
                </h4>

            </div>

            <div class="card-body">

                <ol>

                    <li class="mb-2">

                        <code>$request->json()</code>

                        returns a Symfony
                        <strong>InputBag</strong>.

                    </li>

                    <li class="mb-2">

                        <code>$request->json()->all()</code>

                        converts the InputBag into a
                        <strong>normal PHP array</strong>.

                    </li>

                    <li class="mb-2">

                        <code>$request->json('user.name')</code>

                        retrieves a specific nested value.

                    </li>

                    <li class="mb-2">

                        Once converted to an array, use normal PHP
                        array syntax such as:

                        <code>
                            $data['user']['name']
                        </code>

                    </li>

                    <li>

                        Do not use
                        <code>$bag->get('user')</code>
                        for nested array values because
                        <code>user</code> contains an array rather than
                        a scalar value.

                    </li>

                </ol>

            </div>

        </div>


        {{-- Back Button --}}
        <a
            href="{{ route('home') }}"
            class="btn btn-primary mb-4">
            Back to Home
        </a>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>