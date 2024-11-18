<?php
// Conexión a la base de datos SQLite
$db = new SQLite3('pau_sam_db.db');

// Crear tabla si no existe
$db->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    email TEXT NOT NULL
)");

// Insertar datos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    if (!empty($nombre) && !empty($email)) {
        $stmt = $db->prepare('INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)');
        $stmt->bindValue(':nombre', $nombre, SQLITE3_TEXT);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->execute();
    }
}

// Obtener todos los registros de la base de datos
$resultado = $db->query('SELECT * FROM usuarios');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestión de Usuarios</title>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet"
	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
	crossorigin="anonymous">
</head>
<body class="bg-light">
	<div class="container my-5">
		<h1 class="text-center text-primary mb-4">Gestión de Usuarios</h1>

		<form method="post" action="" class="bg-white p-4 rounded shadow-sm">
			<div class="mb-3">
				<label for="nombre" class="form-label">Nombre:</label> <input
					type="text" id="nombre" name="nombre" class="form-control"
					placeholder="Escribe tu nombre">
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Correo Electrónico:</label> <input
					type="email" id="email" name="email" class="form-control"
					placeholder="Escribe tu correo">
			</div>
			<button type="submit" class="btn btn-primary w-100">Guardar</button>
		</form>

		<h2 class="text-secondary mt-5">Usuarios Registrados</h2>
		<table class="table table-striped table-bordered mt-3">
			<thead class="table-dark">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nombre</th>
					<th scope="col">Email</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)): ?>
				<tr>
					<td>
						<?= htmlspecialchars($fila['id']) ?>
					</td>
					<td>
						<?= htmlspecialchars($fila['nombre']) ?>
					</td>
					<td>
						<?= htmlspecialchars($fila['email']) ?>
					</td>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>

	<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-oobBmO6fXmc1q/jhAv8Wyxk6Qm5IO/9bwxpj9Z9E+LB/HnCOWgSRK8GOwjkU9AK3"
		crossorigin="anonymous"></script>
</body>
</html>
