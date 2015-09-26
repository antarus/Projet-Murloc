var firstAffichage = 0;
/**
 * Progress bar pour l'import des membres d'une guilde.
 * @param {type} data
 * @returns {undefined}
 */
function progressImportPersonnage(data)
{
    if (firstAffichage === 0) {
        document.getElementById('wow-zend-progressbar-container').style.display = "inline";
        document.getElementById('wow-import-container').style.display = "inline";
        document.getElementById('wow-iframe-traitement').style.width = '1px';
        document.getElementById('wow-iframe-traitement').style.heght = '1px';
        firstAffichage = 1;
    }
    document.getElementById('wow-zend-progressbar-done').style.width = data.percent + '%';
    var info = document.getElementById('wow-import-container')
    info.innerHTML = data.text + '<br />' + info.innerHTML;
}

function progressImportPersonnageFin(data)
{
    $('#dlgImport').dialog('close');
    $('#msgWowImport').html('Guilde importée.');
}
/**
 * Redimensionne l'iframe a la hauteur de l'objet parent.
 * @param {type} obj
 * @returns {undefined}
 */
function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

