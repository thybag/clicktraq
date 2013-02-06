<?php

include("../config/config.php");

$viewing_page = str_replace(array('"',"'"),'',strip_tags($_GET['show']));

// Connect to DB
try {
    $db = new PDO($config['dsn'], $config['user'], $config['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
	die("DB error.");
}

$q = $db->prepare('SELECT * FROM page_profiles WHERE webpage = ?');
$q->execute(array($viewing_page));

$clicks = array();
//Add returned products to array
while ($result = $q->fetch(PDO::FETCH_ASSOC)) {
	$clicks = array_merge(json_decode($result['clicks']),$clicks);
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

			#canvas {
				position: absolute;
				top:0px;
				left:0px;
			}
		</style>
		<script>
			var map = <?php echo json_encode($clicks); ?>
		</script>
	</head>
	<body>
		<div class="navbar navbar-inverse">
			 <div class="navbar-inner">
			 	<a class="brand" href="#">ClickTraq</a>
			 	<div class='pull-right'>
			 		<form method='get' action='' class='navbar-form'>
					 	<input type="text" class="search-query span4" name='show' placeholder="See page..." value="<?php echo $viewing_page; ?>">
					 	<input type='submit' class='btn btn-primary' value='View' />
					 </form>
				 </div>
			</div>
		</div>
		<div class='viewport' style='position:relative;'>
			<iframe id='window' src='<?php echo $_GET['show']?>' style='width:100%;border:0;min-height:600px;'></iframe>
			<canvas id='canvas'></canvas>
		</div>
		<script src='assets/heatmaps/webgl-heatmap.js' type='text/javascript'></script>
		<script>
			// Setup page
			ww = window.innerWidth
			wh = window.innerHeight
			document.getElementById("canvas").width = ww;
			document.getElementById("canvas").height = wh;
			document.getElementById("window").height = wh;

			// Generate heatmap
			try{
			    var heatmap = createWebGLHeatmap({"canvas": document.getElementById("canvas")});
			}
			catch(error)
			{
			    // handle the error
			}
			var max_weighting = 20;
			var impact = max_weighting/map.length;

			for(var i in map){
				heatmap.addPoint(map[i].x, map[i].y, 28, impact);
			}
			heatmap.update();
			heatmap.display();

		</script>
	</body>
</html>

