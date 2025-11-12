💡 Lógica general de flujo
🔹 1. Registro

El usuario llena register.php → se envía a actions/register_action.php
→ se guarda en la tabla usuarios (con hash o texto plano según config)
→ se inicia sesión automáticamente o se redirige a login.

🔹 2. Login

Formulario en login.php → actions/login_action.php
→ verifica correo/contraseña → crea $\_SESSION['usuario_id'] y $\_SESSION['rol']
→ redirige a dashboard.php.

🔹 3. Dashboard

Muestra los últimos partidos (SELECT ... FROM partidos JOIN equipos)

Muestra tus apuestas (SELECT ... FROM apuestas WHERE usuario_id = ?)

Acceso rápido a tu perfil, tus apuestas, o salir.

🔹 4. Apuestas

apuestas.php muestra partidos “pendientes” (estado = 'pendiente')

Usuario selecciona resultado y monto → apostar_action.php lo guarda.

🔹 5. Resultados

resultados.php muestra todos los partidos “finalizados”
junto con si el usuario acertó o no.

🔹 6. Perfil

Datos del usuario, fecha de registro, cantidad de apuestas hechas, etc.

🔹 7. (Opcional) Admin

Si el rol_id = 1, puede entrar a /views/admin/
para:

Agregar equipos

Registrar resultados

Crear/eliminar partidos
