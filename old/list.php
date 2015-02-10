<?php
$valueID = isset($_GET['id'])?$_GET['id']:"urassic_World";

$dbname = "wikidots";
$host = "82.80.210.144";  
$user = "wikidots";
$pass = "wagoiplrkyjdnvtxemcq"; 
$db = new PDO('mysql:dbname='.$dbname.';host='.$host, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

$statement = $db->prepare("select * from value");
$statement->execute();
$table = $statement->fetchAll(PDO::FETCH_ASSOC); // Use fetchAll() if you want all results, or just iterate over the statement, since it implements Iterator
//print_r($table);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Wikidots</title>
    </head>
    <body>
		<ul>
		<?php foreach ($table as $value): ?>
			<li>
				<a href="/?id=<?php echo $value["valueID"]; ?>"><?php echo $value["valueName"]; ?></a>			
			</li>
		<?php endforeach ?>
		<ul>
	</body>
	
	
</html>