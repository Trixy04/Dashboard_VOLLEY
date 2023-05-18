<?php
session_start();
include("config.php");

$formato = 'Y-m-d';
$cognome = $_POST["cognome"];
$dataN = strtotime($_POST["dataNascita"]);
$dataNascita = date($formato, $dataN);

$luogoNascita = $_POST["luogoNascita"];
$indirizzo = $_POST["indirizzo"];
$tipoVia = $_POST["tipoVia"];
$civico = $_POST["civico"];
$cap = $_POST["cap"];
$citta = $_POST["citta"];
$titolo = $_POST["titolo"];
$nome = $_POST["nome"];
$provinciaNascita = $_POST["provinciaNascita"];
$provinciaResidenza = $_POST["provincia"];
$numDocumento = $_POST["documento"];
$numTelefono = $_POST["tel1"];
$email = $_POST["email"];
$fotoAtleta = $_POST["fotoAtleta"];
$tipCert = $_POST["tipologia"];
$numCertificato = $_POST["numeroCert"];

$dataSc = strtotime($_POST["scadenzaDocumento"]);
$dataScCert = date($formato, $dataSc);

$dataE = strtotime($_POST["dataVisita"]);
$dataEsame = date($formato, $dataE);

$dataCreazione = date("Y-m-d");

$dottore = $_POST["dottore"];
$struttura = $_POST["struttura"];
$idTipo = $_POST["tipoCert"];

$squadra = $_POST["squadra"];

if (isset($_POST["sessoMaschio"])) {
    $sesso = $_POST["sessoMaschio"];
} else {
    $sesso = $_POST["sessoFemmina"];
}

$codFiscale = $_POST["codiceFiscale"];
$fileCert = $_POST["caricaCert"];
$tipoDoc = $_POST["tipoDoc"];

$maglia = $_POST["maglia"];
$idSquadra = $_POST["squadra"];


//INSERIMENTO RESIDENZA
$sqlResidenza = "INSERT INTO residenza (id_tipoVia, indirizzo, civico, citta, cap, provincia, nazione)
VALUES ($tipoVia, '$indirizzo', '$civico', '$citta', '$cap', '$provinciaResidenza', 'Italia')";

