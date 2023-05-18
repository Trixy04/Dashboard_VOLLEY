<?php
session_start();
include("../CONFIG/config.php");

if (!isset($_SESSION["nominativo"])) {
    header("Location: ../index.php");
}

if (isset($_GET["name"])) {
    deleteSession();
}

if (isset($_GET["add"]) && $_GET["add"] == 'true') {
    addEvent();
}

$squadra = $_GET["squadra"];

$sqlAtleti = "SELECT COUNT(*) AS tot FROM `giocatore`";
$result = $conn->query($sqlAtleti);

while ($row = $result->fetch_assoc()) {
    $tot_atleti = $row["tot"];
}

$sqlDirigenti = "SELECT COUNT(*) AS tot FROM `dirigente`";
$result = $conn->query($sqlDirigenti);

while ($row = $result->fetch_assoc()) {
    $tot_dirigenti = $row["tot"];
}

$sqlAllenatori = "SELECT COUNT(*) AS tot FROM `allenatore`";
$result = $conn->query($sqlAllenatori);

while ($row = $result->fetch_assoc()) {
    $tot_allenatori = $row["tot"];
}

$sqlSquadre = "SELECT id, nome FROM `squadra`";
$result = $conn->query($sqlSquadre);
$tabella_squadra = "";
while ($row = $result->fetch_assoc()) {
    $tabella_squadra .= "<tr>
    <td>" . $row["id"] . "</td>
    <td> " . $row["nome"] . "</td>
    </tr>";
}

$sqlGiocatori = "SELECT P.data_nascita AS nascita, P.cod_utente AS id, P.cod_fiscale AS codFiscale, P.nome AS nome, P.cognome AS cognome, S.nome AS squadra, GR.num_maglia AS numero FROM gioca AS G
JOIN giocatore AS GR ON G.id_giocatore = GR.id
JOIN persona AS P ON GR.id_persona = P.cod_utente
JOIN contatto AS C ON C.id = P.id_contatti
JOIN squadra AS S ON G.id_squadra = S.id
WHERE S.id = '$squadra'";

$result = $conn->query($sqlGiocatori);
$tabella_giocatori = "";
while ($row = $result->fetch_assoc()) {
    $cf = $row["codFiscale"];
    $tabella_giocatori .= "<tr valign='middle'>
    <td>" . $row["id"] . "</td>
    <td> " . $row["codFiscale"] . "</td>
    <td> " . $row["cognome"] . "</td>
    <td> " . $row["nome"] . "</td>
    <td> " . $row["nascita"] . "</td>
    <td> " . $row["numero"] . "</td>
    <td><a href='resultResearch.php?cf=$cf'><button class='btn btn-success'>Show</button></a></td>
    </tr>";
}


$sqlAgenda = "SELECT dataScad, titolo, autore FROM `agenda` ORDER BY dataScad";
$result = $conn->query($sqlAgenda);
$tabella_agenda = "";
$i = 1;
while ($row = $result->fetch_assoc()) {

    $data = $row["dataScad"];
    $timestamp_data = strtotime($data); // Formato della data che voglio ottenere in uscita dalla funzione date()
    $formato = 'd/m/Y';
    $resultDate = date($formato, $timestamp_data);

    $tabella_agenda .= "<tr>
    <td>" . $i . "</td>
    <td>" . $resultDate . "</td>
    <td>" . $row["titolo"] . "</td>
    <td> " . $row["autore"] . "</td>
    </tr>";
    $i++;
    if ($i == 9) {
        break;
    }
}


function deleteSession()
{
    session_start();
    session_destroy();
    header("Location: ../index.php");
}

function addEvent()
{
    include("../CONFIG/config.php");
    $titolo = $_POST["titolo"];
    $descrizione = $_POST["descrizione"];
    $dataScadenza = $_POST["datascadenza"];
    $autore = $_SESSION["nominativo"];
    $dataCreazione = date("Y/m/d");

    $sql = "INSERT INTO agenda (dataIns, dataScad, textMess, autore, titolo)
    VALUES ('$dataCreazione', '$dataScadenza', '$descrizione', '$autore', '$titolo')";
    if (mysqli_query($conn, $sql)) {
        header("Location: home.php?add=false");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css" type="text/css">
    <title>HOME</title>
</head>

<body>

<div class="sidebar">
        <center><img src="../ICON/LOGO.png" alt="Bootstrap" width="80" height="80" class="mt-3"></center>

        <a href="home.php" class="over"><i class="bi bi-house-fill mr-4"></i>Home</a>
        <a href="player.php" class="over"><i class="bi bi-people-fill mr-4"></i>Atleti</a>
        <a href="coach.php" class="over"><i class="bi bi-person-vcard-fill mr-4"></i>Allenatori</a>
        <a href="agenda.php" class="over"><i class="bi bi-calendar mr-4"></i>Agenda</a>
        <a href="certificati.php" class="over"><i class="bi bi-file-earmark-binary-fill mr-4"></i>Certificati</a>
        <button class="dropdown-btn"><i class="bi bi-microsoft-teams mr-4"></i>Squadre
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <?php
            $sqlTeam = "SELECT nome, id FROM `squadra`";
            $result = $conn->query($sqlTeam);
            echo "<a class='over' href='team.php'>Gestisci squadre</a>";
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $nome = $row["nome"];
                echo "<a class='over' href='generateTeam.php?squadra=$id'>$nome</a>";
            }
            
            ?>
        </div>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand font-15" href="#">PALLAVOLO SESTESE A.S.D</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <div class="dropdown-center">
                            <a class="dropdown-toggle nav-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION["nominativo"] ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Gestisci profilo</a></li>
                                <li><a class="dropdown-item" href="#">Action two</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="home.php?name=true">Logout</a></li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="div-utentiGenerate radius-bord border">
            
            <center>

              <h5 class="mt-3 ml-5 w-50">Giocatori <?php 
              
              $sqlNome = "SELECT nome FROM squadra WHERE id = $squadra";
              $result = $conn->query($sqlNome);
              while ($row = $result->fetch_assoc()) {
                echo $row["nome"];
              }
              ?>
              </h5>
              
                <table class="table table-striped mt-3 w-85">
                    <thead>
                        <tr>
                            <th scope="col">N° utente</th>
                            <th scope="col">Cod. Fiscale</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data nascita</th>
                            <th scope="col">N° maglia</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $tabella_giocatori; ?>
                    </tbody>
                </table>
            </center>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserisci un nuovo impegno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="home.php?add=true" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Titolo evento</label>
                            <input type="text" class="form-control" name="titolo" id="formGroupExampleInput" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Descrizione</label>
                            <textarea class="form-control" name="descrizione" id="exampleFormControlTextarea1" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="active form-label" for="dateStandard">Data Scadenza</label>
                            <input type="date" id="dateStandard" name="datascadenza">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>