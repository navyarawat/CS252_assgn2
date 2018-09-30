<?php
$servername = "localhost";
$username = "root";
$password = "root";
$db = "employees";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
$search_type = $_GET["searchtype"];
if($search_type == "id"){
//     SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate
//
// INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;

	$sql = "SELECT * FROM employees
        INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
        where employees.emp_no=".$_GET["id"]." ORDER BY employees.hire_date DESC";
}
else if($search_type == "lastname"){

	$sql = "SELECT * FROM employees
        INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
    where employees.last_name='".$_GET["lastname"]."' ORDER BY employees.hire_date DESC";
}
else if($search_type == "dept"){
	$sql = "SELECT * FROM employees
        INNER JOIN dept_emp ON dept_emp.emp_no=employees.emp_no
         where dept_emp.dept_no='".$_GET["dept"]."' ORDER BY employees.hire_date DESC";
}
elseif ($search_type = "alldata") {
    $sql = "SELECT * FROM employees ";
}

// $sql = "SELECT * FROM EMPLOYEES";
$result = $conn->query($sql);
echo '<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <h2>Search Results</h2>
  <a  class="btn btn-default" href="index.php">Back to Portal</a>';

if ($result->num_rows > 0) {
    // output data of each row
    echo " <h3>".$result->num_rows. " results </h3>" ;
	echo '<table class="table">
		<thead>
	      <tr>
		  <th>ID</th>
	        <th>Firstname</th>
	        <th>Lastname</th>
	        <th>Dept</th>
			<th>Gender</th>
			<th>Hire Date</th>
            <th> Birth Date </th>
	      </tr>
	    </thead>
		<tbody>';
    while($row = $result->fetch_assoc()) {

		echo '<tr>
				<td>'.$row["emp_no"].' </td>'.
				'<td>'.$row["first_name"].' </td>'.
				'<td>'.$row["last_name"].' </td>'.
				'<td>'.$row["dept_no"].' </td>'.
				'<td>'.$row["gender"].' </td>'.
				'<td>'.$row["hire_date"].' </td>'.
                '<td>'.$row["birth_date"].' </td>
                </tr>' ;
    }
	echo "</tbody></table>";
} else {
    echo "<h3>0 results</h3>";
}



$conn->close();
?>
