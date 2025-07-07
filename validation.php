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

  <h1>Liste des prets non valide</h1>

  <table id="table-pret">
    <thead>
      <tr>
        <th>Nom du client</th>
        <th>Montant</th>
        <th>Description</th>
        <th>Date</th>
        <th>Date Validation</th>
        <th>Action</th>
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
      
      xhr.send(data);
    }

    function chargerPretNonValide() {
      ajax("GET", "/listPret", null, (data) => {
        const tbody = document.querySelector("#table-pret tbody");
        tbody.innerHTML = "";
        data.forEach(e => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${e.nomClient}</td>
            <td>${e.montant}</td>
            <td>${e.descriptionPret}</td>
            <td>${e.datePret}</td>
            <td><input type="date" name="dateValidation"></td>
            <td>
                <button onclick='validerpret(${e.idPret},this)'>Valider</button>
                <button onclick='rejetterpret(${e.idPret},this)'>Rejetter</button>
            </td>
          `;
          tbody.appendChild(tr);
        });
      });
    }

    function validerpret(idPret, btn) {
        const tr = btn.closest("tr"); 
        const dateValidation = tr.querySelector('input[name="dateValidation"]').value;

        if (!dateValidation) {
            alert("Veuillez choisir une date de validation.");
            return;
        }
        const dateEncoded = encodeURIComponent(dateValidation);
        ajax("GET", `/validation/${idPret}/${dateEncoded}`, null, (response) => {
            console.log("Validation réussie :", response);
            alert("Le prêt a été validé !");
            chargerPretNonValide(); 
        });
    }
            

    function rejetterpret(idPret, btn) {
        const tr = btn.closest("tr"); 
        const dateValidation = tr.querySelector('input[name="dateValidation"]').value;

        if (!dateValidation) {
            alert("Veuillez choisir une date de validation.");
            return;
        }
        const dateEncoded = encodeURIComponent(dateValidation);
        ajax("GET", `/rejet/${idPret}/${dateEncoded}`, null, (response) => {
            console.log("Rejet réussie :", response);
            alert("Le prêt a été rejeté !");
            chargerPretNonValide(); 
        });
    }    

    chargerPretNonValide();
  </script>

</body>
</html>