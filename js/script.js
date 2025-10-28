// --- Registro ---
const registerForm = document.getElementById("registerForm");
if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const nombre = document.getElementById("nombre").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmar = document.getElementById("confirmar").value;

        if (password !== confirmar) {
            alert("⚠️ Las contraseñas no coinciden.");
            return;
        }

        localStorage.setItem("user", JSON.stringify({ nombre, email, password }));
        alert("✅ Registro exitoso. Ahora inicia sesión.");
        window.location.href = "index.html";
    });
}

// --- Login ---
const loginForm = document.getElementById("loginForm");
if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const email = document.getElementById("loginEmail").value.trim();
        const password = document.getElementById("loginPassword").value;

        const user = JSON.parse(localStorage.getItem("user"));

        if (!user) {
            alert("⚠️ No hay ningún usuario registrado.");
            return;
        }

        if (user.email === email && user.password === password) {
            localStorage.setItem("loggedIn", "true");
            window.location.href = "dashboard.html";
        } else {
            alert("❌ Correo o contraseña incorrectos.");
        }
    });
}

// --- Protección del dashboard ---
if (window.location.pathname.includes("dashboard.html")) {
    const loggedIn = localStorage.getItem("loggedIn");
    if (loggedIn !== "true") {
        window.location.href = "index.html";
    }
}

// --- Cerrar sesión ---
const logoutBtn = document.getElementById("logoutBtn");
if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
        localStorage.removeItem("loggedIn");
        window.location.href = "index.html";
    });
}
