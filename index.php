<?php
// connect to mongodb
$m = new MongoDB\Driver\Manager();

//echo "Connection to database successfully";
// select a database
$filter = [];
$options = [];
$query = new \MongoDB\Driver\Query($filter, $options);
$rows   = $m->executeQuery('messapp.cases', $query);
$ineff = array();
$district = array();
$laws = array();

foreach ($rows as $document) {
  $document = (array)$document;
  $ps = $document["PS"];
  $dis = $document["DISTRICT"];
  $status = $document["Status"];
  $act = $document["Act_Section"];

  if(isset($district[$dis])){
    $district[$dis]++;
  }
  else{
    $district[$dis]=1;
  }

  if($status=="Pending"){
    if(isset($ineff[$ps])){
      $ineff[$ps]++;
    }
    else{
      $ineff[$ps]=1;
    }
  }

  $temp = array();
  foreach ($act as $key) {

    if(!isset($temp[$key])){
      $temp[$key] = 1;
      if(isset($laws[$key])){
        $laws[$key]++;
      }
      else{
        $laws[$key] =1;
      }
    }
  
  }

}

arsort($laws);
arsort($district);
arsort($ineff);

?>

<!DOCTYPE html>
<html>
<head>
	<title>CS252 Lab</title>
</head>
<body>
<h1>Welcome to FIR Query Interface</h1>
<h3 id="first">Sort By Most Crime Reported per capita in districts</h3>
<div id="first_data">
  <?php
    echo "<ul>";
    foreach ($district as $key => $value) {
      echo "<li>".$key."</li>";
    }
    echo "</ul>";
  ?>
</div>
<h3 id="second">Sort By Most Inefficient Police Station</h3>
<div id="second_data">
  <?php
    echo "<ul>";
    foreach ($ineff as $key => $value) {
      echo "<li>".$key."</li>";
    }
    echo "</ul>";
  ?>
</div>
<h3 id="third">Sort By Most Applied Crime Laws</h3>
<div id="third_data">
  <?php
    echo "<ul>";
    foreach ($laws as $key => $value) {
      echo "<li>".$key."</li>";
    }
    echo "</ul>";
  ?>
</div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var a=0;
    var b=0;
    var c=0;
    $("#first_data").hide();
    $("#second_data").hide();
    $("#third_data").hide();

    $("#first").click(function(){
      a++;
      if(a%2==1)
        $("#first_data").show();
      else
        $("#first_data").hide();
    });

    $("#second").click(function(){
      b++;
      if(b%2==1)
        $("#second_data").show();
      else
        $("#second_data").hide();
    });
 

  $("#third").click(function(){
      c++;
      if(c%2==1)
        $("#third_data").show();
      else
        $("#third_data").hide();
    });
});
</script>

