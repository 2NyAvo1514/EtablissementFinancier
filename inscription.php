<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des étudiants</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        input,
        button {
            margin: 5px;
            padding: 5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Insertion de client</h1>
    <label for="nomClient">Nom</label>
    <input type="text" name="nom" id="nomClient">
    <br>
    <label for="mail">E-mail</label>
    <input type="email" name="mail" id="mail">
    <br>
    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" id="mdp">
    <br>
    <label for="dateNaissance">Date de Naissance</label>
    <input type="date" name="dateNaissance" id="dateNaissance">
    <br>
    <label for="idTypeClient">Choisir votre type de compte</label>
    <select name="idTypeClient" id="idTypeClient">
        <option value=""></option>
    </select>
    <br>
    <label for="numeroIdentification">Insérer votre numéro d'identification (CIN ou NIF)</label>
    <input type="text" id="numeroIdentification" name="numeroIdentification">
    <button onclick='createClient()'>Ajouter</button>

    <script>


        const apiBase = "http://localhost:81/tp-flightphp-crud-MVC/finalExamS4_ETU003130_ETU003158_ETU003160/ws";

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

        function createClient() {
            const nom = document.getElementById("nomClient").value;
            const mail = document.getElementById("mail").value;
            const mdp = document.getElementById("mdp").value;
            const dateNaissance = document.getElementById("dateNaissance").value;
            const numeroIdentification = document.getElementById("numeroIdentification").value;
            const idTypeClient = document.getElementById("idTypeClient").value;

            const data = `nom=${encodeURIComponent(nom)}&mail=${encodeURIComponent(mail)}&mdp=${encodeURIComponent(mdp)}&dateNaissance=${encodeURIComponent(dateNaissance)}&numeroIdentification=${encodeURIComponent(numeroIdentification)}&idTypeClient=${encodeURIComponent(idTypeClient)}`;

            ajax("POST", "/clients", data, () => {
                // resetForm();
                chargertypeClient();
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

        chargertypeClient();
    </script>

</body>

</html>