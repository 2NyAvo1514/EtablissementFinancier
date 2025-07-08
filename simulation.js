// Synchronisation Montant
const montantRange = document.getElementById("montantRange");
const montantInput = document.getElementById("montantInput");

montantRange.addEventListener("input", () => {
    montantInput.value = montantRange.value;
});
montantInput.addEventListener("input", () => {
    montantRange.value = montantInput.value;
});

// Synchronisation Durée
const dureeRange = document.getElementById("dureeRange");
const dureeInput = document.getElementById("dureeInput");

dureeRange.addEventListener("input", () => {
    dureeInput.value = dureeRange.value;
});
dureeInput.addEventListener("input", () => {
    dureeRange.value = dureeInput.value;
});

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

function chargerTypeClient() {
    ajax("GET", "/typeClients", null, (data) => {
        const select = document.getElementById("typeClient");
        select.innerHTML = '<option value="">-- Choisir type --</option>';
        data.forEach(item => {
            const opt = document.createElement("option");
            // opt.id="option";
            opt.value = item.id;
            opt.textContent = item.typeClient;
            select.append(opt);
        });
    });
}

function afficherPallier() {
    const min = document.getElementById("min");
    const max = document.getElementById("max");
    const select = document.getElementById("typePret");
    const selectedId = select.value;

    const dureeRange = document.getElementById("dureeRange");
    const dureeInput = document.getElementById("dureeInput");

    if (!selectedId) {
        min.textContent = "-";
        max.textContent = "-";
        dureeRange.min = dureeInput.min = 1;
        dureeRange.max = dureeInput.max = 60;
        return;
    }

    ajax("GET", "/typePret", null, (data) => {
        const selected = data.find(item => item.id == selectedId);
        if (selected) {
            const minVal = selected.dureeMin;
            const maxVal = selected.dureeMax;

            min.textContent = minVal;
            max.textContent = maxVal;

            dureeRange.min = dureeInput.min = minVal;
            dureeRange.max = dureeInput.max = maxVal;

            // Réinitialiser la valeur à min par défaut pour éviter hors-pallier
            dureeRange.value = dureeInput.value = minVal;
        } else {
            min.textContent = "-";
            max.textContent = "-";
            dureeRange.min = dureeInput.min = 1;
            dureeRange.max = dureeInput.max = 60;
        }
    });
}

function simulerPret() {
    const div = document.getElementById("resultat");
    div.innerHTML = ""; // on vide l'ancien résultat

    const montant = parseFloat(montantInput.value);
    const duree = parseInt(dureeInput.value);
    const typePret = document.getElementById("typePret").value;
    const typeClient = document.getElementById("typeClient").value;

    if (!montant || !duree || !typePret || !typeClient) {
        div.innerHTML = "<p style='color:red'>Veuillez remplir tous les champs pour simuler.</p>";
        return;
    }

    ajax("GET", "/taux", null, (data) => {
        const tauxData = data.find(item => item.idTypeClient == typeClient && item.idTypePret == typePret);

        if (!tauxData) {
            div.innerHTML = "<p style='color:red'>Aucun taux trouvé pour cette combinaison type client/prêt.</p>";
            return;
        }

        const taux = parseFloat(tauxData.valeur); // exemple : 12 pour 12%
        const tauxMois = taux / 12 / 100;         // en proportion mensuelle
        const montantARembourser = montant * (1 + tauxMois * duree);
        const mensualite = montantARembourser / duree;

        div.innerHTML = `
            <p>Taux d’intérêt mensuel : <strong>${(tauxMois * 100).toFixed(2)}%</strong></p>
            <p>Montant total à rembourser : <strong>${montantARembourser.toFixed(2)} Ariary</strong></p>
            <p>Mensualité : <strong>${mensualite.toFixed(2)} Ariary</strong></p>
        `;
    });
}


function sauvegarder() {
    afficherPallier();
    const montant = document.getElementById("montantInput").value;
    const duree = document.getElementById("dureeInput").value;
    const typePret = document.getElementById("typePret").value;
    const typeClient = document.getElementById("typeClient").value;
    const data = new URLSearchParams({
        typePret, typeClient, montant, duree
    }).toString();
    ajax("POST", "/simulation", data, () => { });
}

function versPret() {

}

chargerTypePret();
chargerTypeClient();