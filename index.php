<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php include 'navbar.html'; ?>

        <main class="content">
            <h1>Insertion de Remboursement</h1>
<hr>
            <label for="montant">Montant</label>
            <br>
            <input type="number" id="montant" name="montant" required><br>
            <br>
            <label for="dateRemboursement">Date de remboursement</label>
            <br>
            <input type="date" name="dateRemboursement" id="dateRemboursement">
            <br>
            <label for="numeroIdentification">Numéro d'identification (CIN ou NIF)</label>
            <br>
            <input type="text" id="numeroIdentification" name="numeroIdentification" required><br>
            <br>
            <button class="ajouter" onclick="createRemboursement()">Ajouter</button>
        </main>
    </div>

    <script>
        const apiBase = "http://localhost:81/tp-flightphp-crud-MVC/finalExamS4_ETU003130_ETU003158_ETU003160/ws";

        function ajax(method, url, data, callback) {
            const xhr = new XMLHttpRequest();
            xhr.open(method, apiBase + url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        callback(JSON.parse(xhr.responseText));
                    } else {
                        alert("Erreur " + xhr.status + " : " + xhr.responseText);
                    }
                }
            };
            xhr.send(data);
        }

        function createRemboursement() {
            const montant = document.getElementById("montant").value;
            const dateRemboursement = document.getElementById("dateRemboursement").value;
            const numeroIdentification = document.getElementById("numeroIdentification").value;

            if (!montant || !dateRemboursement || !numeroIdentification) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            ajax("GET", `/clients/${numeroIdentification}`, null, (client) => {
                if (!client || !client.id) {
                    alert("Client introuvable !");
                    return;
                }

                const idClient = client.id;

      
                const data =
                    `montant=${encodeURIComponent(montant)}` +
                    `&dateRemboursement=${encodeURIComponent(dateRemboursement)}` +
                    `&idClient=${encodeURIComponent(idClient)}`;

                ajax("POST", "/remboursements", data, () => {
                    alert("Remboursement enregistré !");
                });
            });
        }




        function resetForm() {
            document.getElementById("numeroIdentification").value = "";
            document.getElementById("montant").value = "";
            document.getElementById("dateRemboursement").value = "";
        }
    </script>
</body>

</html>