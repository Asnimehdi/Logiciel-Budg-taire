function validerMontantManuel(numero, libelle, chapitre, article, fonction, nature, direction, numBudg, statut, section, etapeVote, codeEnveloppe, phasageAp, politique) {
    var montantInput = document.querySelector('input[name="montant_' + numero + chapitre + article + fonction + '"]');
    var montant = montantInput.value.trim();

    // Vérifiez si le montant n'est pas vide
    if (montant !== '') {
        // Effectuez une requête AJAX pour ajouter les données à la base de données
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajouter.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Traitement de la réponse du serveur si nécessaire
                console.log(xhr.responseText);
            }
        };

        // Envoyez les données au serveur
        xhr.send('numero=' + numero +
            '&libelle=' + encodeURIComponent(libelle) +
            '&chapitre=' + chapitre +
            '&article=' + article +
            '&fonction=' + fonction +
            '&nature=' + nature +
            '&montant=' + montant +
            '&direction=' + direction +
            '&numBudg=' + numBudg +
            '&statut=' + statut +
            '&section=' + section +
            '&etapeVote=' + etapeVote +
            '&codeEnveloppe=' + codeEnveloppe +
            '&phasageAp=' + phasageAp +
            '&politique=' + encodeURIComponent(politique));
    } else {
        alert('Le montant ne peut pas être vide.');
    }
}
