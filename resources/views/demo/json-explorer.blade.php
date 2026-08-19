<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --text-dark: #172033;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --background: #f5f7fb;
            --card: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text-dark);
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
        }

        /* =========================================
           Navbar
        ========================================= */

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            text-decoration: none;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: #ffffff;
            margin-right: 10px;
        }

        /* =========================================
           Main
        ========================================= */

        .page-wrapper {
            max-width: 1400px;
            margin: auto;
            padding: 35px 20px 60px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 750;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-description {
            color: var(--text-muted);
            font-size: 15px;
        }

        /* =========================================
           Cards
        ========================================= */

        .modern-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .card-header-modern {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            background: #ffffff;
        }

        .card-title {
            font-size: 17px;
            font-weight: 700;
            margin: 0;
        }

        .card-subtitle {
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 4px;
        }

        .card-body-modern {
            padding: 22px;
        }

        /* =========================================
           JSON Editor
        ========================================= */

        .json-editor-wrapper {
            position: relative;
        }

        .json-editor {
            min-height: 330px;
            resize: vertical;
            background: #111827;
            color: #e5e7eb;
            border: 1px solid #1f2937;
            border-radius: 12px;
            padding: 18px;
            font-family:
                "Cascadia Code",
                "Fira Code",
                Consolas,
                monospace;
            font-size: 14px;
            line-height: 1.65;
        }

        .json-editor:focus {
            background: #111827;
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .editor-label {
            position: absolute;
            top: 12px;
            right: 14px;
            background: #374151;
            color: #d1d5db;
            border-radius: 6px;
            padding: 4px 9px;
            font-size: 11px;
            z-index: 2;
        }

        /* =========================================
           Form
        ========================================= */

        .form-label {
            font-size: 13px;
            font-weight: 650;
            color: #374151;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            border: 1px solid #dfe3ea;
            border-radius: 9px;
            min-height: 44px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.10);
        }

        /* =========================================
           Buttons
        ========================================= */

        .btn {
            border-radius: 9px;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 16px;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-secondary {
            border-color: #d1d5db;
            color: #374151;
        }

        .btn-outline-secondary:hover {
            background: #f3f4f6;
            color: #111827;
        }

        /* =========================================
           Filter Section
        ========================================= */

        .filter-section {
            background: #f8fafc;
            border: 1px solid #edf0f5;
            border-radius: 12px;
            padding: 18px;
            margin-top: 20px;
        }

        .filter-title {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        /* =========================================
           Statistics
        ========================================= */

        .stat-card {
            position: relative;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            height: 100%;
            overflow: hidden;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 19px;
        }

        .stat-number {
            font-size: 26px;
            font-weight: 750;
            line-height: 1;
            margin-bottom: 7px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 13px;
        }

        .icon-primary {
            background: #eef2ff;
            color: #4f46e5;
        }

        .icon-success {
            background: #ecfdf5;
            color: #059669;
        }

        .icon-warning {
            background: #fffbeb;
            color: #d97706;
        }

        .icon-dark {
            background: #f3f4f6;
            color: #111827;
        }

        .icon-info {
            background: #eff6ff;
            color: #2563eb;
        }

        .icon-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        /* =========================================
           Result Summary
        ========================================= */

        .result-summary {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            color: #3730a3;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
        }

        .result-summary strong {
            font-weight: 750;
        }

        /* =========================================
           Export
        ========================================= */

        .export-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .export-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .export-description {
            color: var(--text-muted);
            font-size: 13px;
            margin: 0;
        }

        /* =========================================
           Array Output
        ========================================= */

        .code-output {
            background: #111827;
            color: #d1d5db;
            border-radius: 10px;
            padding: 20px;
            max-height: 450px;
            overflow: auto;
            font-family:
                "Cascadia Code",
                Consolas,
                monospace;
            font-size: 13px;
            line-height: 1.6;
        }

        /* =========================================
           Results
        ========================================= */

        .record-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            background: #ffffff;
            transition: .2s ease;
        }

        .record-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.08);
        }

        .record-header {
            padding: 13px 16px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .record-number {
            font-size: 13px;
            font-weight: 700;
        }

        .record-id {
            background: #eef2ff;
            color: #4338ca;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
        }

        .record-body {
            padding: 16px;
        }

        .table {
            font-size: 13px;
            margin-bottom: 0;
        }

        .table th {
            width: 35%;
            color: #4b5563;
            font-weight: 650;
            background: #fafafa;
        }

        .table td,
        .table th {
            padding: 10px;
            vertical-align: middle;
        }

        /* =========================================
           Status
        ========================================= */

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 650;
        }

        .status-active {
            background: #ecfdf5;
            color: #047857;
        }

        .status-inactive {
            background: #fef2f2;
            color: #b91c1c;
        }

        /* =========================================
           Pagination
        ========================================= */

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 5px 0;
        }

        .pagination {
            gap: 5px;
        }

        .pagination .page-link {
            border: 1px solid var(--border);
            border-radius: 8px !important;
            color: #374151;
            min-width: 40px;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
        }

        .pagination .active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
        }

        /* =========================================
           Alert
        ========================================= */

        .alert {
            border-radius: 11px;
            font-size: 14px;
        }

        /* =========================================
           Responsive
        ========================================= */

        @media (max-width: 768px) {

            .page-wrapper {
                padding: 25px 14px 45px;
            }

            .page-title {
                font-size: 25px;
            }

            .export-box {
                flex-direction: column;
                align-items: flex-start;
            }

            .json-editor {
                min-height: 250px;
            }

        }
    </style>

