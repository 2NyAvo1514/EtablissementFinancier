<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Faire un prêt</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <?php include 'navbar.html'; ?>

    <div class="content">
      <h1>Faire un prêt</h1>
      <div class="simulations" id="pret"></div>
    </div>
  </div>

  <script>
          const apiBase ="http://localhost:81/tp-flightphp-crud-MVC/finalExamS4_ETU003130_ETU003158_ETU003160/ws";
    // const apiBase = "/ETU003160/t/finalExamS4_ETU003130_ETU003158_ETU003160/ws";

    function getIdFromURL() {
      const params = new URLSearchParams(window.location.search);
      return params.get("idSimulation");
    }

    function ajax(method, url, data, callback) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, apiBase + url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            callback(JSON.parse(xhr.responseText));
          } else {
            console.error("Erreur API :", xhr.status, xhr.responseText);
          }
        }
      };
      xhr.send(data);
    }

    function chargerFormulaire() {
      const id = getIdFromURL();
      if (!id) {
        document.getElementById("pret").innerHTML = "<p>ID de simulation non fourni.</p>";
        return;
      }

      ajax("GET", `/simulations/${id}`, null, (data) => {
        const container = document.getElementById("pret");
        if (!data) {
          container.innerHTML = "<p>Simulation non trouvée.</p>";
          return;
        }

        // On injecte un formulaire dont les name= correspondent à ton controller
        container.innerHTML = `
          <h2>Simulation #${data.id}</h2>
          <p><strong>Type Client :</strong> ${data.idTypeClient}</p>
          <p><strong>Type Prêt :</strong> ${data.idTypePret}</p>
          <p><strong>Montant :</strong> ${parseFloat(data.montant).toLocaleString("fr-FR")} Ar</p>
          <p><strong>Durée :</strong> ${data.nbrMois} mois</p>

          <h2>Informations du client</h2>
          <form onsubmit="envoyerPret(event, ${data.id})">
            <label>Nom :</label><br/>
            <input type="text" name="nom" required /><br/><br/>

            <label>Numéro Identification :</label><br/>
            <input type="text" name="numId" required /><br/><br/>

            <label>Date du prêt :</label><br/>
            <input type="date" name="datePret" required /><br/><br/>

            <label>Description :</label><br/>
            <textarea name="descri" required></textarea><br/><br/>

            <!-- Champs cachés attendus par executePret() -->
            <input type="hidden" name="montant"  value="${data.montant}" />
            <input type="hidden" name="duree"    value="${data.nbrMois}" />
            <input type="hidden" name="typePret" value="${data.idTypePret}" />

            <button type="submit">Faire le prêt</button>
          </form>
        `;
      });
    }

    function envoyerPret(event, idSimulation) {
      event.preventDefault();
      const form = event.target;

      const nom       = encodeURIComponent(form.nom.value.trim());
      const numId     = encodeURIComponent(form.numId.value.trim());
      const datePret  = encodeURIComponent(form.datePret.value);
      const descri    = encodeURIComponent(form.descri.value.trim());
      const montant   = encodeURIComponent(form.montant.value);
      const duree     = encodeURIComponent(form.duree.value);
      const typePret  = encodeURIComponent(form.typePret.value);

      const payload = 
        `nom=${nom}` +
        `&numId=${numId}` +
        `&datePret=${datePret}` +
        `&descri=${descri}` +
        `&montant=${montant}` +
        `&duree=${duree}` +
        `&typePret=${typePret}` +
        `&idSimulation=${encodeURIComponent(idSimulation)}`;

      ajax("POST", "/pret", payload, (response) => {
        alert("Prêt enregistré !");
        window.location.href = "comparaison.php";
      });
    }

    // Lancement
    chargerFormulaire();
  </script>
</body>
</html>

