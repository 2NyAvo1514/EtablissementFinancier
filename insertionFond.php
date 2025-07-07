<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Gestion des Taux</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="container">
        <?php include 'navbar.html'; ?>

        <main class="content">
            <h1>Insertion de Fond</h1>

            <label for="valeur">Valeur du fond</label>
            <input type="number" id="valeur" name="solde" />

            <button onclick="createFond()">Ajouter</button>
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

        function createFond() {
            const valeur = document.getElementById("valeur").value;


            const data = `&solde=${encodeURIComponent(valeur)}`;

            ajax("POST", "/fond", data, () => {
                alert("Fond ajouté !");
                document.querySelector("form")?.reset?.();
            });
        }

    </script>
</body>

</html>