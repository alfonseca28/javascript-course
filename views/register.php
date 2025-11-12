<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Quiniela MX</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .register-container {
            width: 400px;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #1565c0;
            margin-bottom: 1rem;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
        }

        button {
            width: 100%;
            background: #1565c0;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 0.5rem;
            cursor: pointer;
            margin-top: 1rem;
        }

        button:hover {
            background: #0d47a1;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Crear cuenta</h2>
        <form action="../actions/register_action.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="text" name="telefono" placeholder="Número de teléfono">
            <input type="text" name="area" placeholder="Área o departamento">
            <input type="text" name="sede" placeholder="Sede (por ejemplo, CDMX)">
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <div class="login-link">
            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>
</body>

</html>