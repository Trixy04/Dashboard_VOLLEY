<?php
session_start();
include("../CONFIG/config.php");
include("../CONFIG/function.php");
$dataOdierna = date("Y-m-d");

$dataUnMese = new DateTime($dataOdierna);
$interval = new DateInterval("P1M");
$dataUnMese->add($interval);
$dataPiu = $dataUnMese->format("Y-m-d");

if (!isset($_SESSION["nominativo"])) {
    header("Location: ../index.php");
}

if (isset($_GET["name"])) {
    deleteSession();
}

if (isset($_GET["add"]) && $_GET["add"] == 'true') {
    addEvent();
}

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
    $name = $row["nome"];
    $tabella_squadra .= "<tr>
    <td>" . $row["id"] . "</td>
        <td><a href='generateTeam.php?squadra=$name'>" . $row["nome"] . "</a></td>
    </tr>";
}

$sqlGiocatori = "SELECT P.data_nascita AS dataNascita, P.cod_utente AS id, P.cod_fiscale AS codFiscale, P.nome AS nome, P.cognome AS cognome, S.nome AS squadra, GR.num_maglia AS maglia FROM gioca AS G
JOIN giocatore AS GR ON G.id_giocatore = GR.id
JOIN persona AS P ON GR.id_persona = P.cod_utente
JOIN contatto AS C ON C.id = P.id_contatti
JOIN squadra AS S ON G.id_squadra = S.id";

$result = $conn->query($sqlGiocatori);
$tabella_giocatori = "";
while ($row = $result->fetch_assoc()) {

    $dataN = $row["dataNascita"];
    $timestamp_dataN = strtotime($dataN);
    $formato = 'd/m/Y';
    $resultDateN = date($formato, $timestamp_dataN);

    $tabella_giocatori .= "<tr>
    <td>" . $row["id"] . "</td>
    <td> " . $row["codFiscale"] . "</td>
    <td> " . $row["cognome"] . "</td>
    <td> " . $row["nome"] . "</td>
    <td> " . $resultDateN . "</td>
    <td> " . $row["maglia"] . "</td>
    <td> " . $row["squadra"] . "</td>
    </tr>";
}

$sqlCertificatiScadenza = "SELECT COUNT(C.id) AS tot FROM certificato AS C
WHERE C.dataScadenza > '$dataOdierna' AND C.dataScadenza < '$dataPiu'";

$result = $conn->query($sqlCertificatiScadenza);

while ($row = $result->fetch_assoc()) {
    $totCertificati = $row["tot"];
}

$sqlAgenda = "SELECT date, description, location, title, time_from, time_to FROM `events` WHERE date >= '$dataOdierna' ORDER BY date";

$result = $conn->query($sqlAgenda);
$tabella_agenda = "";
$i = 1;
while ($row = $result->fetch_assoc()) {

    $data = $row["date"];
    $timestamp_data = strtotime($data); // Formato della data che voglio ottenere in uscita dalla funzione date()
    $resultDate = date($formato, $timestamp_data);

    if ($data == $dataOdierna) {
        $tabella_agenda .= "
        
        <tr style='background-color: #FF5733; color: white; font-style: italic;'>
        <td>" . $i . "</td>
        <td><b>" . $resultDate . "</b></td>
        <td>" . $row["title"] . "</td>
        <td>" . $row["description"] . "</td>
        <td>" . $row["location"] . "</td>
        <td> " . $row["time_from"] . "</td>
        <td> " . $row["time_to"] . "</td>
        <td>
        <button type='button' class='btn p-0' data-bs-toggle='modal' data-bs-target='#exampleModal2'>
        <img src='../ICON/eye-fill.svg'>
        </button>
        </td>
        </tr>

    ";
    } else {
        $tabella_agenda .= "<tr>
        <td>" . $i . "</td>
        <td>" . $resultDate . "</td>
        <td>" . $row["title"] . "</td>
        <td>" . $row["description"] . "</td>
        <td>" . $row["location"] . "</td>
        <td> " . $row["time_from"] . "</td>
        <td> " . $row["time_to"] . "</td>
        <td>
        <button type='button' class='btn p-0' data-bs-toggle='modal' data-bs-target='#exampleModal2'>
        <img src='../ICON/eye-fill.svg'>
        </button>
        </td>
        </tr>";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css" type="text/css">
    <title>AGENDA</title>
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
            $conn = null;
            ?>
        </div>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand font-15" href="#"><?php echo strtoupper(recuperaDatiSocieta()) ?></a>
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



        <div class="div-calendar-page radius-bord border ">
            <i>
                <h5 class="text-center mt-3">Agenda</h5>
            </i>
            <center>
                <iframe src="https://calendar.google.com/calendar/embed?src=teriaca.mattia%40gmail.com&ctz=Europe%2FRome" style="border-width:0" width="90%" height="500" frameborder="0" scrolling="no" class="mb-3"></iframe>
            </center>
        </div>

        <center><i><h5 class="mt-3">Impengi futuri</h5></i></center>

        <div class="radius-bord border div-calendar-page mb-5">
            <center>
            <table class="table mt-3 w-85">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Data Scadenza</th>
                        <th scope="col">Impegno</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Location</th>
                        <th scope="col">H inizio</th>
                        <th scope="col">H fine</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $tabella_agenda; ?>
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
                        <input type="submit" class="btn btn-success" style="background-color: #012E63;">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <center>
                        <h5 class="modal-title text-center" id="exampleModalLabel">ALERT</h5>
                    </center>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <center><img src="../ICON/danger.svg" alt="" width="70" height="70"></center>
                <h3 class="text-center mt-3">FUNZIONE NON DISPONIBILE AL MOMENTO</h3>
            </div>
        </div>
    </div>

    <script>
        var dropdown = document.getElementsByClassName("dropdown-btn");
        var i;

        for (i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>