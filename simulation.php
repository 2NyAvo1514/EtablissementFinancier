<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Simulation | Etablissement bancaire </title>
    <style>
        .input-range-group {
            margin-bottom: 20px;
        }

        input[type="range"],
        input[type="number"] {
            margin-right: 10px;
            margin-top: 5px;
        }
        input[type=range] {
            -webkit-appearance: none;
            width: 22%;
            height: 10px;
            background: linear-gradient(to right, #3b82f6, #60a5fa); /* bleu dégradé */
            border-radius: 5px;
            outline: none;
            transition: background 0.3s;
            margin-top: 5px;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: #2563eb; /* bleu plus foncé */
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
            transition: transform 0.2s;
        }

        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        input[type=range]::-moz-range-thumb {
            width: 16px;
            height: 16px;
            background: #2563eb;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>

    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div>
        <div class="container">
            <div class="sidebar">
                <?php include 'navbar.html'; ?>
            </div>
            <main class="content">
                <!-- À insérer dans <main class="content"> -->
                <h1>Simulation de prêt</h1>

                <label for="typePret">Type de prêt :</label><br>
                <select name="typePret" id="typePret" onchange="afficherPallier()"></select><br>

                <label for="typeClient">Type de Client :</label><br>
                <select name="typeClient" id="typeClient"></select><br>

                <!-- MONTANT -->
                <div class="input-range-group">
                    <label for="montantRange">Montant à prêter :</label><br>
                    <input type="number" id="montantInput" min="100000" max="100000000000" step="10000"><br><br>
                    <input type="range" id="montantRange" min="100000" max="100000000000" step="10000">
                </div>

                <!-- DUREE -->
                <div class="input-range-group">
                    <label for="dureeRange">Durée sollicitée (en mois) : entre <strong id="min"></strong> et <strong id="max"></label><br>
                    <input type="number" id="dureeInput" min="1" max="60"><br><br>
                    <input type="range" id="dureeRange" min="1" max="60">
                </div>

                <button onClick="simulerPret()">Commencer</button><br><br>
                <hr>
                        <h2>Resultat de la simulation :</h2>
                    <div class="resultat" id="resultat">

                    </div><br>
                <hr>
                <div style="margin-top: 20px;">
                    <button onClick="sauvegarder()">Sauvegarder</button><br>
                    <strong>OU</strong><br>
                    <button>Valider comme Prêt</button>
                </div>

            </main>
        </div>
    </div>
    <script src="simulation.js"></script>
</body>
</html>