<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Gestion des Taux</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, button, select { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>

<body>
  <h1>Insertion de Taux</h1>

  <label for="dateTaux">Date de modification du taux</label>
  <input type="date" id="dateTaux" required />

  <br />

  <label for="idTypeClient">Type de compte</label>
  <select id="idTypeClient" required>
    <option value="">-- Sélectionnez --</option>
  </select>

  <br />

  <label for="idTypePret">Type de prêt</label>
  <select id="idTypePret" required>
    <option value="">-- Sélectionnez --</option>
  </select>

  <br />

  <label for="valeur">Valeur du taux (%)</label>
  <input type="number" id="valeur" step="0.01" required />

  <button onclick="createTaux()">Ajouter</button>

  <script>
    const apiBase =
      "http://localhost:81/tp-flightphp-crud-MVC/finalExamS4_ETU003130_ETU003158_ETU003160/ws";

    function ajax(method, url, data, cb) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, apiBase + url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            cb && cb(JSON.parse(xhr.responseText));
          } else {
            alert("Erreur " + xhr.status + " : " + xhr.responseText);
          }
        }
      };
      xhr.send(data);
    }

    function createTaux() {
      const idTypeClient = document.getElementById("idTypeClient").value;
      const idTypePret = document.getElementById("idTypePret").value;
      const dateTaux = document.getElementById("dateTaux").value;
      const valeur = document.getElementById("valeur").value;

      if (!idTypeClient || !idTypePret || !dateTaux || !valeur) {
        alert("Tous les champs sont obligatoires.");
        return;
      }

      const data =
        `idTypeClient=${encodeURIComponent(idTypeClient)}` +
        `&idTypePret=${encodeURIComponent(idTypePret)}` +
        `&dateTaux=${encodeURIComponent(dateTaux)}` +
        `&valeur=${encodeURIComponent(valeur)}`;

      ajax("POST", "/taux", data, () => {
        alert("Taux ajouté !");
        document.querySelector("form")?.reset?.();
      });
    }

    function chargeTypeClient() {
      ajax("GET", "/typeClients", null, (data) => {
        const select = document.getElementById("idTypeClient");
        select.innerHTML = '<option value="">-- Sélectionnez --</option>';
        data.forEach((item) => {
          const opt = document.createElement("option");
          opt.value = item.id;
          opt.textContent = item.typeClient;
          select.appendChild(opt);
        });
      });
    }


    function chargeTypePret() {
      ajax("GET", "/typePret", null, (data) => {
        const select = document.getElementById("idTypePret");
        select.innerHTML = '<option value="">-- Sélectionnez --</option>';
        data.forEach((item) => {
          const opt = document.createElement("option");
          opt.value = item.id;
          opt.textContent = item.typePret;
          select.appendChild(opt);
        });
      });
    }
    chargeTypeClient();
    chargeTypePret();
  </script>
</body>

</html>
