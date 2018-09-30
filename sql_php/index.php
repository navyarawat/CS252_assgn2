<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Search Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Employee Search Portal</h2>
  <hr>
  <a href="/query.php?searchtype=alldata" class="btn btn-default">All Data </a>

  <form action="/query.php">
    <div class="form-group">
      <label for="id">ID:</label>
	  <input type="text" name="searchtype" value="id" hidden>
      <input type="number" class="form-control" id="id" placeholder="Enter Employee ID" name="id">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  <!--  -->

  <form action="/query.php">
    <div class="form-group">
      <label for="lastname">Last Name:</label>
	  <input type="text" name="searchtype" value="lastname" hidden>
	  <input type="text" class="form-control" id="lastname" placeholder="Enter Employee's Last Name" name="lastname">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>

  <!--  -->
  <form action="/query.php">
    <div class="form-group">
      <label for="dept">Department:</label>
	  <input type="text" name="searchtype" value="dept" hidden>
      <input type="text" class="form-control" id="dept" placeholder="Enter Employee's Dept" name="dept">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  <hr>
  <h1> Summary </h1>
  <div class="container" style="display: flex; padding: 20px;border-style:solid;margin-top:30px;margin-bottom:30px; border-width:2px;align-content:center; justify-content:center; flex-wrap:wrap;">

      <?php
              $servername = 'localhost';
              $username = 'root';
              $password = 'root';
              $db = 'employees' ;
              $conn = new mysqli($servername, $username, $password,$db);
              if ($conn->connect_error) {
                 die("Connection failed: " . $conn->connect_error);
              }
              echo '<script>console.log(Connected successfully)</script>';
      		$sql = "SELECT DISTINCT dept_no FROM departments ORDER BY dept_no";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    $dept = $row["dept_no"] ;

                    $sql_in = "SELECT COUNT(employees.emp_no) FROM employees
                        INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
                        where dept_emp.dept_no = '".$dept."';" .

                    "SELECT COUNT(employees.emp_no) FROM employees
                    INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
                    where employees.gender = 'M' and dept_emp.dept_no = '".$dept."';" .

                    "SELECT COUNT(employees.emp_no) FROM employees
                    INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
                    where employees.gender = 'F' and dept_emp.dept_no = '".$dept."';" .

                    "SELECT SUM(salaries.salary) FROM employees
                    INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
                    INNER JOIN salaries ON salaries.emp_no=employees.emp_no
                    where employees.gender = 'M' and dept_emp.dept_no = '".$dept."';".

                    "SELECT SUM(salaries.salary) FROM employees
                    INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
                    INNER JOIN salaries ON salaries.emp_no=employees.emp_no
                    where employees.gender = 'F' and dept_emp.dept_no = '".$dept."';" ;

                    //
                    //     "SELECT COUNT(ID) FROM employees where gender = 'F' and DEPT = '".$dept."';".
                    //     "SELECT SUM(SALARY) FROM employees where gender = 'M' and DEPT = '".$dept."';".
                    //     "SELECT SUM(SALARY) FROM employees where gender = 'F' and DEPT = '".$dept."';" ;
                    $arr = array();
                    if (mysqli_multi_query($conn,$sql_in)){
                        do
                            {
                            // Store first result set
                            if ($result_in=mysqli_store_result($conn)) {
                              // Fetch one and one row
                              while ($row=mysqli_fetch_row($result_in))
                                {
                                    array_push($arr, $row[0]);

                                }
                              // Free result set
                              mysqli_free_result($result_in);
                              }
                            }
                          while (mysqli_next_result($conn));
                    }

                    echo "<div style='margin:30px; background-color:grey;padding:10px;align-content:center;color:white; text-align:center;'>
                            <h3>". $dept . "</h3> <hr style='width:60px;'>
                            <p> <strong> Count = </strong>".$arr[0]."</p>
                            <p> <strong> Gender Ratio = </strong>".($arr[1]/$arr[2])."</p>
                            <p> <strong> Gender Salary Ratio = </strong>".($arr[3]/$arr[4])."</p>


                        </div>";


                    // $result_in = $conn->multi_query($sql_in);
                    // $row = $result_in->fetch_assoc();
                    // echo $row[0]." ".$row[1]." ".$row[2]."<br>";
                    // $count_dept = $row[0];

                    // echo ."<br>";
                }
            }
      ?>

   </div>
</div>

</body>
</html>
