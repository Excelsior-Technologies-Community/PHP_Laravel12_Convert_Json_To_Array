# PHP_Laravel12_Convert_Json_To_Array

A clean and beginner-friendly Laravel 12 application demonstrating **multiple ways to convert JSON data into PHP arrays** using core PHP functions, Laravel helpers, HTTP API responses, and Collections.

This project is ideal for **learning, interviews, assignments, and real-world Laravel usage**.

---

## Project Overview

Working with JSON is very common in Laravel applications, especially when dealing with APIs, AJAX requests, and frontend frameworks. This project clearly explains and demonstrates **four practical methods** to convert JSON into arrays in Laravel.

The implementation focuses on:

* Simplicity
* Real examples
* Error handling
* Clean UI using Bootstrap 5

---

## Features

* Four different JSON → Array conversion methods
* Real API response handling examples
* Error handling and fallback scenarios
* Clean Blade views with Bootstrap 5
* Beginner-friendly and well-structured code
* Easy to extend for future use

---

## Prerequisites

* PHP 8.1 or higher
* Composer
* Laravel 12
* Node.js & NPM (for assets)
* Optional database (MySQL / SQLite / PostgreSQL)

---

## Screenshots

<img width="1783" height="972" alt="image" src="https://github.com/user-attachments/assets/2ac71f9f-eaa5-4841-a23e-65c3079f2985" />

<img width="1764" height="702" alt="image" src="https://github.com/user-attachments/assets/35e42021-ded5-45d4-9292-3b4cbb657c43" />

<img width="1759" height="888" alt="image" src="https://github.com/user-attachments/assets/95e02bd9-67d8-4e16-9580-1fe056ab627a" />

---

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/PHP_Laravel12_Convert_Json_To_Array.git
cd PHP_Laravel12_Convert_Json_To_Array
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Optional: Database Configuration

Edit `.env` if database usage is required:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_json
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Optional: Run Migrations

```bash
php artisan migrate
```

### 6. Start the Server

```bash
php artisan serve
```

Open in browser:

```
http://localhost:8000
```

---

## Project Structure

```
PHP_Laravel12_Convert_Json_To_Array/
├── app/
│   └── Http/
│       └── Controllers/
│           └── DemoController.php
├── resources/
│   └── views/
│       └── demo/
│           ├── index.blade.php
│           ├── example1.blade.php
│           ├── example2.blade.php
│           ├── example3.blade.php
│           ├── example4.blade.php
│           └── error.blade.php
├── routes/
│   └── web.php
├── public/
├── .env.example
├── composer.json
└── README.md
```

---

## JSON to Array Conversion Methods

### Method 1: Using `json_decode()`

```php
$jsonData = '[{"id": 1, "name": "John"}]';

$data = json_decode($jsonData, true);

foreach ($data as $item) {
    echo $item['name'];
}
```

---

### Method 2: Using HTTP Response `json()`

```php
use Illuminate\Support\Facades\Http;

$response = Http::get('https://api.example.com/data');
$data = $response->json();

if ($response->successful()) {
    echo $data['title'];
}
```

---

### Method 3: Using Request `json()`

```php
public function store(Request $request)
{
    $data = $request->json();

    $name = $request->json('user.name');
    $age = $request->json('user.profile.age');

    $dataArray = $data->all();
}
```

---

### Method 4: Using Laravel Collections

```php
$jsonData = '[{"product": "Laptop", "price": 999.99}]';

$collection = collect(json_decode($jsonData, true));

$total = $collection->sum('price');
$filtered = $collection->where('price', '>', 100);
$names = $collection->pluck('product');
```

---

## Routes Overview

| URL       | Description                   |
| --------- | ----------------------------- |
| /         | Homepage showing all methods  |
| /example1 | json_decode() example         |
| /example2 | HTTP response json()          |
| /example3 | Request json() example        |
| /example4 | Collection conversion example |

---

## Best Practices

* Always use `json_decode($json, true)` for associative arrays
* Validate JSON before decoding
* Prefer `Http::get()->json()` for API responses
* Use Collections for filtering and transformation
* Wrap API calls in try/catch blocks
* Use `json_last_error_msg()` for debugging JSON issues

---

## Common Issues & Solutions

* Invalid JSON format → Validate before decoding
* API timeout → Use try/catch and fallback handling
* Missing keys → Always check array keys using `isset()`

---

## License

This project is open-source and free to use for learning and educational purposes.
