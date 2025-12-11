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
        .method-example {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
        .collection-method {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
            font-family: 'Courier New', monospace;
            margin: 5px 0;
        }
        .product-card {
            transition: transform 0.2s;
            border: 1px solid #e0e0e0;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
            <strong>Note:</strong> This example shows the power of Laravel Collections for data manipulation after converting JSON to arrays.
        </div>

        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Method Used</h4>
            </div>
            <div class="card-body">
                <code>{{ $method }}</code>
                <p class="mt-2">Laravel Collections provide a fluent, convenient wrapper for working with arrays of data with dozens of helpful methods.</p>
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
                        <h4 class="mb-0">Converted Array (Before Collection)</h4>
                    </div>
                    <div class="card-body">
                        <div class="array-container">
                            <pre>@print_r($convertedArray, true)</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <h3>{{ count($convertedArray) }}</h3>
                    <p class="mb-0">Total Products</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h3>${{ number_format($totalValue, 2) }}</h3>
                    <p class="mb-0">Total Inventory Value</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h3>${{ number_format($averagePrice, 2) }}</h3>
                    <p class="mb-0">Average Price</p>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Controller Code</h4>
            </div>
            <div class="card-body">
                <pre><code>
// JSON data
$jsonData = '[
    {"id": 1, "product": "Laptop", "price": 999.99, "in_stock": true},
    {"id": 2, "product": "Mouse", "price": 29.99, "in_stock": true},
    {"id": 3, "product": "Keyboard", "price": 89.99, "in_stock": false},
    {"id": 4, "product": "Monitor", "price": 299.99, "in_stock": true}
]';

// Convert JSON to Collection
$collection = collect(json_decode($jsonData, true));

// Collection Methods Examples
$inStockProducts = $collection->where('in_stock', true);
$totalValue = $collection->sum('price');
$averagePrice = $collection->avg('price');
$expensiveProducts = $collection->where('price', '>', 100);
$productNames = $collection->pluck('product');
$groupedByStock = $collection->groupBy('in_stock');
$sortedByPrice = $collection->sortBy('price');

// Transform data
$transformed = $collection->map(function ($item) {
    return [
        'name' => strtoupper($item['product']),
        'price_usd' => '$' . number_format($item['price'], 2),
        'status' => $item['in_stock'] ? 'Available' : 'Out of Stock'
    ];
});
                </code></pre>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Products In Stock</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(isset($inStockProducts) && count($inStockProducts) > 0)
                                @foreach($inStockProducts as $product)
                                <div class="col-md-6 mb-3">
                                    <div class="card product-card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product['product'] }}</h5>
                                            <p class="card-text">
                                                <strong>Price:</strong> ${{ number_format($product['price'], 2) }}<br>
                                                <strong>ID:</strong> {{ $product['id'] }}<br>
                                                <span class="badge bg-success">In Stock</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <p class="text-muted">No products in stock.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Collection Methods Used</h4>
                    </div>
                    <div class="card-body">
                        <div class="collection-method">
                            <code>where('in_stock', true)</code>
                            <small class="d-block text-muted">Filters items where in_stock is true</small>
                        </div>
                        <div class="collection-method">
                            <code>sum('price')</code>
                            <small class="d-block text-muted">Sums all price values</small>
                        </div>
                        <div class="collection-method">
                            <code>avg('price')</code>
                            <small class="d-block text-muted">Calculates average price</small>
                        </div>
                        <div class="collection-method">
                            <code>count()</code>
                            <small class="d-block text-muted">Counts total items</small>
                        </div>
                        <div class="collection-method">
                            <code>pluck('product')</code>
                            <small class="d-block text-muted">Extracts product names only</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">More Collection Examples</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="method-example">
                            <h5>Filter Products > $100</h5>
                            @php
                                $expensiveProducts = collect($convertedArray)->where('price', '>', 100);
                            @endphp
                            <ul class="list-group">
                                @foreach($expensiveProducts as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $product['product'] }}
                                    <span class="badge bg-primary rounded-pill">
                                        ${{ number_format($product['price'], 2) }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            <small class="text-muted mt-2 d-block">
                                Method: <code>where('price', '>', 100)</code>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="method-example">
                            <h5>Extract Product Names Only</h5>
                            @php
                                $productNames = collect($convertedArray)->pluck('product');
                            @endphp
                            <div class="alert alert-info">
                                <h6>Product Names:</h6>
                                <ul class="mb-0">
                                    @foreach($productNames as $name)
                                    <li>{{ $name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                Method: <code>pluck('product')</code>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="method-example">
                            <h5>Sort by Price (Low to High)</h5>
                            @php
                                $sortedByPrice = collect($convertedArray)->sortBy('price');
                            @endphp
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sortedByPrice as $product)
                                    <tr>
                                        <td>{{ $product['product'] }}</td>
                                        <td>${{ number_format($product['price'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <small class="text-muted mt-2 d-block">
                                Method: <code>sortBy('price')</code>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="method-example">
                            <h5>Transform Data</h5>
                            @php
                                $transformed = collect($convertedArray)->map(function ($item) {
                                    return [
                                        'product' => strtoupper($item['product']),
                                        'formatted_price' => '$' . number_format($item['price'], 2),
                                        'status' => $item['in_stock'] ? '✅ IN STOCK' : '❌ OUT OF STOCK'
                                    ];
                                });
                            @endphp
                            <div class="alert alert-light">
                                @foreach($transformed as $item)
                                <div class="mb-2">
                                    <strong>{{ $item['product'] }}</strong><br>
                                    Price: {{ $item['formatted_price'] }}<br>
                                    Status: {{ $item['status'] }}
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted mt-2 d-block">
                                Method: <code>map(function ($item) { ... })</code>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Benefits of Using Collections</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Fluent API</h5>
                                <p class="card-text">Chain multiple methods together for complex operations.</p>
                                <code class="d-block small">
                                    $result = $collection<br>
                                    &nbsp;&nbsp;->filter()<br>
                                    &nbsp;&nbsp;->map()<br>
                                    &nbsp;&nbsp;->sortBy()<br>
                                    &nbsp;&nbsp;->groupBy();
                                </code>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Rich Methods</h5>
                                <p class="card-text">Over 100 methods for filtering, sorting, transforming, and aggregating data.</p>
                                <ul class="small mb-0">
                                    <li>where(), filter()</li>
                                    <li>map(), transform()</li>
                                    <li>sortBy(), sortByDesc()</li>
                                    <li>groupBy(), keyBy()</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Lazy Evaluation</h5>
                                <p class="card-text">Some operations are performed only when needed, improving performance.</p>
                                <code class="d-block small">
                                    $lazy = $collection<br>
                                    &nbsp;&nbsp;->lazy()<br>
                                    &nbsp;&nbsp;->map(fn($item) => $item * 2);
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary mb-4">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>