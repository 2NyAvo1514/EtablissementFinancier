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
  <h1>Insertion de Fond</h1>

  <label for="valeur">Valeur du fond</label>
  <input type="number" id="valeur" name="solde"/>

  <button onclick="createFond()">Ajouter</button>

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

    function createFond() {
      const valeur = document.getElementById("valeur").value;

    
      const data =  `&solde=${encodeURIComponent(valeur)}`;

      ajax("POST", "/fond", data, () => {
        alert("Fond ajouté !");
        document.querySelector("form")?.reset?.();
      });
    }

  </script>
</body>

</html>