if ($conn->query($sqlResidenza) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlIdResidenza = "SELECT max(id) AS id FROM residenza";
$result = $conn->query($sqlIdResidenza);
while ($row = $result->fetch_assoc()) {
    $idResidenza = $row["id"];
}

//INSERIMENTO CONTATTO
$sqlContatti = "INSERT INTO contatto (prefissoCell, cellulare, email)
VALUES('39', '$numTelefono', '$email')";
if ($conn->query($sqlContatti) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlIdContatti = "SELECT max(id) AS id FROM contatto";
$result = $conn->query($sqlIdContatti);
while ($row = $result->fetch_assoc()) {
    $idContatto = $row["id"];
}

//INSERIMENTO DOCUMENTO
$sqlDocumento = "INSERT INTO documento(numero_documento, id_tipologia)
VALUES('$numDocumento', $tipoDoc)";
if ($conn->query($sqlDocumento) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlIdDoc = "SELECT max(id) AS id FROM documento";
$result = $conn->query($sqlIdDoc);
while ($row = $result->fetch_assoc()) {
    $idDoc = $row["id"];
}

//INSERIMENTO CERTIFICATO
$sqlCertificato = "INSERT INTO certificato(numeroCertificato, dataEsame, dataScadenza, dottore, struttura, id_tipo)
VALUES('$numCertificato', '$dataEsame', '$dataScCert', '$dottore', '$struttura', $idTipo);";
if ($conn->query($sqlCertificato) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlCert = "SELECT max(id) AS id FROM certificato";
$result = $conn->query($sqlCert);
while ($row = $result->fetch_assoc()) {
    $idCert = $row["id"];
}

//INSERIMENTO DATI PERSONA
$sqlDatiPersona = "INSERT INTO persona (cod_fiscale, cognome, nome, id_sesso, id_titolo, luogo_nascita, data_nascita, provinciaNascita, dataCreazione, id_contatti, id_residenza, id_documento)
VALUES ('$codFiscale', '$cognome', '$nome', $sesso, $titolo, '$luogoNascita', '$dataNascita', '$provinciaNascita', '$dataCreazione', $idContatto, $idResidenza, $idDoc);";
if ($conn->query($sqlDatiPersona) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlIdPers = "SELECT max(cod_utente) AS id FROM persona";
$result = $conn->query($sqlIdPers);
while ($row = $result->fetch_assoc()) {
    $idPers = $row["id"];
}

//INSERIMENTO GIOCATORE
$sqlGiocatore = "INSERT INTO giocatore (id_persona, id_certificato, num_maglia)
VALUES($idPers, $idCert, $maglia)";
if ($conn->query($sqlGiocatore) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlIdGioca = "SELECT max(id) AS id FROM giocatore";
$result = $conn->query($sqlIdGioca);
while ($row = $result->fetch_assoc()) {
    $idGioc = $row["id"];
}

//INSERIMENTO GICOA
$sqlGioca = "INSERT INTO gioca(id_giocatore, id_squadra)
VALUES($idGioc, $squadra)";
if ($conn->query($sqlGioca) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

if (isset($_POST["datiFattSINO"])) {

    //INSERIMENTO DATI FATTURAZIONE
    $sqlFatturazione = "INSERT INTO dati_Fatturazione(cod_fiscale, cognome, nome, titolo, id_residenza, id_contatti)
VALUES ('$codFiscale', '$cognome', '$nome', $titolo, $idResidenza, $idContatto)";
    if ($conn->query($sqlFatturazione) == TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sqlIdFatt = "SELECT max(id) AS id FROM dati_fatturazione";
    $result = $conn->query($sqlIdFatt);
    while ($row = $result->fetch_assoc()) {
        $idFatt = $row["id"];
    }

    $sqltabellafatt = "INSERT INTO fattDatiPersona (id_datiFatt, id_personaRiferita)
    VALUES ($idFatt, $idPers)";
    if ($conn->query($sqltabellafatt) == TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $_SESSION["codFiscale"] = $codFiscale;
    header("Location: ../PAGES/resultResearch.php");

} else {

    $codFiscaleFatt = $_POST["codFiscaleFatt"];
    $cognomeFatt = $_POST["cognomeFatt"];
    $nomeFatt = $_POST["nomeFatt"];
    $emailFatt = $_POST["emailFatt"];
    $indirizzoFatt = $_POST["indirizzoFatt"];
    $provinciaFatt = $_POST["provinciaFatt"];
    $civicoFatt = $_POST["civicoFatt"];
    $cittaFatt = $_POST["cittaFatt"];
    $tipoFatt = $_POST["tipoFatt"];
    $capFatt = $_POST["capFatt"];
    $cellulareFatt = $_POST["cellulareFatt"];
    $titoloFatt = $_POST["titoloFatt"];

    $sqlContattiFatt = "INSERT INTO contatto (prefissoCell, cellulare, email)
VALUES('39', '$cellulareFatt', '$emailFatt')";
    if ($conn->query($sqlContattiFatt) == TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sqlIdContattiFatt = "SELECT max(id) AS id FROM contatto";
    $result = $conn->query($sqlIdContattiFatt);
    while ($row = $result->fetch_assoc()) {
        $idContattoFatt = $row["id"];
    }

    $sqlResidenzaFatt = "INSERT INTO residenza (id_tipoVia, indirizzo, civico, citta, cap, provincia, nazione)
VALUES ($tipoFatt, '$indirizzoFatt', '$civicoFatt', '$cittaFatt', '$capFatt', '$provinciaFatt', 'Italia')";

    if ($conn->query($sqlResidenzaFatt) == TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sqlIdResidenzaFatt = "SELECT max(id) AS id FROM residenza";
    $result = $conn->query($sqlIdResidenzaFatt);
    while ($row = $result->fetch_assoc()) {
        $idResidenzaFatt = $row["id"];
    }

    $sqlFatturazione = "INSERT INTO dati_Fatturazione(cod_fiscale, cognome, nome, titolo, id_residenza, id_contatti)
VALUES ('$codFiscaleFatt', '$cognomeFatt', '$nomeFatt', $titoloFatt, $idResidenzaFatt, $idContattoFatt)";
    if ($conn->query($sqlFatturazione) == TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sqlIdFatt = "SELECT max(id) AS id FROM dati_fatturazione";
    $result = $conn->query($sqlIdFatt);
    while ($row = $result->fetch_assoc()) {
        $idFatt = $row["id"];
    }

    $sqltabellafatt = "INSERT INTO fattDatiPersona (id_datiFatt, id_personaRiferita)
    VALUES ($idFatt, $idPers)";
    if ($conn->query($sqltabellafatt) == TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $_SESSION["codFiscale"] = $codFiscale;
    header("Location: ../PAGES/resultResearch.php");
}

header("Location: ../PAGES/player.php");
