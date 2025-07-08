<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Gestion des Taux</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <div class="sidebar">
      <?php include 'navbar.html'; ?>
    </div>

    <main class="content">
      <h1>Insertion de nouveau Délai</h1>
      <hr>
      <br>
      <label for="dateTaux">Date de modification du delai</label>
      <br>
      <input type="date" id="dateTaux" required />
      <br>
      <label for="idTypeClient">Type de compte</label>
      <br>
      <select id="idTypeClient" required>
        <option value="">-- Sélectionnez --</option>
      </select>
      <br>
      <label for="idTypePret">Type de prêt</label>
      <br>
      <select id="idTypePret" required>
        <option value="">-- Sélectionnez --</option>
      </select>
      <br>
      <label for="valeur">Durée de délai</label>
      <br>
      <input type="number" id="valeur" step="0.01" required />
      <br>
      <br>
      <button class="ajouter" onclick="createTaux()">Ajouter</button>
      <hr>
      <h3>Délai actuelle</h3>
      <table id="table-taux">
        <thead>
          <tr>
            <th>Type Client</th>
            <th>Type Pret</th>
            <th>Duree en mois</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </main>


  </div>

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
        `&dateDelai=${encodeURIComponent(dateTaux)}` +
        `&duree=${encodeURIComponent(valeur)}`;

      ajax("POST", "/Delais", data, () => {
        alert("Delai ajouté !");
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

    function chargeLastDelai() {
      ajax("GET", "/lastDelais", null, (data) => {
        const tbody = document.querySelector("#table-taux tbody");
        tbody.innerHTML = "";

        data.forEach(e => {
          ajax("GET", `/typeClients/${e.idTypeClient}`, null, (typeClientData) => {
            const typeClientName = typeClientData.typeClient;

            ajax("GET", `/typePret/${e.idTypePret}`, null, (typePretData) => {
              const typePretName = typePretData.typePret;

              const tr = document.createElement("tr");
              tr.innerHTML = `
            <td>${typeClientName}</td>
            <td>${typePretName}</td>
            <td>${e.duree} </td>
          `;
              tbody.appendChild(tr);
            });
          });
        });
      });
    }


    chargeLastDelai();
    chargeTypeClient();
    chargeTypePret();
  </script>
</body>

</html>