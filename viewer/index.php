<?php

//http://codeflow.org/entries/2013/feb/04/high-performance-js-heatmaps/
$request_body = file_get_contents('php://input');

$config = array(
	'dsn' 	=> 'mysql:dbname=clicktraq;host=localhost',
	'user' 	=> 'root',
	'password' 	=> ''
);

// Connect to DB
try {
    $db = new PDO($config['dsn'], $config['user'], $config['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
	die("DB error.");
}

$q = $db->prepare('SELECT * FROM page_profiles WHERE webpage = ?');
$q->execute(array($_GET['show']));

//Add returned products to array
while ($result = $q->fetch(PDO::FETCH_ASSOC)) {
	//$data[] = $result['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
	<head> 
		<title>Click traq</title> 
		<style type="text/css"> 
			 @import url("//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.2.2/css/bootstrap.min.css");
			 
		</style>
		<style type="text/css"> 
			.navbar{margin-bottom:0px;border-radius:0;}
			.navbar-inner {border-radius: 0;}
			.navbar-inner input {margin-top:5px;}
		</style>
	</head>
	<body>
		<div class="navbar navbar-inverse">
			 <div class="navbar-inner">
			 	<a class="brand" href="#">ClickTraq</a>
			 	<div class='pull-right'>
				 	<input type="text" class="search-query" placeholder="See page...">
				 </div>
			</div>
		</div>
		<div class='viewport'>
			<iframe src='<?php echo $_GET['show']?>' style='width:100%;border:0;min-height:600px;'></iframe>
		</div>
	</body>
</html>

