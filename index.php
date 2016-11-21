<html>
<head>
	<meta name=viewport content="width=device-width, initial-scale=1">
	<!-- Bootstrap core CSS -->
    <link href="../dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../dist/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- This stylesheet contains specific styles for displaying the map
         on this page. Replace it with your own styles as described in the
         documentation:
         https://developers.google.com/maps/documentation/javascript/tutorial -->
    <link rel="stylesheet" type="text/css" href="style.css?v=<?=time();?>">
	<link rel="stylesheet" type="text/css" href="arrow_menu.css?v=<?=time();?>">
	<link rel="stylesheet" type="text/css" href="menu_trans.css?v=<?=time();?>">
	<link rel="stylesheet" type="text/css" href="button_show-log.css?v=<?=time();?>">
	<link href="https://fonts.googleapis.com/css?family=Michroma" rel="stylesheet">
	<script
          src="https://code.jquery.com/jquery-2.2.4.min.js"
          integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
          crossorigin="anonymous"></script>
	<script src="mapScript.js?v=?v=<?=time();?>"></script>
	<script src="velocity.min.js?v=?v=<?=time();?>"></script>
	<script src="velocity.ui.js?v=?v=<?=time();?>"></script>  
	<title> The Drone Project </title>
</head>
<body background="b1.png">
	<div id="wrapper" class="toggled">
	<!------------------------------------------------------------------>
	<div class="overlay-navigation">
		<nav role="navigation">
			<ul>
				<li><a href="index.php" data-content="The beginning">Inicio</a></li>
				<li><a href="about_us.php" data-content="Curious?">About Us</a></li>
				<li><a href="graphs.php" data-content="I got game">Monitorin'</a></li>
				<li><a href="https://weathermonitorblog.wordpress.com/" data-content="Only the finest">Blog</a></li>
			
			</ul>
		</nav>
	</div>
	
	<!------------------------------------------------------------------>
	</div>
	<!-- <a href="#menu-toggle" class="btn btn-default pull-right" id="menu-toggle">Toggle Menu</a> -->
	<?php
		include 'usuarios.php';
		$pdo = new PDO(
                'mysql:dbname=' . DATABASE .
                ';host=' . HOSTNAME .
                ';port:63343;',
                USERNAME,
                PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$latitude = $_POST["lat"];
			$longitude = $_POST["lng"];
		
			$ax = $_POST["x"];
			$ay = $_POST["y"];
			$az = $_POST["Z"];
			
			$temperature = $_POST["temp"];
			$humidity = $_POST["hum"];
			$heatindex = $_POST["hi"];
			
			$uv = $_POST["uv"];
			
			$pressure = $_POST["pre"];
			$altitude = $_POST["alt"]; 
			
			$message = $_POST["msg"];
			
			$datelog = $_POST["datelog"];
		
			// Test GPS
			$consulta = "Insert into CoordenadasPrueba (Latitud,Longitud) Values(?,?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($latitude,$longitude));
			
			$consulta = "Insert into CoordenadasPrueba (date_log) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($datelog));
			
			//-- Altitud
			$consulta = "Insert into Altitude (Altura) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($altitude));
			
			//-- Humedad
			$consulta = "Insert into Humedad (Humidity) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($humidity));
			
			//-- Presion
			$consulta = "Insert into Pressure (Presion) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($pressure));
			
			//-- Temperatura
			$consulta = "Insert into Temperatura (Grados) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($temperature));
			
			// --Coordenadas
			$consulta = "Insert into Coordenadas (Latitude,Longitude) Values(?,?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($latitude,$longitude));
			
			// --Acelerometro
			$consulta = "Insert into Acelerometro (Xaxis,Yaxis,Zaxis) Values(?,?,?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($ax,$ay,$az));
			
			// --Indice de calor
			$consulta = "Insert into IndiceDeCalor (IndiceCalor) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($heatindex));
			
			// --Ultravioleta
			$consulta = "Insert into Ultravioleta (UV) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($uv)); 
			
			//-- Message
			$consulta = "Insert into Message (Mensaje) Values(?)";
			$cmd = $pdo->prepare($consulta);
			$cmd->execute(array($msg));
			
			
			print "<div>" . "Dato guardado" . "</div>"; //$_POST["data"]
		}
		// Tabla de cooredenadas
		$consulta = "SELECT Latitud,Longitud FROM CoordenadasPrueba"; //You don't need a ; like you do in SQL
		
		print "<div style=\"display: none;\">";
		print "<table>";
		$i = 0;
		
		foreach ($pdo->query($consulta) as $row) {
			print "<tr> <td id=\"lat" . $i ."\" >" . $row['Latitud'] . "</td> <td id=\"lng". $i . "\">" . $row['Longitud'] . "</td> </tr>";
			$i = $i+1;
		}
		
		print "</table>";
		print "</div>"; 
	
		// Tabla de temperaturas 
		$consulta = "SELECT Grados FROM Temperatura";
		
		print "<div style=\"display: none;\">";
		print "<table>";
		$i = 0;
		
		foreach ($pdo->query($consulta) as $row) {
			print "<tr> <td id=\"temp" . $i ."\" >" . $row['Grados'] . "</td></tr>";
			$i = $i+1;
		}
		
		print "</table>";
		print "</div>"; 
		
		// Tabla de mensajes
		$consulta = "SELECT Mensaje FROM Message";
		
		print "<div style=\"display: none;\">";
		print "<table>";
		$i = 0;
		
		foreach ($pdo->query($consulta) as $row) {
			print "<tr> <td id=\"msg" . $i ."\" >" . $row['Mensaje'] . "</td></tr>";
			$i = $i+1;
		}
		
		print "</table>";
		print "</div>"; 
		
	?>
		
	</div>
	<div class="col_bar" id="arrow_bar" async defer>
		<div class="con_bar">
			<div class="bar arrow-top-r"></div>
			<div class="bar arrow-middle-r"></div>
			<div class="bar arrow-bottom-r"></div>
		</div>
	</div>
	
	<div id="showlog">
		<button>Show logs</button>
	</div>
	
	<div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJTmwQKHM4yruuby3_bCmo4fJ4RDAHB1c&callback=initMap"
    async defer></script>
	<!-- Menu Toggle Script -->
    <!-- <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>-->
</body>
</html>
