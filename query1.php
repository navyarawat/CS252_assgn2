<!DOCTYPE html>
<html>
<head>
	<title>CS252</title>
</head>
<body>
 <table>

 	<tr>
 		<td>Employee Number</td>
 		<td>First Name</td>
 		<td>Last Name</td>
 		<td>Gender</td>
 		<td>Date of Birth</td>
 		<td>Department</td>
 	</tr>
<?php
$servername = "mysql";
$username = "root";
$password = "root";
date_default_timezone_set("Asia/kolkata");
$date = date("Y-m-d");
$db = "employees";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$type = $_REQUEST['type'];
$val = $_REQUEST['query_val'];
if (empty($type) || empty($val)) {
echo "Type or value is empty";
} else {
if($type==1){
		$sql = "SELECT * FROM employees WHERE emp_no=".$val;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		// output data of each row
			while($row = $result->fetch_assoc()) {
				//echo $row["first_name"];
				$dep_q = "SELECT * FROM dept_emp WHERE emp_no='$val'AND to_date >'$date' ";
				$result_dep = $conn->query($dep_q);

				while($row_dep = $result_dep->fetch_assoc()){
					$dep_id = $row_dep["dept_no"];
					$dep_q2 = "SELECT * FROM departments WHERE dept_no='$dep_id' ";
					$result_dep2 = $conn->query($dep_q2);
					while($row_dep2 = $result_dep2->fetch_assoc()){
						$dep_id2 = $row_dep2["dept_name"];
						 echo "<tr><td>" .$row["emp_no"]."</td><td> " . $row["first_name"]."</td><td> " .$row["last_name"]. "</td><td>".$row["gender"]."</td><td>".$row["birth_date"]."</td><td>".$dep_id2 ."</td></tr>";
					}
				}
				
			}
		} else {
		echo "0 results";
		}
}
else if($type==2){
	$sql = "SELECT * FROM employees WHERE last_name='$val' ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		// output data of each row
			while($row = $result->fetch_assoc()) {
				$emp_no = $row["emp_no"];
				$dep_q = "SELECT * FROM dept_emp WHERE emp_no='$emp_no'AND to_date >'$date' ";
				$result_dep = $conn->query($dep_q);

				while($row_dep = $result_dep->fetch_assoc()){
					$dep_id = $row_dep["dept_no"];
					$dep_q2 = "SELECT * FROM departments WHERE dept_no='$dep_id' ";
					$result_dep2 = $conn->query($dep_q2);
					while($row_dep2 = $result_dep2->fetch_assoc()){
						$dep_id2 = $row_dep2["dept_name"];
						 echo "<tr><td>" .$row["emp_no"]."</td><td> " . $row["first_name"]."</td><td> " .$row["last_name"]. "</td><td>".$row["gender"]."</td><td>".$row["birth_date"]."</td><td>".$dep_id2 ."</td></tr>";
					}
				}
				
			}
		} else {
		echo "0 results";
		}	
}
else if($type==3){
	$sql = "SELECT * FROM departments WHERE dept_name='$val' ";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			
			while($row = $result->fetch_assoc()) {
				$dept_no = $row["dept_no"];
				$dep_q = "SELECT * FROM dept_emp WHERE dept_no='$dept_no' ";
				$result_dep = $conn->query($dep_q);

				while($row_dep = $result_dep->fetch_assoc()){
					$emp_no = $row_dep["emp_no"];
					$dep_q2 = "SELECT * FROM employees WHERE emp_no='$emp_no' ";
					$result_dep2 = $conn->query($dep_q2);
					while($row_dep2 = $result_dep2->fetch_assoc()){
						 echo "<tr><td>" .$row_dep2["emp_no"]."</td><td> " . $row_dep2["first_name"]."</td><td> " .$row_dep2["last_name"]. "</td><td>".$row_dep2["gender"]."</td><td>".$row_dep2["birth_date"]."</td><td>".$val ."</td></tr>";
					}
				}
				
			}
		} else {
		echo "0 results";
		}
}
else{
	die("Invalid type of query");
}
}
}
?>
</table>
</body>
</html>

