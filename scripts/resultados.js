const apiKey = "8c239accedc8c75b8724f313a1a21b27"; // Tu API Key
const container = document.getElementById("partidos-container");

// ID de la Liga MX según API-Football
const ligaMX_ID = 262;
const temporada = 2023; // temporada por defecto (plan gratuito suele dar acceso hasta 2023)

async function obtenerResultados() {
    try {
        // Pedir partidos en un rango: últimos 10 días (evita el parámetro `last`)
        const dias = 10;
        const hoy = new Date();
        let to = hoy.toISOString().slice(0, 10); // YYYY-MM-DD
        const fromDate = new Date();
        fromDate.setDate(hoy.getDate() - dias);
        let from = fromDate.toISOString().slice(0, 10);

        // Ajustar temporada/fechas si las fechas calculadas caen fuera de temporadas permitidas
        const allowedSeasons = [2021, 2022, 2023];
        const fromYear = Number(from.slice(0, 4));
        let seasonToUse = temporada;

        if (allowedSeasons.includes(fromYear)) {
            seasonToUse = fromYear;
        } else {
            // Si la fecha cae en 2025 (u otro año no permitido), переключар las fechas al año de `temporada`
            const monthDayTo = to.slice(5);   // MM-DD
            const monthDayFrom = from.slice(5);
            to = `${temporada}-${monthDayTo}`;
            from = `${temporada}-${monthDayFrom}`;
            seasonToUse = temporada;
        }

        const url = `https://v3.football.api-sports.io/fixtures?league=${ligaMX_ID}&season=${seasonToUse}&from=${from}&to=${to}&status=FT`;
        console.log("URL fetch:", url);
        const respuesta = await fetch(url, {
            method: "GET",
            headers: {
                "x-apisports-key": apiKey,
                "Accept": "application/json",
            },
        });

        const data = await respuesta.json();
        console.log(data); // Puedes ver la estructura en la consola del navegador

        // Mostrar mensaje de la API si hay restricciones de plan o errores específicos
        if (data.errors && Object.keys(data.errors).length) {
            const mensaje = data.errors.plan || JSON.stringify(data.errors);
            container.innerHTML = `<p>Error de la API: ${mensaje}</p>`;
            return;
        }

        if (!data.response || data.response.length === 0) {
            container.innerHTML = "<p>No se encontraron resultados recientes.</p>";
            return;
        }

        container.innerHTML = ""; // Limpiar contenido

        data.response.forEach((partido) => {
            const home = partido.teams.home;
            const away = partido.teams.away;
            const goals = partido.goals;

            const matchDiv = document.createElement("div");
            matchDiv.classList.add("partido");

            matchDiv.innerHTML = `
        <div class="team">
          <img src="${home.logo}" alt="${home.name}" class="logo">
          <span>${home.name}</span>
        </div>
        <div class="score">
          <span>${goals.home ?? "-"} - ${goals.away ?? "-"}</span>
        </div>
        <div class="team">
          <img src="${away.logo}" alt="${away.name}" class="logo">
          <span>${away.name}</span>
        </div>
      `;

            container.appendChild(matchDiv);
        });
    } catch (error) {
        console.error("Error al obtener resultados:", error);
        container.innerHTML = "<p>Error al cargar los resultados.</p>";
    }
}

obtenerResultados();
