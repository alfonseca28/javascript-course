/quiniela/
│
├── /config/
│   ├── db.php               ← conexión a la base de datos
│   └── config.php           ← constantes generales (nombre del sitio, etc)
│
├── /public/
│   ├── index.php            ← página principal / login
│   ├── register.php         ← registro
│   ├── dashboard.php        ← página principal después de login
│   ├── logout.php           ← cerrar sesión
│
├── /assets/
│   ├── /css/
│   │   └── style.css
│   ├── /js/
│   │   └── main.js
│   └── /images/
│       └── logos/
│
├── /src/
│   ├── /models/
│   ├── /controllers/
│   └── /views/
│
└── .htaccess (opcional)



/quiniela/
│
├── /config/
│   ├── db.php
│   └── config.php
│
├── /public/
│   ├── index.php          ← login
│   ├── register.php       ← registro
│   ├── dashboard.php      ← después de login
│   ├── logout.php         ← cerrar sesión
│
├── /src/
│   ├── /controllers/
│   │   ├── AuthController.php
│   └── /models/
│       ├── Usuario.php
│
├── /assets/
│   ├── /css/
│   │   └── style.css
│   └── /js/
│       └── main.js

