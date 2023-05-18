<?php
session_start();
include("config.php");
include("function.php");

$idPersona = $_GET["idPersona"];

$sql = "SELECT P.nome AS nome, P.cognome AS cognome, P.cod_fiscale AS CF, P.data_nascita AS dataNascita, P.luogo_nascita AS luogoNascita, T.titolo AS titolo, C.cellulare AS cell, C.email AS email FROM persona AS P
JOIN contatto AS C ON C.id = P.id_contatti
JOIN titolo AS T ON T.id = P.id_titolo
WHERE P.cod_utente = $idPersona";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $nome = $row["nome"];
    $cognome = $row["cognome"];
    $dataNascita = $row["dataNascita"];
    $luogoNascita = $row["luogoNascita"];
    $titolo = $row["titolo"];
    $codFiscale = $row["CF"];
    $cellulare = "+39" . $row["cell"];
    $email = $row["email"];
}

$username = strtolower($cognome) . "." . strtolower($nome);

$research = "SELECT email, password FROM userData
WHERE email = '$username'";
$result = $conn->query($research);
$row = $result->fetch_assoc();
if ($row == 0) {

    $pw = generateRandomString();

    $bodyMessage = $titolo . " " . $cognome . " "
        . $nome . ", \r\n" . "Cod. Fiscale: " . $codFiscale . ", \r\n"
        . "Data Nascita: " . $dataNascita . ", \r\n" . "Luogo Nascita: "
        . $luogoNascita . ", \r\n" . "Cellulare: " . $cellulare . ", \r\n"
        . "Email: " . $email . "\r\n" .
        "di seguito trova username e password per poter accedere alla sua anagrafica" . ", \r\n" . "\r\n" .
        "Username: " . $username . "\r\n" .
        "Password: " . $pw . "\r\n" . "\r\n" .
        "se dovessero esseci problemi risponda pure a questo messaggio!";

    $sqlInsert = "INSERT INTO userdata (nome, cognome, email, password, type)
VALUES('$nome', '$cognome', '$username', '$pw', 1)";

    if ($conn->query($sqlInsert) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $_SESSION["cell"] = $cellulare;
    $_SESSION["body"] = $bodyMessage;
    $_SESSION["page"] = "home";

    header("Location: ../API/sendWhatsapp.php");
} else {

    $research = "SELECT email, password FROM userData
    WHERE email = '$username'";
    $result = $conn->query($research);
    while ($row = $result->fetch_assoc()) {
        $pw = $row["password"];
    }

    $bodyMessage = $titolo . " " . $cognome . " "
        . $nome . ", \r\n" . "Cod. Fiscale: " . $codFiscale . ", \r\n"
        . "Data Nascita: " . $dataNascita . ", \r\n" . "Luogo Nascita: "
        . $luogoNascita . ", \r\n" . "Cellulare: " . $cellulare . ", \r\n"
        . "Email: " . $email . "\r\n" .
        "di seguito trova username e password per poter accedere alla sua anagrafica" . ", \r\n" . "\r\n" .
        "Username: " . $username . "\r\n" .
        "Password: " . $pw . "\r\n" . "\r\n" .
        "se dovessero esseci problemi risponda pure a questo messaggio!";

    $_SESSION["cell"] = $cellulare;
    $_SESSION["body"] = $bodyMessage;

    header("Location: ../API/sendWhatsapp.php");
}
