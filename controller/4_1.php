<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$current_year = date('Y');
$sql = "
    SELECT
    employee_id,
    sale_date,
    amount,
    SUM(amount) OVER (PARTITION BY employee_id ORDER BY sale_date ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS cumulative_sales,
    (SUM(amount) OVER (PARTITION BY employee_id ORDER BY sale_date ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) /
     SUM(amount) OVER (PARTITION BY employee_id)) * 100 AS cumulative_percentage
FROM
    sales
ORDER BY
    employee_id, sale_date;
";

##-------------- REST CODE -------------
?>
