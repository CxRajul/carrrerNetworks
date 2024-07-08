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
  e.department_id, 
  e.name, 
  e.salary 
FROM 
  employees e 
WHERE 
  e.salary = (
    SELECT 
      MAX(e2.salary) 
    FROM 
      employees e2 
    WHERE 
      e2.department_id = e.department_id 
      AND e2.salary < (
        SELECT 
          MAX(e3.salary) 
        FROM 
          employees e3 
        WHERE 
          e3.department_id = e2.department_id
      )
  );
";

##-------------- REST CODE -------------
?>
