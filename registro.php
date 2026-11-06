<?php
session_start();
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $usuario = trim($_POST["usuario"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmar = $_POST["confirmar"] ?? "";

    // Validaciones
    if (empty($nombre) || empty($usuario) || empty($password) || empty($confirmar)) {
        $mensaje = "Todos los campos son obligatorios.";
    } elseif (strlen($password) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($password !== $confirmar) {
        $mensaje = "Las contraseñas no coinciden."; 
    } else {
        // Crear el hash 
        $hash = password_hash($password, PASSWORD_DEFAULT);


        if (!isset($_SESSION["usuarios"])) {
            $_SESSION["usuarios"] = [];
        }

        $_SESSION["usuarios"][$usuario] = [
            "nombre" => $nombre,
            "hash" => $hash
        ];

        $mensaje = "Usuario registrado correctamente. Hash generado: $hash";
    }
}
?>

<h2>Registro de usuarios</h2>
<p style="color:blue"><?php echo $mensaje; ?></p>

<form method="POST">
    Nombre: <input type="text" name="nombre"><br><br>
    Nombre de usuario: <input type="text" name="usuario"><br><br>
    Contraseña: <input type="password" name="password"><br><br>
    Confirmar contraseña: <input type="password" name="confirmar"><br><br>
    <input type="submit" value="Registrar">
</form>
<a href="login.php">Ir a Iniciar Sesión</a>