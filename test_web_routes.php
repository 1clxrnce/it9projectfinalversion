<?php

/**
 * Web Routes Test Script
 * Tests admin web interface routes
 */

echo "=== WEB ROUTES TEST ===\n\n";

$baseUrl = 'http://127.0.0.1:8000';

// Test routes
$routes = [
    'Home Page' => '/',
    'Login Page' => '/login',
    'Dashboard' => '/dashboard',
    'Products (Public)' => '/products',
    'Admin Products' => '/admin/products',
    'Admin Categories' => '/admin/categories',
    'Admin Brands' => '/admin/brands',
    'Admin Users' => '/admin/users',
    'Inventory' => '/inventory',
    'Transactions' => '/transactions',
    'Create Transaction' => '/transactions/create',
];

echo "Testing route accessibility (without authentication):\n";
foreach ($routes as $name => $route) {
    $url = $baseUrl . $route;
    
    // Use curl to test the route
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD request only
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $status = '';
    switch ($httpCode) {
        case 200:
            $status = '✓ OK';
            break;
        case 302:
            $status = '→ Redirect (likely to login)';
            break;
        case 404:
            $status = '✗ Not Found';
            break;
        case 500:
            $status = '✗ Server Error';
            break;
        default:
            $status = "? HTTP {$httpCode}";
    }
    
    echo sprintf("  %-25s %-30s %s\n", $name, $route, $status);
}

echo "\n=== ROUTE TEST COMPLETED ===\n";
echo "Note: Protected routes should redirect to login (302)\n";
echo "Public routes should return OK (200)\n";
echo "\nTo test admin functionality:\n";
echo "1. Visit: {$baseUrl}/login\n";
echo "2. Login with: admin@example.com / password\n";
echo "3. Access admin features from the dashboard\n";