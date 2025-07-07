<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prévision des intérêts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <?php include 'navbar.html'; ?>
        <main class="content">
            <h1>Réalisation des intérêts par mois</h1>
            <br>
            <label for="moisDebut">Mois Début</label>
            <br>
            <input type="number" name="moisDebut" id="moisDebut" min="1" max="12">
            <br>
            <label for="anneeDebut">Année Début</label>
            <br>
            <input type="number" name="anneeDebut" id="anneeDebut">
            <br>
            <label for="moisFin">Mois Fin</label>
            <br>
            <input type="number" name="moisFin" id="moisFin" min="1" max="12">
            <br>
            <label for="anneeFin">Année Fin</label>
            <br>
            <input type="number" name="anneeFin" id="anneeFin">
            <br>
            <button onclick="chargerTableau()">Voir le tableau</button>
            <h3 id="totalInteret">Total des intérêts : 0 Ar</h3>
            <table id="result">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Année</th>
                        <th>Prêt</th>
                        <th>Réalisation</th>
                        <th>Intérêt</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <h2>Évolution des intérêts</h2>
            <canvas id="interetChart" width="800" height="400"></canvas>
        </main>
    </div>
    <script>
        const apiBase = "http://localhost:81/tp-flightphp-crud-MVC/finalExamS4_ETU003130_ETU003158_ETU003160/ws";
        let chart = null;

        function ajax(method, url, data, cb) {
            const x = new XMLHttpRequest();
            x.open(method, apiBase + url, true);
            x.onreadystatechange = () => {
                if (x.readyState === 4 && x.status === 200) {
                    cb(JSON.parse(x.responseText));
                }
            };
            x.send(data);
        }

        function chargerTableau() {
            const md = document.getElementById('moisDebut').value;
            const ad = document.getElementById('anneeDebut').value;
            const mf = document.getElementById('moisFin').value;
            const af = document.getElementById('anneeFin').value;

            if (!md || !ad || !mf || !af) {
                alert("Veuillez remplir toutes les dates.");
                return;
            }

            const url = `/dashboard/interetsRealisation?md=${md}&ad=${ad}&mf=${mf}&af=${af}`;

            ajax("GET", url, null, data => {
                const tbody = document.querySelector("#result tbody");
                tbody.innerHTML = "";

                const labels = [];
                const valeursInterets = [];
                let total = 0;

                data.forEach(l => {
                    const interet = Number(l.interet || 0);
                    total += interet;
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${l.mois}</td>
                        <td>${l.annee}</td>
                        <td>${Number(l.pret || 0).toFixed(2)}</td>
                        <td>${Number(l.final || 0).toFixed(2)}</td>
                        <td>${Number(l.interet || 0).toFixed(2)}</td>
                    `;
                    tbody.appendChild(tr);

                    // Données pour le graphique
                    labels.push(`${l.mois}/${l.annee}`);
                    valeursInterets.push(Number(l.interet || 0));
                });
                document.getElementById("totalInteret").textContent =
                    "Total des intérêts : " + total.toFixed(2) + " Ar";

                afficherGraphique(labels, valeursInterets);
            });
        }

        function afficherGraphique(labels, data) {
            const ctx = document.getElementById('interetChart').getContext('2d');

            if (chart) chart.destroy(); // détruire l'ancien graphique s'il existe

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Intérêts mensuels',
                        data: data,
                        borderColor: 'blue',
                        backgroundColor: 'lightblue',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: "Montant en Ar"
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: "Mois"
                            }
                        }
                    }
                }
            });
        }
    </script>

</body>

</html>