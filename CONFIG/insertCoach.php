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
$tipoDoc = $_POST["tipoDoc"];

$numCartellino = $_POST["numeroCert"];

$dataSc = strtotime($_POST["scadenzaDocumento"]);
$dataScCart = date($formato, $dataSc);

$dataE = strtotime($_POST["dataVisita"]);
$dataRilascio = date($formato, $dataE);

$dataCreazione = date("Y-m-d");

$comitato = $_POST["dottore"];
$idQualifica = $_POST["tipoCert"];


$sesso = $_POST["flexRadioDefault"];


if (isset($_POST["siSmart"])) {
    $smartCoach = 1;
} else {
    $smartCoach = 0;
}

$codFiscale = $_POST["codiceFiscale"];



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

//INSERIMENTO CARTELLINO
$sqlCertificato = "INSERT INTO cartellino(numeroCartellino, dataScadenza, dataRilascio, comitatoRilascio, id_qualifica)
VALUES('$numCartellino', '$dataScCart', '$dataRilascio', '$comitato', $idQualifica);";
if ($conn->query($sqlCertificato) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sqlCert = "SELECT max(id) AS id FROM cartellino";
$result = $conn->query($sqlCert);
while ($row = $result->fetch_assoc()) {
    $idCart = $row["id"];
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

//INSERIMENTO ALLENATORE
$sqlGiocatore = "INSERT INTO allenatore (id_persona, id_cartellino, smartcoach)
VALUES($idPers, $idCart, $smartCoach)";
if ($conn->query($sqlGiocatore) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$_SESSION["coach"] = $codFiscale;
header("Location: ../PAGES/showCoach.php");

