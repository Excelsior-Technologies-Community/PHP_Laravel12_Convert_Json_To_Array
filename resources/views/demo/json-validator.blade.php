<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background-color: #f8f9fa;
        }

        .json-editor {
            font-family: 'Courier New', monospace;
            min-height: 300px;
            font-size: 15px;
        }

        .json-output {
            background-color: #212529;
            color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            overflow-x: auto;
        }

        .stat-card {
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .success-box {
            border-left: 5px solid #198754;
        }

        .error-box {
            border-left: 5px solid #dc3545;
        }
    </style>
</head>

<body>

<div class="container py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>

            <li class="breadcrumb-item active">
                JSON Validator
            </li>
        </ol>
    </nav>

    <!-- Heading -->
    <div class="mb-4">
        <h1>{{ $title }}</h1>

        <p class="text-muted">
            Validate JSON, detect syntax errors and convert valid JSON
            into a PHP associative array using <code>json_decode()</code>.
        </p>
    </div>

    <!-- Input -->
    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Enter JSON
            </h4>
        </div>

        <div class="card-body">

            <form
                action="{{ route('json.validate') }}"
                method="POST"
            >

                @csrf

                <div class="mb-3">

                    <textarea
                        name="json"
                        class="form-control json-editor"
                        placeholder='Enter JSON here...'
                    >{{ old('json', $jsonInput) }}</textarea>

                </div>

                @error('json')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Validate JSON
                </button>

                <a
                    href="{{ route('home') }}"
                    class="btn btn-secondary"
                >
                    Back to Home
                </a>

            </form>

        </div>
    </div>


    <!-- Validation Result -->

    @if($isValid === true)

        <div class="alert alert-success success-box shadow-sm">

            <h4 class="alert-heading">
                ✓ Valid JSON
            </h4>

            <p class="mb-0">
                The supplied JSON was successfully decoded into a PHP array.
            </p>

        </div>

        <!-- Statistics -->

        <div class="row mb-4">

            <div class="col-md-4 mb-3">

                <div class="card stat-card bg-success text-white h-100">

                    <h3>
                        Valid
                    </h3>

                    <p class="mb-0">
                        JSON Status
                    </p>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card stat-card bg-info text-white h-100">

                    <h3>
                        {{ $jsonType }}
                    </h3>

                    <p class="mb-0">
                        Decoded Type
                    </p>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card stat-card bg-dark text-white h-100">

                    <h3>
                        {{ $itemCount }}
                    </h3>

                    <p class="mb-0">
                        Top-Level Items
                    </p>

                </div>

            </div>

        </div>


        <!-- Converted Array -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-success text-white">

                <h4 class="mb-0">
                    Converted PHP Array
                </h4>

            </div>

            <div class="card-body">

                <div class="json-output">
{{ print_r($decodedData, true) }}
                </div>

            </div>

        </div>


        <!-- Pretty JSON -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-secondary text-white">

                <h4 class="mb-0">
                    Normalized JSON
                </h4>

            </div>

            <div class="card-body">

                <pre class="mb-0"><code>{{ json_encode($decodedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>

            </div>

        </div>


        <!-- Code Explanation -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-dark text-white">

                <h4 class="mb-0">
                    Conversion Code
                </h4>

            </div>

            <div class="card-body">

<pre><code>$decodedData = json_decode($jsonInput, true);

$errorCode = json_last_error();
$errorMessage = json_last_error_msg();

if ($errorCode === JSON_ERROR_NONE) {
    // JSON is valid
}</code></pre>

            </div>

        </div>

    @elseif($isValid === false)

        <div class="alert alert-danger error-box shadow-sm">

            <h4 class="alert-heading">
                ✕ Invalid JSON
            </h4>

            <p>
                The JSON could not be converted into an array.
            </p>

            <hr>

            <p class="mb-0">

                <strong>Error Code:</strong>
                {{ $errorCode }}

                <br>

                <strong>Error Message:</strong>
                {{ $errorMessage }}

            </p>

        </div>


        <div class="card shadow-sm mb-4">

            <div class="card-header bg-danger text-white">

                <h4 class="mb-0">
                    JSON Error Diagnostics
                </h4>

            </div>

            <div class="card-body">

                <table class="table table-bordered mb-0">

                    <tr>
                        <th width="30%">
                            Error Code
                        </th>

                        <td>
                            {{ $errorCode }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Error Message
                        </th>

                        <td>
                            {{ $errorMessage }}
                        </td>
                    </tr>

                </table>

            </div>

        </div>

    @endif


    <!-- Information -->

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-warning text-dark">

            <h4 class="mb-0">
                Why Validate JSON?
            </h4>

        </div>

        <div class="card-body">

            <ul class="mb-0">

                <li>
                    Prevent invalid JSON from breaking application logic.
                </li>

                <li>
                    Use <code>json_last_error()</code> to identify errors.
                </li>

                <li>
                    Use <code>json_last_error_msg()</code> to display a readable error.
                </li>

                <li>
                    Use <code>json_decode($json, true)</code> to obtain an associative array.
                </li>

                <li>
                    Validate external API or user-provided JSON before processing it.
                </li>

            </ul>

        </div>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>