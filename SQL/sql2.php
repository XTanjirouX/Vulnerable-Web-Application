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
	</form>
	</div>

<?php

if ($conn->connect_error) {
    die("Connection failed: " . htmlspecialchars($conn->connect_error));
}

// Comprobación al enviar el formulario
if (isset($_POST["submit"])) {
    // Validar entrada como un número entero
    if (isset($_POST['number']) && is_numeric($_POST['number'])) {
        $number = intval($_POST['number']); // Convertir a entero para mayor seguridad

        // Preparar la consulta con parámetros
        $stmt = $conn->prepare("SELECT bookname, authorname FROM books WHERE number = ?");
        if (!$stmt) {
            // Error en la preparación
            error_log("Error en la preparación de la consulta: " . $conn->error);
            die("Error al procesar la solicitud.");
        }

        // Enlazar parámetros y ejecutar la consulta
        $stmt->bind_param("i", $number); // "i" indica un parámetro entero
        $stmt->execute();

        // Obtener los resultados
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Procesar resultados
            while ($row = $result->fetch_assoc()) {
                echo "Book Name: " . htmlspecialchars($row["bookname"]) . "<br>";
                echo "Author Name: " . htmlspecialchars($row["authorname"]) . "<br>";
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
