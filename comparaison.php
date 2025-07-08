<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Comparaison des Simulations</title>
  <style>
    .simulations {
      display: flex;
      gap: 15px;
      margin-top: 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .simulation {
      flex: 1 1 220px;
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 12px 15px;
      background-color: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      font-size: 0.9em;
    }

    .simulation h3 {
      margin: 0 0 10px;
      font-size: 1.1em;
      color: #dc2626;
      text-align: center;
    }

    .simulation p {
      margin: 4px 0;
      color: #2d3748;
    }

    h1 {
      font-size: 1.5em;
      margin: 20px 0 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php include 'navbar.html'; ?>

    <div class="content">
      <h1>Comparaison des Simulations</h1>
      <div class="simulations" id="simulations-container"></div>
    </div>
  </div>

  <script>
      const apiBase ="http://localhost:81/tp-flightphp-crud-MVC/finalExamS4_ETU003130_ETU003158_ETU003160/ws";
    // const apiBase = "/ETU003160/t/finalExamS4_ETU003130_ETU003158_ETU003160/ws";

    function ajax(method, url, data, callback) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, apiBase + url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            callback(JSON.parse(xhr.responseText));
          } else {
            console.error("Erreur API :", xhr.responseText);
          }
        }
      };
      xhr.send(data);
    }

    function chargerAllSimulation() {
    ajax("GET", "/comparaison", null, (data) => {
        const container = document.getElementById("simulations-container");
        container.innerHTML = "";

        if (!Array.isArray(data)) {
        container.innerHTML = "<p>Aucune simulation à afficher.</p>";
        return;
        }

        data.slice(-2).forEach((e, index) => {
        const div = document.createElement("div");
        div.className = "simulation";
        div.innerHTML = `
            <h3>Simulation ${index + 1}</h3>
            <p><strong>Type Client :</strong> ${e.typeClient}</p>
            <p><strong>Type Prêt :</strong> ${e.typePret}</p>
            <p><strong>Montant :</strong> ${parseFloat(e.montant).toLocaleString("fr-FR")} Ar</p>
            <p><strong>Durée :</strong> ${e.nbrMois} mois</p>
            <form action="simulationtopret.php" method="get">
            <input type="hidden" name="idSimulation" value="${e.idSimulation || e.id}">
            <button type="submit" class="btn btn-outline">Faire un pret</button>
            </form>
        `;
        container.appendChild(div);
        });
    });
    }

    chargerAllSimulation();
  </script>

  
</body>
</html>
