<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$current_year = date('Y');
$sql = "SELECT 
  s.employee_id, 
  s.sale_date, 
  s.amount, 
  (
    SELECT 
      MAX(s2.amount) 
    FROM 
      sales s2 
    WHERE 
      s2.employee_id = s.employee_id 
      AND s2.sale_date < s.sale_date
  ) AS previous_sale_amount, 
  s.amount - (
    SELECT 
      MAX(s2.amount) 
    FROM 
      sales s2 
    WHERE 
      s2.employee_id = s.employee_id 
      AND s2.sale_date < s.sale_date
  ) AS sale_difference 
FROM 
  sales s 
ORDER BY 
  s.employee_id, 
  S.sale_date;
";

##-------------- REST CODE -------------
?>
