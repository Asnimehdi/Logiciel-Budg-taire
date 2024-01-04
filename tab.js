document.addEventListener('DOMContentLoaded', function () {
    var operationInput = document.getElementById('operation');
    var libelleInput = document.getElementById('libelle');
    var resultTable = document.getElementById('resultTable');
    
    operationInput.addEventListener('input', function () {
        libelleInput.removeAttribute('disabled');  // Ajout : Réactiver le champ libelleInput
        var operation = this.value;
        updateResults(operation, null);
    });

    libelleInput.addEventListener('input', function () {
        operationInput.removeAttribute('disabled');  // Ajout : Réactiver le champ operationInput
        var libelle = this.value;
        updateResults(null, libelle);
    });

    function updateResults(operation, libelle) {
        $.ajax({
            url: 'tab.php',
            type: 'GET',
            data: { operation: operation, libelle: libelle },
            success: function (data) {
                resultTable.innerHTML = data;
            }
        });
    }
 

});


