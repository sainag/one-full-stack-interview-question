<?
$function=$_POST['function'];
switch($function){
  case "addToWorld":
    if(isset($_POST['country']) && isset($_POST['city'])){
	  $servername = "DBServer";
     $username = "username";
     $password = "password";
     $dbname="DBName";
	  $dbhandle  = mysql_connect($servername, $username, $password) or die("Unable to connect to MySQL");	
	  $conn = mysql_select_db($dbname,$dbhandle) or die("Could not select world");
	  $result=0;
	  if($conn){
	    $q="select * from `world`.`Country` where country='".$_POST['country']."'";
	    $result=mysql_query($q) or die("Can't execute query".$q);
		if(mysql_num_rows($result)>0){
		  while($row=mysql_fetch_array($result)){
		    $q2="insert into `world`.`City` (CountryID, City) values('".$row['id']."', '".$_POST['city']."');";
	        $result2=mysql_query($q2) or die("Can't execute query".$q2);
		  }
		}
		else{
		  $q="insert into `world`.`Country` (Country) values('".$_POST['country']."');";
	      $result=mysql_query($q) or die("Can't execute query ".$q);
		  $q="select * from `world`.`Country` order by id DESC LIMIT 1;";
	      $result=mysql_query($q) or die("Can't execute query ".$q);
		  if(mysql_num_rows($result)>0){
			while($row=mysql_fetch_array($result)){
			  $q2="insert into `world`.`City` (CountryID, City) values('".$row['id']."', '".$_POST['city']."');";
	          $result2=mysql_query($q2) or die("Can't execute query ".$q2);  
			}
		  }
		}
		$result=1;
	  }
	  echo $result;
	}
  break;
  case "getWorld":
    $servername = "DBServer";
    $username = "username";
    $password = "password";
    $dbname="DBName";
    $dbhandle  = mysql_connect($servername, $username, $password) or die("Unable to connect to MySQL");	
	$conn = mysql_select_db($dbname,$dbhandle) or die("Could not select world");
	$world=array();
	$result=array("result"=>$world);
	if($conn){
	  $q="select * from `world`.`Country` order by id DESC";
	  $result=mysql_query($q) or die("Can't execute query".$q);
	  if(mysql_num_rows($result)>0){
	    while($row=mysql_fetch_array($result)){
		  $q2="select * from `world`.`City` where CountryID='".$row['id']."' order by id DESC";
		  $result2=mysql_query($q2) or die("Can't execute query");
		  $cities=array();
		  if(mysql_num_rows($result2)>0){
			while($row2=mysql_fetch_array($result2)){
			  $city=array("CityID"=>$row2['id'],"City"=>$row2['City']);	
			  array_push($cities,$city);	
			}
		  }
		  $country=array("CountryID"=>$row['id'],"Country"=>$row['Country'],"Cities"=>$cities);
		  array_push($world,$country); 	
	    }
		$result=array("result"=>$world);
	  }
    }
	echo json_encode($result);
  break;
}

?>