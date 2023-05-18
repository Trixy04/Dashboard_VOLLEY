
<?php
session_start();
include("../CONFIG/config.php");
include("../CONFIG/function.php");
include("../API/googleConnect.php");

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

$sqlDirigenti = "SELECT COUNT(*) AS tot FROM `squadra`";
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

$sqlAgenda = "SELECT date, title, time_from, time_to FROM `events` WHERE date >= '$dataOdierna' ORDER BY date";

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
        <td> " . $row["time_from"] . "</td>
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
        <td> " . $row["time_from"] . "</td>
        <td>
        <button type='button' class='btn p-0' data-bs-toggle='modal' data-bs-target='#exampleModal2'>
        <img src='../ICON/eye-fill.svg'>
        </button>
        </td>
        </tr>";
    }
    $i++;
    if ($i == 9) {
        break;
    }
}


$sqlCertificatiScadenza = "SELECT DISTINCT COUNT(C.id) AS tot FROM certificato AS C
WHERE C.dataScadenza <= '$dataOdierna' OR C.dataScadenza < '$dataPiu'
";

$result = $conn->query($sqlCertificatiScadenza);

while ($row = $result->fetch_assoc()) {
    $totCertificati = $row["tot"];
}

$postData = ''; 
if(!empty($_SESSION['postData'])){ 
    $postData = $_SESSION['postData']; 
    unset($_SESSION['postData']); 
} 
 
$status = $statusMsg = ''; 
if(!empty($_SESSION['status_response'])){ 
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status']; 
    $statusMsg = $status_response['status_msg']; 
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
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
            $conn = null;
            ?>
            
        </div>
        <a href="accessi.php" class="over"><i class="bi bi-universal-access-circle mr-4"></i>Gest. accessi</a>
        <a href="certificati.php" class="over"><i class="bi bi-gear-fill mr-4"></i>Impostazioni</a>
        <a href="home.php?name=true" style="position: relative; bottom:-46%; color: red;" class="over"><i class="bi bi-box-arrow-left mr-4"></i>Logout</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand font-15" href="#"><?php echo strtoupper(recuperaDatiSocieta()) ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <div class="dropdown-center">
                            <a class="dropdown-toggle nav-link" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
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

        <div class="container ">
            <div class="row">
                <div class="col">
                    <div class="card radius-bord" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    fill="currentColor" class="bi bi-people-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>TOT. Atleti</h5>
                            <p class="card-text fs-3"><?php echo $tot_atleti ?></p>
                            <a href="player.php" class="btn btn-primary"
                                style="background-color: #012E63; border: 0px solid white">Vai alla sezione atleti</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-bord" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    fill="currentColor" class="bi bi-people-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>TOT. Allenatori</h5>
                            <p class="card-text fs-3"><?php echo $tot_allenatori ?></p>
                            <a href="coach.php" class="btn btn-primary"
                                style="background-color: #012E63; border: 0px solid white">Vai alla sezione
                                allenatori</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-bord" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    fill="currentColor" class="bi bi-people-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>TOT. Squadre</h5>
                            <p class="card-text fs-3"><?php echo $tot_dirigenti ?></p>
                            <a href="team.php" class="btn btn-primary"
                                style="background-color: #012E63; border: 0px solid white">Vai alla sezione squadre</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-bord" style="width: 18rem; ">
                        <div class="card-body">
                            <h5 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                    fill="currentColor" class="bi bi-people-fill mr-2" viewBox="0 0 16 16">
                                    <path
                                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                </svg>Certificati in scadenza</h5>
                            <p class="card-text fs-3"><?php echo $totCertificati ?></p>
                            <a href="certificati.php" class="btn btn-primary"
                                style="background-color: #012E63; border: 0px solid white">Visualizza certficati</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="div-agenda radius-bord border">
            <i>
                <h5 class="text-center mt-3">Impegni in scandeza agenda<button
                        style="background-color: #012E63; border: 0px solid white" type="button"
                        class="btn btn-success ml-5" data-bs-toggle="modal" data-bs-target="#exampleModal"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus" viewBox="0 0 16 16">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                        </svg></button></h5>


            </i>
            <center>
                <table class="table mt-3 w-85">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Data Scadenza</th>
                            <th scope="col">Impegno</th>
                            <th scope="col">H inizio</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $tabella_agenda; ?>
                    </tbody>
                </table>
            </center>
        </div>

        <div class="div-calendar radius-bord border ">
            <i>
                <h5 class="text-center mt-3">Calendario</h5>
            </i>
            <center>
                <iframe
                    src="https://calendar.google.com/calendar/embed?src=teriaca.mattia%40gmail.com&ctz=Europe%2FRome"
                    style="border-width:0" width="90%" height="400" frameborder="0" scrolling="no"
                    class="mb-3"></iframe>
            </center>
        </div>

        <div class="div-utenti radius-bord border">
            <i>
                <h5 class="text-center mt-3">Ultimi giocatori inseriti</h5>
            </i>
            <center>
                <form class="d-flex w-50" action="resultResearch.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Cerca per codice fiscale"
                        aria-label="Search" name="cf">
                    <button class="btn btn-outline-success" type="submit">Cerca</button>
                </form>
                <table class="table mt-3 w-85">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cod. Fiscale</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data nascita</th>
                            <th scope="col">N° maglia</th>
                            <th scope="col">Squadra</th>
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
            <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Inserisci un nuovo impegno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="../API/addEvent.php" class="form">
        <div class="form-group">
            <label>Event Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo !empty($postData['title'])?$postData['title']:''; ?>" required="">
        </div>
        <div class="form-group">
            <label>Event Description</label>
            <textarea name="description" class="form-control"><?php echo !empty($postData['description'])?$postData['description']:''; ?></textarea>
        </div>
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="<?php echo !empty($postData['location'])?$postData['location']:''; ?>">
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" value="<?php echo !empty($postData['date'])?$postData['date']:''; ?>" required="">
        </div>
        <div class="form-group time">
            <label>Time</label>
            <input type="time" name="time_from" class="form-control" value="<?php echo !empty($postData['time_from'])?$postData['time_from']:''; ?>">
            <span>To</span>
            <input type="time" name="time_to" class="form-control mb-3" value="<?php echo !empty($postData['time_to'])?$postData['time_to']:''; ?>">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn-colorBlue text-light" name="submit" value="Inserisci evento"/>
        </div>
    </form>
            </div>
        </div>
    </div>

    <!-- Modal 2 -->
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="../JS/jquery.min.js"></script>



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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

</body>

</html>