</head>

<body>


    {{-- =========================================
     TOP NAVBAR
========================================= --}}

    <nav class="topbar">

        <div class="container-fluid px-4 py-3">

            <div class="d-flex justify-content-between align-items-center">

                <a
                    href="{{ route('home') }}"
                    class="brand">

                    <span class="brand-icon">

                        <i class="bi bi-braces"></i>

                    </span>

                    JSON Toolkit

                </a>


                <a
                    href="{{ route('home') }}"
                    class="btn btn-outline-secondary">

                    <i class="bi bi-house me-1"></i>

                    Home

                </a>

            </div>

        </div>

    </nav>


    <div class="page-wrapper">


        {{-- =========================================
     PAGE HEADER
========================================= --}}

        <div class="mb-4">

            <div class="d-flex align-items-center gap-2 mb-2">

                <span class="badge bg-primary-subtle text-primary">

                    <i class="bi bi-code-slash me-1"></i>

                    JSON Tool

                </span>

            </div>

            <h1 class="page-title">

                {{ $title }}

            </h1>

            <p class="page-description mb-0">

                Convert JSON into PHP arrays and
                search, filter, sort, paginate and export your data.

            </p>

        </div>


        {{-- =========================================
     JSON INPUT
========================================= --}}

        <div class="modern-card mb-4">

            <div class="card-header-modern">

                <div class="d-flex align-items-center gap-3">

                    <div class="stat-icon icon-primary mb-0">

                        <i class="bi bi-braces"></i>

                    </div>

                    <div>

                        <h2 class="card-title">

                            JSON Input

                        </h2>

                        <div class="card-subtitle">

                            Paste your JSON data below to analyze it.

                        </div>

                    </div>

                </div>

            </div>


            <div class="card-body-modern">

                <form
                    method="POST"
                    action="{{ route('json.explore') }}">

                    @csrf


                    {{-- JSON Editor --}}

                    <div class="json-editor-wrapper mb-4">

                        <span class="editor-label">

                            JSON

                        </span>

                        <textarea
                            name="json"
                            class="form-control json-editor"
                            required>{{ old('json', $jsonInput) }}</textarea>

                    </div>


                    @error('json')

                    <div class="alert alert-danger">

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        {{ $message }}

                    </div>

                    @enderror


                    {{-- Filters --}}

                    <div class="filter-section">

                        <div class="filter-title">

                            <i class="bi bi-sliders me-2"></i>

                            Search & Filters

                        </div>


                        <div class="row">

                            {{-- Search --}}

                            <div class="col-lg-4 col-md-6 mb-3">

                                <label class="form-label">

                                    Search

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-white">

                                        <i class="bi bi-search"></i>

                                    </span>

                                    <input
                                        type="text"
                                        name="search"
                                        class="form-control"
                                        value="{{ old('search', $search) }}"
                                        placeholder="Search any value">

                                </div>

                            </div>


                            {{-- Filter Field --}}

                            <div class="col-lg-4 col-md-6 mb-3">

                                <label class="form-label">

                                    Filter Field

                                </label>

                                <input
                                    type="text"
                                    name="filter_field"
                                    class="form-control"
                                    value="{{ old('filter_field', $filterField) }}"
                                    placeholder="Example: category">

                            </div>


                            {{-- Filter Value --}}

                            <div class="col-lg-4 col-md-6 mb-3">

                                <label class="form-label">

                                    Filter Value

                                </label>

                                <input
                                    type="text"
                                    name="filter_value"
                                    class="form-control"
                                    value="{{ old('filter_value', $filterValue) }}"
                                    placeholder="Example: Electronics">

                            </div>


                            {{-- Sort Field --}}

                            <div class="col-lg-4 col-md-6 mb-3">

                                <label class="form-label">

                                    Sort Field

                                </label>

                                <input
                                    type="text"
                                    name="sort_field"
                                    class="form-control"
                                    value="{{ old('sort_field', $sortField) }}"
                                    placeholder="Example: price">

                            </div>


                            {{-- Sort Direction --}}

                            <div class="col-lg-4 col-md-6 mb-3">

                                <label class="form-label">

                                    Sort Direction

                                </label>

                                <select
                                    name="sort_direction"
                                    class="form-select">

                                    <option
                                        value="asc"
                                        {{ old('sort_direction', $sortDirection) === 'asc' ? 'selected' : '' }}>

                                        Ascending

                                    </option>

                                    <option
                                        value="desc"
                                        {{ old('sort_direction', $sortDirection) === 'desc' ? 'selected' : '' }}>

                                        Descending

                                    </option>

                                </select>

                            </div>


                            {{-- Per Page --}}

                            <div class="col-lg-4 col-md-6 mb-3">

                                <label class="form-label">

                                    Records Per Page

                                </label>

                                <select
                                    name="per_page"
                                    class="form-select">

                                    @foreach([5, 10, 15, 20, 50] as $number)

                                    <option
                                        value="{{ $number }}"
                                        {{ (int) old('per_page', $perPage) === $number ? 'selected' : '' }}>

                                        {{ $number }} records

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- Buttons --}}

                    <div class="d-flex gap-2 mt-4">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-search me-1"></i>

                            Explore JSON

                        </button>


                        <a
                            href="{{ route('json.explorer') }}"
                            class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Reset

                        </a>

                    </div>

                </form>

            </div>

        </div>


        {{-- =========================================
     ERROR
========================================= --}}

        @if($errorMessage)

        <div class="alert alert-danger shadow-sm mb-4">

            <i class="bi bi-exclamation-octagon me-2"></i>

            <strong>
                JSON Processing Error
            </strong>

            <div class="mt-1">

                {{ $errorMessage }}

            </div>

        </div>

        @endif


        @if($results !== null && !$errorMessage)


        {{-- =========================================
     STATISTICS
========================================= --}}

        @if($statistics)

        <div class="mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h2 class="card-title mb-1">

                        JSON Statistics

                    </h2>

                    <div class="card-subtitle">

                        Overview of your original JSON dataset.

                    </div>

                </div>

            </div>


            <div class="row g-3">

                {{-- Records --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-primary">

                            <i class="bi bi-database"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['total_records'] }}

                        </div>

                        <div class="stat-label">

                            Total Records

                        </div>

                    </div>

                </div>


                {{-- Fields --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-success">

                            <i class="bi bi-grid-3x3"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['total_fields'] }}

                        </div>

                        <div class="stat-label">

                            Total Fields

                        </div>

                    </div>

                </div>


                {{-- Strings --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-warning">

                            <i class="bi bi-fonts"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['string_values'] }}

                        </div>

                        <div class="stat-label">

                            String Values

                        </div>

                    </div>

                </div>


                {{-- Numbers --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-dark">

                            <i class="bi bi-123"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['numeric_values'] }}

                        </div>

                        <div class="stat-label">

                            Numeric Values

                        </div>

                    </div>

                </div>


                {{-- Boolean --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-success">

                            <i class="bi bi-toggle-on"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['boolean_values'] }}

                        </div>

                        <div class="stat-label">

                            Boolean Values

                        </div>

                    </div>

                </div>


                {{-- Null --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-danger">

                            <i class="bi bi-dash-circle"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['null_values'] }}

                        </div>

                        <div class="stat-label">

                            Null Values

                        </div>

                    </div>

                </div>


                {{-- Arrays --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-info">

                            <i class="bi bi-list-nested"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['array_values'] }}

                        </div>

                        <div class="stat-label">

                            Array Values

                        </div>

                    </div>

                </div>


                {{-- Objects --}}

                <div class="col-xl-3 col-md-6">

                    <div class="stat-card">

                        <div class="stat-icon icon-primary">

                            <i class="bi bi-box"></i>

                        </div>

                        <div class="stat-number">

                            {{ $statistics['object_values'] }}

                        </div>

                        <div class="stat-label">

                            Objects

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @endif


        {{-- =========================================
     RESULT SUMMARY
========================================= --}}

        <div class="result-summary mb-4">

            <i class="bi bi-info-circle me-2"></i>

            <strong>{{ $resultCount }}</strong>

            matching records found from

            <strong>{{ $totalItems }}</strong>

            total records.

        </div>


        {{-- =========================================
     EXPORT
========================================= --}}

        <div class="modern-card mb-4">

            <div class="card-body-modern">

                <div class="export-box">

                    <div>

                        <div class="export-title">

                            <i class="bi bi-download me-2"></i>

                            Export Data

                        </div>

                        <p class="export-description">

                            Download your processed JSON data in
                            JSON or CSV format.

                        </p>

                    </div>


                    <div class="d-flex gap-2">

                        {{-- JSON --}}

                        <form
                            method="POST"
                            action="{{ route('json.export') }}">

                            @csrf

                            <input
                                type="hidden"
                                name="json"
                                value="{{ $jsonInput }}">

                            <input
                                type="hidden"
                                name="search"
                                value="{{ $search }}">

                            <input
                                type="hidden"
                                name="filter_field"
                                value="{{ $filterField }}">

                            <input
                                type="hidden"
                                name="filter_value"
                                value="{{ $filterValue }}">

                            <input
                                type="hidden"
                                name="sort_field"
                                value="{{ $sortField }}">

                            <input
                                type="hidden"
                                name="sort_direction"
                                value="{{ $sortDirection }}">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-filetype-json me-1"></i>

                                JSON

                            </button>

                        </form>


                        {{-- CSV --}}

                        <form
                            method="POST"
                            action="{{ route('csv.export') }}">

                            @csrf

                            <input
                                type="hidden"
                                name="json"
                                value="{{ $jsonInput }}">

                            <input
                                type="hidden"
                                name="search"
                                value="{{ $search }}">

                            <input
                                type="hidden"
                                name="filter_field"
                                value="{{ $filterField }}">

                            <input
                                type="hidden"
                                name="filter_value"
                                value="{{ $filterValue }}">

                            <input
                                type="hidden"
                                name="sort_field"
                                value="{{ $sortField }}">

                            <input
                                type="hidden"
                                name="sort_direction"
                                value="{{ $sortDirection }}">

                            <button
                                type="submit"
                                class="btn btn-dark">

                                <i class="bi bi-filetype-csv me-1"></i>

                                CSV

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================
     CONVERTED ARRAY
