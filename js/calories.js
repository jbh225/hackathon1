// ------------------------------------------------------------------------------------
var xhrLieu;
// ------------------------------------------------------------------------------------
function getXMLHttpRequest() {
    var xhr = null;
    if (window.XMLHttpRequest || window.ActiveXObject) {
    if (window.ActiveXObject) {
    try { xhr = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e) { xhr = new ActiveXObject("Microsoft.XMLHTTP"); }
    }
    else { xhr = new XMLHttpRequest(); }
    }
    else {
    alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
    return null;
    }
    return xhr;
 }
 // ----------------------------------------------------------
function majIntensite() {
    document.getElementById('intensite').style.visibility = 'hidden';
    id = document.getElementById('sport').value;
    var url = 'listeplus.php?id=' + id;
    if (xhrLieu && xhrLieu.readyState != 0) {
        xhrLieu.abort();
    } // on annule la requête en cours !
    xhrLieu = getXMLHttpRequest();
    xhrLieu.onreadystatechange = function () {
        if (xhrLieu.readyState == 4 && (xhrLieu.status == 200 || xhrLieu.status == 0)) majListe(xhrLieu.responseText);
    }
    xhrLieu.open('GET', url, true);
    xhrLieu.send(null);
}
// ----------------------------------------------------------
function majListe(reponse) {
    var objet = document.getElementById('intensite').options;
    objet.length = 0;
    var tmpLgn = new Array();
    var tmpListe = new Array();
    tmpListe = reponse.split('#');
    if ( tmpListe[0] == "ToutBon" ) {
        if ( tmpListe.length > 2 )document.getElementById('intensite').style.visibility = 'visible';
        // --- si plus d'une option
       // if ( tmpListe.length > 2 ) objet[0] = new Option('- Non d\351fini -','0');
        // --- ajout des autres sites collectes
        for ( i=1; i<(tmpListe.length-1); i++ ) {
            tmpLgn = tmpListe[i].split('*');
            objet[objet.length] = new Option(' '+tmpLgn[1]+' ',tmpLgn[2]);
        }
    }
}
// ---------------------------------------------------------------------------------------------
function calcule() {
    // --- depense horaire
    var depense = document.getElementById('intensite').value + calories[document.getElementById('sport').value];
    duree = kCal/depense;

    console.log(document.getElementById('intensite').value)
    console.log(depense+'  '+duree);

    var texte = 'Pour brûler les '+kCal+' calories de votre '+nomProd+',<br />vous devez pratiquer l\'activité choisie ';
    texte += 'pendant '+ Math.round(duree*60) + ' heures.';
    document.getElementById('resultat').innerHTML = texte;


}
// ---------------------------------------------------------------------------------------------
