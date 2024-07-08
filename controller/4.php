<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT employee_id, sale_date, amount FROM sales ORDER BY employee_id, sale_date";
$stmt = $pdo->query($sql);
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);
$cumulative_sales = [];
$total_sales = [];
$cumulative_percentage = [];
foreach ($sales as $sale) {
    $employee_id = $sale['employee_id'];
    $amount = floatval($sale['amount']);
    if (!isset($cumulative_sales[$employee_id])) {
        $cumulative_sales[$employee_id] = 0;
        $total_sales[$employee_id] = 0;
    }
    $total_sales[$employee_id] += $amount;
    $cumulative_sales[$employee_id] += $amount;
    $cumulative_percentage[$employee_id] = ($cumulative_sales[$employee_id] / $total_sales[$employee_id]) * 100;
}

// Display the results
echo "<h2>Cumulative Percentage of Total Sales Amount for Each Employee:</h2>";
echo "<table border='1'>";
echo "<tr><th>Employee ID</th><th>Sale Date</th><th>Amount</th><th>Cumulative Percentage (%)</th></tr>";
foreach ($sales as $sale) {
    $employee_id = $sale['employee_id'];
    $sale_date = $sale['sale_date'];
    $amount = $sale['amount'];

    echo "<tr>";
    echo "<td>" . $employee_id . "</td>";
    echo "<td>" . $sale_date . "</td>";
    echo "<td>" . number_format($amount, 2) . "</td>";
    echo "<td>" . number_format($cumulative_percentage[$employee_id], 2) . "</td>";
    echo "</tr>";
}
echo "</table>";

?>
