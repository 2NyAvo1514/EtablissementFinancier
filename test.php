<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pret | Etablissement bancaire</title>
    <style>
        body {
        font-family: comic,sans-serif;
        padding: 20px;
        }

        input,
        button,select {
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
    <div>
        <h2> Formulaire de Pret </h2>
        <input type="hidden" id="id"><br>
        Nom : <input type="text" id="nom" placeholder="Nom"><br>
        Numero d'identification : <input type="text" id="numident" placeholder="Numero Identifiant"><br>
        Type de pret : <select name="typePret" id="typePret" onchange="afficherPallier()"></select><br>
        ( Pallier de dur&eacute;e : entre <strong id="min"></strong> et <strong id="max"></strong> mois )<br>
        Dur&eacute;e de paiement : <input type="number" id="duree" placeholder="Dur&eacute;e en mois"><br>
        Montant : <input type="number" id="montant" placeholder="Montant"><br>
        Date de pret : <input type="date" name="datePret" id="datePret"><br>
        <hr>
        <button onClick="executerPret()">Effectuer pret</button>
    </div>
    <script>
        const apiBase = "http://localhost:80/finalExamS4_ETU003130_ETU003158_ETU003160/ws";

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

        function chargerTypePret (){
            ajax("GET", "/typePret", null, (data)=>{
                const select = document.getElementById("typePret");
                select.innerHTML = '<option value="">-- Choisir type --</option>';
                data.forEach( item => {
                    const opt = document.createElement("option");
                    // opt.id="option";
                    opt.value = item.id ;
                    opt.textContent = item.typePret ;
                    select.append(opt);
                });
            });
        }

        function afficherPallier(){
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
            ajax("GET", "/typePret", null, (data)=>{
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
            const nom = document.getElementById("nom").value;
            const numId = document.getElementById("numident").value;
            const typePret = document.getElementById("typePret").value;
            const duree = document.getElementById("duree").value;
            const montant = document.getElementById("montant").value;
            const datePret = document.getElementById("datePret").value;
            // const data = `nom=${nom}&numId=${numId}&typePret=${typePret}duree=${duree}&montant=${montant}&datePret=${datePret}` ; 
            // const data = 
            //     "nom=" + encodeURIComponent(nom) +
            //     "&numId=" + encodeURIComponent(numId) +
            //     "&typePret=" + encodeURIComponent(typePret) +
            //     "&duree=" + encodeURIComponent(duree) +
            //     "&montant=" + encodeURIComponent(montant) +
            //     "&datePret=" + encodeURIComponent(datePret);
            const data = new URLSearchParams({
                nom,
                numId,
                typePret,
                duree,
                montant,
                datePret
            }).toString();
                // console.log(data);
            ajax("POST","/pret",data,()=>{});
            // ajax("GET","/blabla",null,()=>{})
        }

        chargerTypePret();
    </script>
</body>
</html>