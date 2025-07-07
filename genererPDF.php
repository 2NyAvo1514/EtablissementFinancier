<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Validation</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    input, button { margin: 5px; padding: 5px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>

  <h1>Liste des prets validé</h1>

  <table id="table-pret">
    <thead>
      <tr>
        <th>Nom du client</th>
        <th>Montant</th>
        <th>Description</th>
        <th>Date</th>
        <th></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <script>
    const apiBase = "http://localhost:80/ETU003130/t/EtablissementFinancier/ws";

    function ajax(method, url, data, callback) {
      const xhr = new XMLHttpRequest();
      xhr.open(method, apiBase + url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
          callback(JSON.parse(xhr.responseText));
        }
      };
      if (method.toUpperCase() === "GET") {
            xhr.send();
        } else {
            xhr.send(data);
        }
    //   xhr.send(data);
    }

    function chargerPretValide() {
      ajax("GET", "/listValide", null, (data) => {
        const tbody = document.querySelector("#table-pret tbody");
        tbody.innerHTML = "";
        data.forEach(e => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${e.nomClient}</td>
            <td>${e.montant}</td>
            <td>${e.descriptionPret}</td>
            <td>${e.datePret}</td>
            <td>
                <button onclick='genererPDF(${e.idPret})'>Generer PDF</button>
            </td>
          `;
          tbody.appendChild(tr);
        });
      });
    }

    function genererPDF(idPret) {
      window.open(apiBase + `/genererPDF/${idPret}`, '_blank');
    }
 

    chargerPretValide();
  </script>

</body>
</html>