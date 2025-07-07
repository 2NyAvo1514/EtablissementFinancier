<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php include 'navbar.html'; ?>

        <main class="content">
            <h1>Insertion de client</h1>

            <label for="nomClient">Nom</label>
            <br>
            <input type="text" id="nomClient" name="nom" required><br>
            <br>
            <label for="mail">E-mail</label>
            <br>
            <input type="email" id="mail" name="mail" required><br>
            <br>
            <label for="mdp">Mot de passe</label>
            <br>
            <input type="password" id="mdp" name="mdp" required><br>
            <br>
            <label for="dateNaissance">Date de Naissance</label>
            <br>
            <input type="date" id="dateNaissance" name="dateNaissance" required><br>
            <br>
            <label for="idTypeClient">Choisir votre type de compte</label>
            <br>
            <select id="idTypeClient" name="idTypeClient" required>
                <option value="">-- Sélectionnez --</option>
            </select><br>
            <br>
            <label for="numeroIdentification">Numéro d'identification (CIN ou NIF)</label>
            <br>
            <input type="text" id="numeroIdentification" name="numeroIdentification" required><br>
            <br>
            <button onclick="createClient()" class="ajouter">Ajouter</button>
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

        function createClient() {
            const nom = document.getElementById("nomClient").value;
            const mail = document.getElementById("mail").value;
            const mdp = document.getElementById("mdp").value;
            const dateNaissance = document.getElementById("dateNaissance").value;
            const numeroIdentification = document.getElementById("numeroIdentification").value;
            const idTypeClient = document.getElementById("idTypeClient").value;

            if (!nom || !mail || !mdp || !dateNaissance || !numeroIdentification || !idTypeClient) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            const data =
                `nom=${encodeURIComponent(nom)}` +
                `&mail=${encodeURIComponent(mail)}` +
                `&mdp=${encodeURIComponent(mdp)}` +
                `&dateNaissance=${encodeURIComponent(dateNaissance)}` +
                `&numeroIdentification=${encodeURIComponent(numeroIdentification)}` +
                `&idTypeClient=${encodeURIComponent(idTypeClient)}`;

            ajax("POST", "/clients", data, (response) => {
                alert("Client ajouté avec succès !");
                resetForm();
            });
        }

        function chargertypeClient() {
            ajax("GET", "/typeClients", null, (data) => {
                const select = document.getElementById("idTypeClient");
                select.innerHTML = '<option value="">-- Sélectionnez --</option>';

                data.forEach(item => {
                    const opt = document.createElement("option");
                    opt.value = item.id;
                    opt.textContent = item.typeClient;
                    select.appendChild(opt);
                });
            });
        }

        function resetForm() {
            document.getElementById("nomClient").value = "";
            document.getElementById("mail").value = "";
            document.getElementById("mdp").value = "";
            document.getElementById("dateNaissance").value = "";
            document.getElementById("numeroIdentification").value = "";
            document.getElementById("idTypeClient").value = "";
        }

        chargertypeClient();
    </script>
</body>

</html>