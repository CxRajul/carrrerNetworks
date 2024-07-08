<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all products
    $sql = "SELECT product_id, product_name, category, price FROM products";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $topProdInCateg = [];
    foreach ($products as $product) {
        $category = $product['category'];
        $price = floatval($product['price']);
        if (!isset($topProdInCateg[$category])) {
            $topProdInCateg[$category] = [];
        }
        $topProdInCateg[$category][] = [
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'price' => $price
        ];
        usort($topProdInCateg[$category], function ($a, $b) {
            return $b['price'] <=> $a['price'];
        });
        if (count($topProdInCateg[$category]) > 3) {
            array_splice($topProdInCateg[$category], 3);
        }
    }
    echo "<h2>Top 3 Most Expensive Products in Each Category:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Category</th><th>Product Name</th><th>Price</th></tr>";
    foreach ($topProdInCateg as $category => $products) {
        foreach ($products as $product) {
            echo "<tr>";
            echo "<td>" . $category . "</td>";
            echo "<td>" . $product['product_name'] . "</td>";
            echo "<td>" . number_format($product['price'], 2) . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
?>