========================================= --}}

        <div class="modern-card mb-4">

            <div class="card-header-modern">

                <div class="d-flex align-items-center gap-3">

                    <div class="stat-icon icon-dark mb-0">

                        <i class="bi bi-terminal"></i>

                    </div>

                    <div>

                        <h2 class="card-title">

                            Converted PHP Array

                        </h2>

                        <div class="card-subtitle">

                            JSON converted using PHP
                            <code>json_decode()</code>.

                        </div>

                    </div>

                </div>

            </div>


            <div class="card-body-modern">

                <pre class="code-output">{{ print_r($originalData, true) }}</pre>

            </div>

        </div>


        {{-- =========================================
     RESULTS
========================================= --}}

        <div class="modern-card mb-4">

            <div class="card-header-modern">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h2 class="card-title">

                            <i class="bi bi-table me-2"></i>

                            Results

                        </h2>

                        <div class="card-subtitle">

                            Filtered and processed JSON records.

                        </div>

                    </div>


                    <span class="badge bg-primary-subtle text-primary">

                        {{ $resultCount }} Results

                    </span>

                </div>

            </div>


            <div class="card-body-modern">

                @if($results->count() > 0)

                <div class="row g-3">

                    @foreach($results as $item)

                    <div class="col-xl-6">

                        <div class="record-card">

                            <div class="record-header">

                                <span class="record-number">

                                    Record #{{ (($currentPage - 1) * $perPage) + $loop->iteration }}

                                </span>


                                @if(is_array($item) && isset($item['id']))

                                <span class="record-id">

                                    ID: {{ $item['id'] }}

                                </span>

                                @endif

                            </div>


                            <div class="record-body">

                                @if(is_array($item))

                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <tbody>

                                            @foreach($item as $key => $value)

                                            <tr>

                                                <th>

                                                    {{ $key }}

                                                </th>

                                                <td>

                                                    @if(is_bool($value))

                                                    @if($value)

                                                    <span class="status-badge status-active">

                                                        <i class="bi bi-check-circle"></i>

                                                        true

                                                    </span>

                                                    @else

                                                    <span class="status-badge status-inactive">

                                                        <i class="bi bi-x-circle"></i>

                                                        false

                                                    </span>

                                                    @endif

                                                    @elseif(is_array($value))

                                                    <pre class="mb-0">{{ print_r($value, true) }}</pre>

                                                    @elseif(is_null($value))

                                                    <span class="text-muted">

                                                        null

                                                    </span>

                                                    @else

                                                    {{ $value }}

                                                    @endif

                                                </td>

                                            </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                                @else

                                {{ $item }}

                                @endif

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

                @else

                <div class="text-center py-5">

                    <div class="stat-icon icon-warning mx-auto">

                        <i class="bi bi-search"></i>

                    </div>

                    <h5 class="mt-3">

                        No matching records found

                    </h5>

                    <p class="text-muted mb-0">

                        Try changing your search or filter criteria.

                    </p>

                </div>

                @endif

            </div>

        </div>


        {{-- =========================================
     PAGINATION
========================================= --}}

        @if($resultCount > 0 && $totalPages > 1)

        <div class="modern-card">

            <div class="card-body-modern">

                <div class="pagination-wrapper">

                    <nav>

                        <ul class="pagination mb-0">

                            {{-- Previous --}}

                            <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">

                                @if($currentPage > 1)

                                <form
                                    method="POST"
                                    action="{{ route('json.explore') }}">

                                    @csrf

                                    <input type="hidden" name="json" value="{{ $jsonInput }}">

                                    <input type="hidden" name="search" value="{{ $search }}">

                                    <input type="hidden" name="filter_field" value="{{ $filterField }}">

                                    <input type="hidden" name="filter_value" value="{{ $filterValue }}">

                                    <input type="hidden" name="sort_field" value="{{ $sortField }}">

                                    <input type="hidden" name="sort_direction" value="{{ $sortDirection }}">

                                    <input type="hidden" name="per_page" value="{{ $perPage }}">

                                    <input type="hidden" name="page" value="{{ $currentPage - 1 }}">

                                    <button class="page-link">

                                        <i class="bi bi-chevron-left"></i>

                                    </button>

                                </form>

                                @else

                                <span class="page-link">

                                    <i class="bi bi-chevron-left"></i>

                                </span>

                                @endif

                            </li>


                            {{-- Pages --}}

                            @for($page = 1; $page <= $totalPages; $page++)

                                <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">

                                <form
                                    method="POST"
                                    action="{{ route('json.explore') }}">

                                    @csrf

                                    <input type="hidden" name="json" value="{{ $jsonInput }}">

                                    <input type="hidden" name="search" value="{{ $search }}">

                                    <input type="hidden" name="filter_field" value="{{ $filterField }}">

                                    <input type="hidden" name="filter_value" value="{{ $filterValue }}">

                                    <input type="hidden" name="sort_field" value="{{ $sortField }}">

                                    <input type="hidden" name="sort_direction" value="{{ $sortDirection }}">

                                    <input type="hidden" name="per_page" value="{{ $perPage }}">

                                    <input type="hidden" name="page" value="{{ $page }}">

                                    <button class="page-link">

                                        {{ $page }}

                                    </button>

                                </form>

                                </li>

                                @endfor


                                {{-- Next --}}

                                <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">

                                    @if($currentPage < $totalPages)

                                        <form
                                        method="POST"
                                        action="{{ route('json.explore') }}">

                                        @csrf

                                        <input type="hidden" name="json" value="{{ $jsonInput }}">

                                        <input type="hidden" name="search" value="{{ $search }}">

                                        <input type="hidden" name="filter_field" value="{{ $filterField }}">

                                        <input type="hidden" name="filter_value" value="{{ $filterValue }}">

                                        <input type="hidden" name="sort_field" value="{{ $sortField }}">

                                        <input type="hidden" name="sort_direction" value="{{ $sortDirection }}">

                                        <input type="hidden" name="per_page" value="{{ $perPage }}">

                                        <input type="hidden" name="page" value="{{ $currentPage + 1 }}">

                                        <button class="page-link">

                                            <i class="bi bi-chevron-right"></i>

                                        </button>

                                        </form>

                                        @else

                                        <span class="page-link">

                                            <i class="bi bi-chevron-right"></i>

                                        </span>

                                        @endif

                                </li>

                        </ul>

                    </nav>

                </div>

            </div>

        </div>

        @endif


        @endif


    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>