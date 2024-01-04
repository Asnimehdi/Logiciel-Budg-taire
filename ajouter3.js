function validerMontantManuel3(numero, libelle, chapitre, article, fonction, nature, direction, statut, section, etapeVote, codeEnveloppe, phasageAp, politique) {
    // Récupérer l'élément du champ de saisie du montant par son ID
    var montantInput = document.getElementById('montant_' + numero);
    
    // Activer le champ de saisie du montant pour permettre la modification
    montantInput.disabled = false;
    
    // Créer un nouvel élément bouton pour le remplacement du bouton "Modifier"
    var validerButton = document.createElement('button');
    validerButton.className = 'validerButton';
    validerButton.style.backgroundColor = '#333';
    validerButton.style.color = 'white';
    validerButton.style.padding = '15px 30px';
    validerButton.innerHTML = 'Valider';
    
    // Supprimer l'ancien bouton "Modifier"
    var ancienBouton = event.target;
    ancienBouton.parentNode.removeChild(ancienBouton);
    
    // Ajouter le nouvel élément bouton "Valider" à la cellule correspondante
    var celluleBouton = montantInput.parentElement.nextElementSibling;
    celluleBouton.appendChild(validerButton);
    
    // Gérer la validation du montant lorsque l'utilisateur clique sur "Valider"
    validerButton.addEventListener('click', function() {
        var montant = montantInput.value.trim();

        // Vérifier si le montant n'est pas vide
        if (montant !== '') {
            // Effectuez une requête AJAX pour ajouter les données à la base de données
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'modifier.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Traitement de la réponse du serveur si nécessaire
                    console.log(xhr.responseText);
                }
            };

            // Envoyez les données au serveur
            xhr.send('numero=' + numero + '&libelle=' + encodeURIComponent(libelle) + '&chapitre=' + chapitre + '&article=' + article + '&fonction=' + fonction + '&nature=' + nature + '&montant=' + montant + '&direction=' + direction + '&statut=' + statut + '&section=' + section + '&etapeVote=' + etapeVote + '&codeEnveloppe=' + codeEnveloppe + '&phasageAp=' + phasageAp + '&politique=' + encodeURIComponent(politique));
            
            // Désactiver le champ de saisie du montant après validation
            montantInput.disabled = true;
        } else {
            alert('Veuillez saisir un montant avant de valider.');
        }
    });
}

