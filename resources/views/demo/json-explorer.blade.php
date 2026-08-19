<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

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
            min-height: 350px;
            font-family: 'Courier New', monospace;
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

        .result-card {
            transition: transform 0.2s;
        }

        .result-card:hover {
            transform: translateY(-3px);
        }

    </style>

</head>

<body>

<div class="container py-4">

    <!-- Breadcrumb -->

    <nav aria-label="breadcrumb">

        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">
                    Home
                </a>
            </li>

            <li class="breadcrumb-item active">
                JSON Collection Explorer
            </li>

        </ol>

    </nav>


    <!-- Heading -->

    <div class="mb-4">

        <h1>
            {{ $title }}
        </h1>

        <p class="text-muted">

            Convert JSON into a Laravel Collection and
            search, filter and sort the resulting data.

        </p>

    </div>


    <!-- JSON Input -->

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">

            <h4 class="mb-0">
                JSON Input
            </h4>

        </div>

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('json.explore') }}"
            >

                @csrf

                <div class="mb-3">

                    <textarea
                        name="json"
                        class="form-control json-editor"
                        required
                    >{{ old('json', $jsonInput) }}</textarea>

                </div>

                @error('json')

                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>

                @enderror


                <!-- Search -->

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ old('search', $search) }}"
                            placeholder="Search any value..."
                        >

                        <small class="text-muted">
                            Searches across all top-level fields.
                        </small>

                    </div>


                    <!-- Filter Field -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Filter Field
                        </label>

                        <input
                            type="text"
                            name="filter_field"
                            class="form-control"
                            value="{{ old('filter_field', $filterField) }}"
                            placeholder="Example: category"
                        >

                    </div>


                    <!-- Filter Value -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Filter Value
                        </label>

                        <input
                            type="text"
                            name="filter_value"
                            class="form-control"
                            value="{{ old('filter_value', $filterValue) }}"
                            placeholder="Example: Electronics"
                        >

                    </div>

                </div>


                <!-- Sorting -->

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Sort Field
                        </label>

                        <input
                            type="text"
                            name="sort_field"
                            class="form-control"
                            value="{{ old('sort_field', $sortField) }}"
                            placeholder="Example: price"
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Sort Direction
                        </label>

                        <select
                            name="sort_direction"
                            class="form-select"
                        >

                            <option
                                value="asc"
                                {{ old('sort_direction', $sortDirection) === 'asc' ? 'selected' : '' }}
                            >
                                Ascending
                            </option>

                            <option
                                value="desc"
                                {{ old('sort_direction', $sortDirection) === 'desc' ? 'selected' : '' }}
                            >
                                Descending
                            </option>

                        </select>

                    </div>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Explore JSON
                </button>


                <a
                    href="{{ route('json.explorer') }}"
                    class="btn btn-secondary"
                >
                    Reset
                </a>


                <a
                    href="{{ route('home') }}"
                    class="btn btn-outline-dark"
                >
                    Back to Home
                </a>

            </form>

        </div>

    </div>


    <!-- Error -->

    @if($errorMessage)

        <div class="alert alert-danger">

            <h4 class="alert-heading">
                JSON Processing Error
            </h4>

            <p class="mb-0">
                {{ $errorMessage }}
            </p>

        </div>

    @endif


    @if($results !== null && !$errorMessage)

        <!-- Statistics -->

        <div class="row mb-4">

            <div class="col-md-4 mb-3">

                <div class="card bg-primary text-white stat-card">

                    <h2>
                        {{ $totalItems }}
                    </h2>

                    <p class="mb-0">
                        Original Items
                    </p>

                </div>

            </div>


            <div class="col-md-4 mb-3">

                <div class="card bg-success text-white stat-card">

                    <h2>
                        {{ $resultCount }}
                    </h2>

                    <p class="mb-0">
                        Matching Items
                    </p>

                </div>

            </div>


            <div class="col-md-4 mb-3">

                <div class="card bg-dark text-white stat-card">

                    <h2>
                        Collection
                    </h2>

                    <p class="mb-0">
                        Laravel Data Structure
                    </p>

                </div>

            </div>

        </div>


        <!-- Applied Operations -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-warning text-dark">

                <h4 class="mb-0">
                    Applied Collection Operations
                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">

                        <strong>
                            Search
                        </strong>

                        <p>
                            {{ $search !== '' ? $search : 'Not applied' }}
                        </p>

                    </div>


                    <div class="col-md-3">

                        <strong>
                            Filter
                        </strong>

                        <p>

                            @if($filterField && $filterValue)

                                {{ $filterField }} = {{ $filterValue }}

                            @else

                                Not applied

                            @endif

                        </p>

                    </div>


                    <div class="col-md-3">

                        <strong>
                            Sort Field
                        </strong>

                        <p>
                            {{ $sortField !== '' ? $sortField : 'Not applied' }}
                        </p>

                    </div>


                    <div class="col-md-3">

                        <strong>
                            Direction
                        </strong>

                        <p>
                            {{ strtoupper($sortDirection) }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Original Array -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-secondary text-white">

                <h4 class="mb-0">
                    Converted PHP Array
                </h4>

            </div>

            <div class="card-body">

                <div class="json-output">
{{ print_r($originalData, true) }}
                </div>

            </div>

        </div>


        <!-- Results -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-success text-white">

                <h4 class="mb-0">
                    Filtered / Sorted Collection Results
                </h4>

            </div>

            <div class="card-body">

                @if($results->count() > 0)

                    <div class="row">

                        @foreach($results as $item)

                            <div class="col-md-6 mb-3">

                                <div class="card result-card h-100">

                                    <div class="card-header">

                                        <strong>
                                            Result #{{ $loop->iteration }}
                                        </strong>

                                    </div>

                                    <div class="card-body">

                                        @if(is_array($item))

                                            <table class="table table-sm table-bordered mb-0">

                                                <tbody>

                                                    @foreach($item as $key => $value)

                                                        <tr>

                                                            <th width="35%">
                                                                {{ $key }}
                                                            </th>

                                                            <td>

                                                                @if(is_bool($value))

                                                                    <span
                                                                        class="badge {{ $value ? 'bg-success' : 'bg-danger' }}"
                                                                    >
                                                                        {{ $value ? 'true' : 'false' }}
                                                                    </span>

                                                                @elseif(is_array($value))

                                                                    <pre class="mb-0">{{ print_r($value, true) }}</pre>

                                                                @else

                                                                    {{ $value }}

                                                                @endif

                                                            </td>

                                                        </tr>

                                                    @endforeach

                                                </tbody>

                                            </table>

                                        @else

                                            {{ $item }}

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="alert alert-warning mb-0">

                        No matching records found.

                        Try changing your search or filter.

                    </div>

                @endif

            </div>

        </div>


        <!-- Collection Code -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-dark text-white">

                <h4 class="mb-0">
                    Collection Code Used
                </h4>

            </div>

            <div class="card-body">

<pre><code>// Convert JSON into PHP array
$data = json_decode($json, true);

// Convert array into Laravel Collection
$collection = collect($data);

// Search
$collection = $collection->filter(...);

// Filter
$collection = $collection->filter(...);

// Sort
$collection = $collection->sortBy('field');

// Convert final Collection back to array
$results = $collection->values();</code></pre>

            </div>

        </div>


        <!-- Explanation -->

        <div class="card shadow-sm mb-4">

            <div class="card-header bg-info text-white">

                <h4 class="mb-0">
                    Why Use Collections?
                </h4>

            </div>

            <div class="card-body">

                <p>
                    After converting JSON into a PHP array,
                    Laravel Collections provide a convenient way
                    to manipulate the data.
                </p>

                <ul>

                    <li>
                        <code>filter()</code> - filter records
                    </li>

                    <li>
                        <code>sortBy()</code> - sort records
                    </li>

                    <li>
                        <code>sortByDesc()</code> - reverse sorting
                    </li>

                    <li>
                        <code>count()</code> - count records
                    </li>

                    <li>
                        <code>values()</code> - reset collection keys
                    </li>

                </ul>

            </div>

        </div>

    @endif

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>