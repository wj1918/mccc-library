<?php
header('Content-Type: application/json; charset=utf-8');

function enc($str){
//  not working
//  http://stackoverflow.com/questions/21845889/php-json-encoding-with-traditional-simplified-chinese-character
//	return urldecode(json_encode(urlencode($str)));

	return json_encode($str);
}

$booktypes = array (
    "chinese"  => "SELECT * FROM `LIB_CB-DB`",
    "adult" =>  "SELECT * FROM `LIB_EB-DB`",
    "children"   =>  "SELECT * FROM `LIB_KEB-DB`"
    );
    
/*
* Code to query database and return
* results as JSON.
*/
 
// Specify your sqlite database name and path //
$dir = 'sqlite:../data/mccc-library.db';
 
// Instantiate PDO connection object and failure msg //
$dbh = new PDO($dir) or die("cannot open database");
 
$type=$_GET["type"];
  
// Define your SQL statement //
$query = $booktypes[$type];
 
echo "[";
$first = True;
foreach ($dbh->query($query) as $row) {
  if(!$first){
  	echo ",";
  }
  echo '{"title":' . enc($row['Title']) ;
  echo ',"classNumber":' . enc($row['ClassNumber']);
  echo ',"author":' . ''. enc($row['Author']) .'}';
  $first=false;

}
echo "]";

?>