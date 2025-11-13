<?php
// ========================================
// Archivo: /src/controllers/AuthController.php
// ========================================
require_once __DIR__ . '/../models/Usuario.php';
session_start();

class AuthController
{
    private $usuarioModel;

    public function __construct($pdo)
    {
        $this->usuarioModel = new Usuario($pdo);
    }

    // Procesar registro
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $username = trim($_POST['username']);
            $correo = trim($_POST['correo']);
            $password = $_POST['password'];

            if (!$nombre || !$username || !$correo || !$password) {
                $error = "Todos los campos son obligatorios.";
                include __DIR__ . '/../../public/register.php';
                exit;
            }

            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            try {
                $this->usuarioModel->registrar($nombre, $username, $correo, $password_hash);
                header('Location: index.php?registro=exitoso');
                exit;
            } catch (PDOException $e) {
                $error = "Error: El usuario o correo ya existe.";
                include __DIR__ . '/../../public/register.php';
                exit;
            }
        }
    }

    // Procesar login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = trim($_POST['login']);
            $password = $_POST['password'];

            $usuario = $this->usuarioModel->obtenerPorLogin($login);

            if ($usuario && password_verify($password, $usuario['password_hash'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['rol_id'] = $usuario['rol_id'];
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
                include __DIR__ . '/../../public/index.php';
                exit;
            }
        }
    }

    // Cerrar sesión
    public function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
