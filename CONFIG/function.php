<?php


function deleteSession()
{
    session_start();
    session_destroy();
    header("Location: ../index.php");
}

function addEvent()
{
    include("config.php");
    include("../CONFIG/config.php");
    $titolo = $_POST["titolo"];
    $descrizione = $_POST["descrizione"];
    $dataScadenza = $_POST["datascadenza"];
    $autore = $_SESSION["nominativo"];
    $dataCreazione = date("Y/m/d");

    $sql = "INSERT INTO agenda (dataIns, dataScad, textMess, autore, titolo)
    VALUES ('$dataCreazione', '$dataScadenza', '$descrizione', '$autore', '$titolo')";
    if (mysqli_query($conn, $sql)) {
        /* Refer to the PHP quickstart on how to setup the environment:

        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Google I/O 2015',
            'location' => '800 Howard St., San Francisco, CA 94103',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
                'dateTime' => '2015-05-28T09:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ),
            'end' => array(
                'dateTime' => '2015-05-28T17:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ),
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
            ),
            'attendees' => array(
                array('email' => 'lpage@example.com'),
                array('email' => 'sbrin@example.com'),
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        printf('Event created: %s\n', $event->htmlLink);
*/
        header("Location: home.php?add=false");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function search($cf)
{
    include("config.php");
    $sqlGiocatori = "SELECT P.data_nascita AS dataNascita, P.cod_utente AS id, P.cod_fiscale AS codFiscale, P.nome AS nome, P.cognome AS cognome, S.nome AS squadra, GR.num_maglia AS maglia FROM gioca AS G
    JOIN giocatore AS GR ON G.id_giocatore = GR.id
    JOIN persona AS P ON GR.id_persona = P.cod_utente
    JOIN contatto AS C ON C.id = P.id_contatti
    JOIN squadra AS S ON G.id_squadra = S.id
    WHERE codFiscale = '$cf'";

    $result = $conn->query($sqlGiocatori);
    $tabella_risultato = "";
    if ($result > 0) {
        while ($row = $result->fetch_assoc()) {
            $dataN = $row["dataNascita"];
            $timestamp_dataN = strtotime($dataN);
            $formato = 'd/m/Y';
            $resultDateN = date($formato, $timestamp_dataN);

            $tabella_risultato .= "<tr>
            <td>" . $row["id"] . "</td>
            <td> " . $row["codFiscale"] . "</td>
            <td> " . $row["cognome"] . "</td>
            <td> " . $row["nome"] . "</td>
            <td> " . $resultDateN . "</td>
            <td> " . $row["maglia"] . "</td>
            <td> " . $row["squadra"] . "</td>
            </tr>";

            header("Location: ../PAGES/home.php?openModal=true");
        }
    }
}

function recuperaDatiSocieta()
{
    include("config.php");
    $sqlSocieta = "SELECT * FROM dati_Societa";
    $result = $conn->query($sqlSocieta);
    while ($row = $result->fetch_assoc()) {
        $nome =  $row["nome_legale"];
    }

    return $nome;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
