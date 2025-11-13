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
            // Recoger y sanitizar
            $nombre = trim($_POST['nombre'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $correo = trim($_POST['correo'] ?? '');
            $password = $_POST['password'] ?? '';
            $telefono = trim($_POST['telefono'] ?? null);
            $area = trim($_POST['area'] ?? null);
            $sede = trim($_POST['sede'] ?? null);

            // Validaciones básicas
            if (!$nombre || !$username || !$correo || !$password) {
                $error = "Los campos Nombre, Usuario, Correo y Contraseña son obligatorios.";
                include __DIR__ . '/../../public/register.php';
                exit;
            }

            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                $error = "El correo no tiene un formato válido.";
                include __DIR__ . '/../../public/register.php';
                exit;
            }

            // Revisar si existe username o correo
            try {
                $existe = $this->usuarioModel->existeUsernameOCorreo($username, $correo);
                if ($existe) {
                    // Determinar si es username o correo
                    if ($existe['username'] === $username) {
                        $error = "El nombre de usuario ya existe. Elige otro.";
                    } else {
                        $error = "El correo ya está registrado. Usa otro correo o inicia sesión.";
                    }
                    include __DIR__ . '/../../public/register.php';
                    exit;
                }

                // Hashear contraseña
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                // Registrar usuario
                $this->usuarioModel->registrar($nombre, $username, $correo, $password_hash, $telefono, $area, $sede);

                // Redirigir al login con mensaje
                header('Location: index.php?registro=exitoso');
                exit;
            } catch (PDOException $e) {
                // Mensaje genérico para no filtrar detalles DB
                $error = "Error al registrar el usuario. Intenta de nuevo más tarde.";
                include __DIR__ . '/../../public/register.php';
                exit;
            }
        }
    }

    // Procesar login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = trim($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';

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
