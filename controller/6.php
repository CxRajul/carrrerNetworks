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
        SUM(amount) AS ytd_sales
    FROM 
        sales
    WHERE 
        YEAR(sale_date) = :year
    GROUP BY 
        employee_id
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['year' => $current_year]);
$ytd_sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results

##-------------- REST CODE -------------
?>
