<?php
session_start();
include("config.php");

$formato = 'Y-m-d';
$numCartellino = $_POST["numeroCert"];

$dataSc = strtotime($_POST["scadenzaDocumento"]);
$dataScCart = date($formato, $dataSc);

$dataE = strtotime($_POST["dataVisita"]);
$dataRilascio = date($formato, $dataE);

$dataCreazione = date("Y-m-d");

$comitato = $_POST["dottore"];
$idQualifica = $_POST["tipoCert"];

if (isset($_POST["siSmart"])) {
    $smartCoach = 1;
} else {
    $smartCoach = 0;
}

$persona = $_POST["idPersona"];


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

//INSERIMENTO ALLENATORE
$sqlGiocatore = "INSERT INTO allenatore (id_persona, id_cartellino, smartcoach)
VALUES($persona, $idCart, $smartCoach)";
if ($conn->query($sqlGiocatore) == TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$_SESSION["coach"] = $codFiscale;
header("Location: ../PAGES/showCoach.php");


