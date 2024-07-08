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
  e.employee_id, 
  e.name, 
  e.department_id, 
  e.salary, 
  d.avg_salary_in_department, 
  e.salary - d.avg_salary_in_department AS salary_difference 
FROM 
  employees e 
  JOIN (
    SELECT 
      department_id, 
      AVG(salary) AS avg_salary_in_department 
    FROM 
      employees 
    GROUP BY 
      department_id
  ) AS d ON e.department_id = d.department_id 
ORDER BY 
  e.employee_id;
";

##-------------- REST CODE -------------
?>
