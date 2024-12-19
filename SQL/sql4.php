<!DOCTYPE html>
<html>
<head>
	<title>SQL Injection</title>
	<link rel="shortcut icon" href="../Resources/hmbct.png" />
</head>
<body>

	<div style="background-color:#c9c9c9;padding:15px;">
      <button type="button" name="homeButton" onclick="location.href='../homepage.html';">Home Page</button>
      <button type="button" name="mainButton" onclick="location.href='sqlmainpage.html';">Main Page</button>
	</div>

	<div align="center">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" >
		<p>Give me book's number and I give you book's name in my library.</p>
		Book's number : <input type="text" name="number">
		<input type="submit" name="submit" value="Submit">
		<!--<p>Im learning something, I think?
		    I will sanitize query this time!!
		    //I'm the best web developer.
		     //number is too dangerous. I have to do something.</p>
		-->
	</form>
	</div>

<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db = "1ccb8097d0e9ce9f154608be60224c7c";

	// Create connection
	$conn = new mysqli($servername, $username, $password,$db);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	//echo "Connected successfully";
if (isset($_POST["submit"])) {
    // Validar y sanitizar la entrada
    if (isset($_POST['number']) && is_numeric($_POST['number'])) {
        $number = intval($_POST['number']); // Convertir a entero para mayor seguridad

        // Usar consultas preparadas para evitar inyección SQL
        $stmt = $conn->prepare("SELECT bookname, authorname FROM books WHERE number = ?");
        if (!$stmt) {
            // Error en la preparación de la consulta
            error_log("Error en la preparación de la consulta: " . $conn->error);
            die("Ocurrió un error al procesar la solicitud.");
        }

        // Enlazar parámetros y ejecutar
        $stmt->bind_param("i", $number); // "i" para enteros
        $stmt->execute();

        // Obtener resultados
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Mostrar los resultados
            while ($row = $result->fetch_assoc()) {
                echo "Nombre del libro: " . htmlspecialchars($row["bookname"]) . "<br>";
                echo "Nombre del autor: " . htmlspecialchars($row["authorname"]) . "<br>";
            }
        } else {
            echo "No se encontraron resultados.";
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Número no válido. Por favor, introduzca un valor numérico.";
    }
}

		while ($row = mysqli_fetch_assoc($result)) {
			echo "<hr>";
		    echo $row['bookname']." ----> ".$row['authorname'];    
		}

		if(mysqli_num_rows($result) <= 0)
			echo "0 result";

	}
?> 

</body>
</html>
