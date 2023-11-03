document.addEventListener('DOMContentLoaded', function() {
    var libelleInput = document.getElementById('libelle');

    libelleInput.addEventListener('input', function() {
        var libelle = this.value;
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Mettez à jour la liste déroulante avec les options retournées par le serveur
                document.getElementById('resultats').innerHTML = xhr.responseText;
            }
        };

        xhr.open('GET', 'recherch.php?libelle=' + libelle, true);
        xhr.send();
    });

    // Ajoutez un gestionnaire d'événements pour mettre à jour l'input texte lorsque l'utilisateur sélectionne une option dans la liste déroulante
    document.getElementById('libelle').addEventListener('change', function() {
        libelleInput.value = this.value;
    });
});
