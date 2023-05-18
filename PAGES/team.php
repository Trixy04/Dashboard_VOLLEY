<?php
session_start();
include("../CONFIG/config.php");
include("../CONFIG/function.php");
$dataOdierna = date("Y-m-d");

if (!isset($_SESSION["nominativo"])) {
    header("Location: ../index.php");
}

if (isset($_GET["name"])) {
    deleteSession();
}

if (isset($_GET["add"]) && $_GET["add"] == 'true') {
    addEvent();
}

$sqlGiocatori = "SELECT S.id AS id, S.nome AS nome, P1.nome AS nomePrimo, P1.cognome AS cognomePrimo, P2.nome AS nomeSecondo, P2.cognome AS cognomeSecondo, Stag.annoInizio AS inizio, Stag.annoFine AS fine FROM squadra AS S
JOIN allenatore AS A1 ON A1.id = S.id_I_allenatore
JOIN allenatore AS A2 ON A2.id = S.id_II_allenatore
JOIN persona AS P1 ON P1.cod_utente = A1.id_persona
JOIN persona AS P2 ON P2.cod_utente = A2.id_persona
JOIN stagioniSportive AS Stag ON Stag.id = S.id_stagioneSportiva
ORDER BY id";

$result = $conn->query($sqlGiocatori);
$tabella_giocatori = "";
while ($row = $result->fetch_assoc()) {
    /*
    $cf = $row["codFiscale"];
    */
    //$dataS = $row["scadenza"];
    
    //$timestamp_dataN = strtotime($dataS);
    //$formato = 'd/m/Y';
    //$resultDateS = date($formato, $timestamp_dataN);

    $id = $row["id"];

    $tabella_giocatori .= "<tr valign='middle'>
    <td>" . $row["id"] . "</td>
    <td> " . $row["nome"] . "</td>
    <td> " . $row["cognomePrimo"] . " " . $row["nomePrimo"] . "</td>
    <td> " . $row["cognomeSecondo"] . " " . $row["nomeSecondo"] . "</td>
    <td> " . $row["inizio"] . "/" . $row["fine"] . "</td>
    <td><a href='generateTeam.php?squadra=$id'><button class='btn btn-success'><i class='bi bi-eye-fill'></i></button></a></td>
    <td><a href='generateTeam.php?squadra=$id'><button class='btn btn-danger'><i class='bi bi-trash3-fill'></i></button></a></td>
    </tr>";
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
    <title>SQUADRE</title>
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

        <div class="div-utenti radius-bord border">
            <i>
                <h5 class="text-center mt-3">Squadre della <?php
                                                            $nome = recuperaDatiSocieta();
                                                            echo $nome;
                                                            ?></h5>
            </i>
            <center>
                <button type="button" class="btn btn-primary text-white backBlue mt-2 b-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Inserisci
                </button>
                <table class="table mt-5 w-85">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">I° All.</th>
                            <th scope="col">II° All.</th>
                            <th scope="col">Stagione Sportiva</th>
                            <th scope="col"></th>
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
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Scegli modalità di inserimento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Nome:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control w-35 ml-5" id="cognome" name="cognome" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">I° All.</label>
                            <div class="col-sm-10">
                            <select class="form-select w-35 ml-5" aria-label="Default select example" name="idPersona" required>
                                <?php
                                $sqlCategorieCert = "SELECT P.* FROM persona AS P
                                WHERE P.cod_utente IN (SELECT id_persona FROM allenatore)";
                                $result = $conn->query($sqlCategorieCert);
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["cod_utente"];
                                    echo "<option value=$id> " . $id . " - " . $row["cognome"] ." " . $row["nome"] . "</option>";
                                }
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">II° All.</label>
                            <div class="col-sm-10">
                            <select class="form-select w-35 ml-5" aria-label="Default select example" name="idPersona" required>
                                <?php
                                $sqlCategorieCert = "SELECT P.* FROM persona AS P
                                WHERE P.cod_utente IN (SELECT id_persona FROM allenatore)";
                                $result = $conn->query($sqlCategorieCert);
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["cod_utente"];
                                    echo "<option value=$id> " . $id . " - " . $row["cognome"] ." " . $row["nome"] . "</option>";
                                }
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">Stagione:</label>
                            <div class="col-sm-10">
                            <select class="form-select w-35 ml-5" aria-label="Default select example" name="idPersona" required>
                                <?php
                                $sqlSport = "SELECT S.* FROM stagioniSportive AS S";
                                $result = $conn->query($sqlSport);
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["id"];
                                    echo "<option value=$id> " . $row["annoInizio"] ."/" . $row["annoFine"] . "</option>";
                                }
                                ?>
                            </select>
                            </div>
                        </div>
                        <center>
                        <button type="button" class="btn backBlue btn-light text-light" >Inserisci</button>
                        </center>
                    </form>

                </div>
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