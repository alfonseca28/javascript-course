quiniela/
│
├── config/
│   └── db.php                 # Conexión a la base de datos (MySQL)
│
├── includes/
│   ├── header.php             # Encabezado (HTML, menús, etc.)
│   ├── footer.php             # Pie de página
│   ├── navbar.php             # Barra de navegación (dashboard)
│   └── auth.php               # Verifica sesión de usuario
│
├── public/
│   ├── css/
│   │   └── styles.css         # Estilos generales
│   ├── js/
│   │   └── main.js            # Lógica del frontend
│   └── img/
│       └── logos/             # Logos de equipos, favicon, etc.
│
├── views/
│   ├── login.php              # Página de login
│   ├── register.php           # Página de registro
│   ├── dashboard.php          # Panel principal
│   ├── perfil.php             # Perfil del usuario
│   ├── apuestas.php           # Realizar apuestas
│   ├── resultados.php         # Ver resultados
│   └── admin/                 # (opcional) sección de administración
│       ├── admin_equipos.php
│       ├── admin_partidos.php
│       └── admin_resultados.php
│
├── actions/
│   ├── login_action.php       # Procesa inicio de sesión
│   ├── register_action.php    # Procesa registro de usuario
│   ├── logout.php             # Cierra sesión
│   ├── apostar_action.php     # Registra una apuesta
│   └── admin_action.php       # Registra resultados o gestiona equipos
│
├── index.php                  # Redirige a login o dashboard si hay sesión
└── README.md
