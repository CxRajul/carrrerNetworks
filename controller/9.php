<?php 
    // Database connection parameters
    $host = 'localhost';
    $dbname = 'your_database_name';
    $username = 'your_username';
    $password = 'your_password';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "
        SELECT 
            d.department_id,
            d.department_name,
            COALESCE(AVG(s.amount), 0) AS avg_sales_per_employee
        FROM 
            departments d
        LEFT JOIN 
            employees e ON d.department_id = e.department_id
        LEFT JOIN 
            sales s ON e.employee_id = s.employee_id
        GROUP BY 
            d.department_id, d.department_name
    ";

    

##-------------- REST CODE -------------

?>