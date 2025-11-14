<?php
// ========================================
// Archivo: /src/controllers/AuthController.php
// ========================================
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private $usuarioModel;

    public function __construct($pdo)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->usuarioModel = new Usuario($pdo);
    }

    // ================================
    // PROCESAR REGISTRO
    // ================================
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Recoger datos
            $nombre = trim($_POST['nombre'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $password = $_POST['password'] ?? '';
            $telefono = trim($_POST['telefono'] ?? null);
            $area = trim($_POST['area'] ?? null);
            $sede = trim($_POST['sede'] ?? null);

            // Validación básica
            if (!$nombre || !$username || !$correo || !$password) {
                $_SESSION['error'] = "Los campos Nombre, Usuario, Correo y Contraseña son obligatorios.";
                header("Location: register.php");
                exit;
            }

            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "El correo no tiene un formato válido.";
                header("Location: register.php");
                exit;
            }

            try {
                // Verificar si existe username o correo
                $existe = $this->usuarioModel->existeUsernameOCorreo($username, $correo);

                if ($existe) {
                    if ($existe['username'] === $username) {
                        $_SESSION['error'] = "El nombre de usuario ya está en uso.";
                    } else {
                        $_SESSION['error'] = "El correo ya se encuentra registrado.";
                    }
                    header("Location: register.php");
                    exit;
                }

                // Encriptar contraseña
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                // Registrar en DB
                $this->usuarioModel->registrar(
                    $nombre,
                    $username,
                    $correo,
                    $password_hash,
                    $telefono,
                    $area,
                    $sede
                );

                // Mensaje de éxito
                header("Location: index.php?registro=exitoso");
                exit;
            } catch (PDOException $e) {
                $_SESSION['error'] = "Error al registrar. Intenta nuevamente.";
                header("Location: register.php");
                exit;
            }
        }
    }

    // ================================
    // PROCESAR LOGIN
    // ================================
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $login = trim($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$login || !$password) {
                $_SESSION['error'] = "Debes ingresar usuario/correo y contraseña.";
                header('Location: index.php');
                exit;
            }

            // Buscar usuario por username O correo
            $usuario = $this->usuarioModel->obtenerPorLogin($login);

            if (!$usuario) {
                $_SESSION['error'] = "El usuario no existe.";
                header('Location: index.php');
                exit;
            }

            if (!password_verify($password, $usuario['password_hash'])) {
                $_SESSION['error'] = "Contraseña incorrecta.";
                header('Location: index.php');
                exit;
            }

            // Iniciar sesión exitosa
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol_id'] = $usuario['rol_id'];

            header('Location: dashboard.php');
            exit;
        }
    }

    // ================================
    // LOGOUT
    // ================================
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
