<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pret | Etablissement bancaire</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <div class="container">
            <div class="sidebar">
                <?php include 'navbar.html'; ?>
            </div>
            <main class="content">
                <h2> Formulaire de Pret </h2>
                <input type="hidden" id="id"><br>
                <label for="nom">Nom : </label><br>
                <input type="text" id="nom" placeholder="Nom"><br>
                <label for="numident">Numero d'identification : </label><br>
                <input type="text" id="numident" placeholder="Numero Identifiant"><br>
                <label for="typePret">Type de pret : </label><br>
                <select name="typePret" id="typePret" onchange="afficherPallier()"></select><br>
                <label for="duree">Dur&eacute;e de paiement : </label><br>
                ( Pallier de dur&eacute;e : entre <strong id="min"></strong> et <strong id="max"></strong> mois )<br>
                <input type="number" id="duree" placeholder="Dur&eacute;e en mois"><br>
                <label for="montant">Montant : </label><br>
                <input type="number" id="montant" placeholder="Montant"><br>
                <label for="datePret">Date de pret :</label><br>
                <input type="date" name="datePret" id="datePret"><br>
                <label for="descri"> Description : </label><br>
                <textarea name="descri" id="descri" cols="25" rows="5"></textarea>
                <hr>
                <button onClick="executerPret()">💰 Effectuer pret</button>

            </main>

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
                    xhr.send(data);
                }

                function chargerTypePret() {
                    ajax("GET", "/typePret", null, (data) => {
                        const select = document.getElementById("typePret");
                        select.innerHTML = '<option value="">-- Choisir type --</option>';
                        data.forEach(item => {
                            const opt = document.createElement("option");
                            // opt.id="option";
                            opt.value = item.id;
                            opt.textContent = item.typePret;
                            select.append(opt);
                        });
                    });
                }

                function afficherPallier() {
                    const min = document.getElementById("min");
                    const max = document.getElementById("max");
                    const select = document.getElementById("typePret");
                    const selectedId = select.value;

                    if (!selectedId) {
                        min.textContent = "-";
                        max.textContent = "-";
                        return;
                    }

                    // On récupère les données depuis le serveur pour ce type de prêt
                    ajax("GET", "/typePret", null, (data) => {
                        const selected = data.find(item => item.id == selectedId);
                        if (selected) {
                            min.textContent = selected.dureeMin;
                            max.textContent = selected.dureeMax;
                        } else {
                            min.textContent = "-";
                            max.textContent = "-";
                        }
                    });
                }


                function executerPret() {
                    // const id = document.getElementById("id").value;
                    afficherPallier();
                    const minVal = parseInt(document.getElementById("min").textContent);
                    const maxVal = parseInt(document.getElementById("max").textContent);

                    const nom = document.getElementById("nom").value;
                    const numId = document.getElementById("numident").value;
                    const typePret = document.getElementById("typePret").value;
                    const duree = document.getElementById("duree").value;
                    const montant = document.getElementById("montant").value;
                    const datePret = document.getElementById("datePret").value;
                    const descri = document.getElementById("descri").value;
                    // const data = `nom=${nom}&numId=${numId}&typePret=${typePret}duree=${duree}&montant=${montant}&datePret=${datePret}` ; 
                    // const data = 
                    //     "nom=" + encodeURIComponent(nom) +
                    //     "&numId=" + encodeURIComponent(numId) +
                    //     "&typePret=" + encodeURIComponent(typePret) +
                    //     "&duree=" + encodeURIComponent(duree) +
                    //     "&montant=" + encodeURIComponent(montant) +
                    //     "&datePret=" + encodeURIComponent(datePret);
                    if (duree < minVal || duree > maxVal) {
                        alert("Votre durée de paiement se situe hors du pallier. Veuillez réessayer ");
                    }
                    const data = new URLSearchParams({
                        nom,
                        numId,
                        typePret,
                        duree,
                        montant,
                        datePret,
                        descri
                    }).toString();
                    // console.log(data);
                    ajax("POST", "/pret", data, () => { });
                    // ajax("GET","/blabla",null,()=>{})
                }

                chargerTypePret();
            </script>
        </div>
</body>

</html>