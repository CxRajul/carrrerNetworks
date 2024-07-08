1 -> SELECT 
        department_id,
        name,
        salary
    FROM (
        SELECT 
            department_id,
            name,
            salary,
            DENSE_RANK() OVER (PARTITION BY department_id ORDER BY salary DESC) AS salary_rank
        FROM employees
    ) AS ranked_salaries
    WHERE salary_rank = 2;


    OR


    SELECT 
        e.department_id,
        e.name,
        e.salary
    FROM employees e
    WHERE e.salary = (
        SELECT MAX(e2.salary)
        FROM employees e2
        WHERE e2.department_id = e.department_id
            AND e2.salary < (
                SELECT MAX(e3.salary)
                FROM employees e3
                WHERE e3.department_id = e2.department_id
            )
    );



2-> 