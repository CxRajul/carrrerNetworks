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
        s.employee_id,
        s.amount AS employee_sales,
        d.department_id,
        d.department_name,
        SUM(s.amount) OVER (PARTITION BY s.department_id) AS department_total_sales
    FROM 
        sales s
    INNER JOIN 
        employees e ON s.employee_id = e.employee_id
    INNER JOIN 
        departments d ON e.department_id = d.department_id
";

$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$employee_percentage_sales = [];
foreach ($results as $row) {
    $employee_id = $row['employee_id'];
    $department_id = $row['department_id'];
    $employee_sales = floatval($row['employee_sales']);
    $department_total_sales = floatval($row['department_total_sales']);
    $percentage_sales = ($department_total_sales != 0) ? ($employee_sales / $department_total_sales) * 100 : 0;
    $employee_percentage_sales[] = [
        'employee_id' => $employee_id,
        'department_id' => $department_id,
        'department_name' => $row['department_name'],
        'employee_sales' => $employee_sales,
        'department_total_sales' => $department_total_sales,
        'percentage_sales' => $percentage_sales
    ];
}

##-------------- REST CODE -------------
?>
