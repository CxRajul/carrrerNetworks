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
    SELECT name, total_sales
FROM (
    SELECT e.name, SUM(s.amount) AS total_sales,
           ROW_NUMBER() OVER (ORDER BY SUM(s.amount) DESC) AS sales_rank
    FROM employees e
    JOIN sales s ON e.employee_id = s.employee_id
    GROUP BY e.employee_id, e.name
) AS ranked_sales
WHERE sales_rank = 2;
";

##-------------- REST CODE -------------
?>
