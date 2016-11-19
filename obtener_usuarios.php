<?php

require 'usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $usuarioArr = Usuario::getUsers();

    if ($usuarioArr) {

        $datos["estado"] = 1;
        $datos["usuario"] = $usuarioArr;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$data = $_POST["data"];
	
	$value = setData($data);
}
?>


<html>
<head>
	<meta name=viewport content="width=device-width, initial-scale=1">
</head>
<body>
	<div>
		<p><h3>This is a test:</h3></p>
	</div>
	
	<div>
	<?php

		$conn = mysqli_connect('localhost', 'u278220770_sens', 'D33qsoG96z', 'u278220770_proy'); //The Blank string is the password

		$query = "SELECT data FROM Prueba"; //You don't need a ; like you do in SQL
		$result= mysqli_query($conn,$query);

		echo "<table>"; // start a table tag in the HTML

		while($row = mysqli_fetch_assoc($result)){   //Creates a loop to loop through results
		echo "<tr><td>" . $row['data'] . "</td></tr>" ;  //$row['index'] the index here is a field name
		}

		echo "</table>"; //Close the table in HTML
	?>
	</div>
</body>
</html>
