<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\ProductRequest;

$product = Product::latest()->first();
if (! $product) {
    echo "No products found.\n";
    exit(1);
}

$pr = ProductRequest::create([
    'product_id' => $product->id,
    'user_id' => null,
    'customer_name' => 'Automated Test Customer',
    'customer_phone' => '000000000',
    'message' => 'Test request created by script',
    'status' => 'pending',
]);

echo "Created ProductRequest id={$pr->id} product_id={$pr->product_id} customer={$pr->customer_name}\n";
