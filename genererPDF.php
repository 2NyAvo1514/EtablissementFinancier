<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Validation</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <div class="sidebar"><?php include 'navbar.html'; ?></div>
    <main class="content">
      <h1>Liste des prets validé</h1>
    <hr>
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
    </main>


  </div>

  <script>
    const apiBase = "http://localhost:81/tp-flightphp-crud-MVC/finalExamS4_ETU003130_ETU003158_ETU003160/ws";
    // const apiBase = "/ETU003160/t/finalExamS4_ETU003130_ETU003158_ETU003160/ws";


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
                <button class="delete" onclick='genererPDF(${e.idPret})'>Generer PDF</button>
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