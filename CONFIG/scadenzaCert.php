<?php
session_start();
include("config.php");
include("function.php");

$idPersona = $_GET["idPersona"];

$sql = "SELECT C.numeroCertificato AS numero, C.dataScadenza AS scadenza, C.dottore AS dottore, P.cod_fiscale AS codFiscale, C.id AS id, P.nome AS nome, P.cognome AS cognome, P.cod_utente AS codUtente, T.titolo AS titolo, CC.cellulare AS cell FROM giocatore AS G
JOIN certificato AS C ON G.id_certificato = C.id
JOIN persona AS P ON P.cod_utente = G.id_persona
JOIN titolo AS T ON P.id_titolo = T.id
JOIN contatto AS CC ON CC.id = P.id_contatti
ORDER BY cognome";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $nome = $row["nome"];
    $cognome = $row["cognome"];
    $titolo = $row["titolo"];
    $cellulare = "+39" . $row["cell"];
    $certificatoNumero = $row["numero"];
    $scadenza = $row["scadenza"];
    $codFiscale = $row["codFiscale"];
}

$bodyMessage = $titolo . " " . $cognome . " "
    . $nome . ", \r\n" . "Cod. Fiscale: " . $codFiscale . ", \r\n" .
    "le stiamo inviando questo messaggio in quanto il suo certificato sportivo, con codice: " . $certificatoNumero . " è in scadenza o è scaduto, per tanto la invitiamo a provvedere quanto prima. Dopo aver effettutato la visita porti il certificato in originale alla nostra segretaria." . "\r\n" . "\r\n" .
    "Cordialmente" . "\r\n" . "\r\n" . "Savino del Bene Volley";


$_SESSION["cell"] = $cellulare;
$_SESSION["body"] = $bodyMessage;
$_SESSION["page"] = "cert";


header("Location: ../API/sendWhatsapp.php");
