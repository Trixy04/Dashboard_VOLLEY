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

$status = "";

$codiceFiscale = $_GET["cf"];
$qualifica = 1;

$sqlCategorie = "SELECT * FROM categorie";
$result = $conn->query($sqlCategorie);
while ($row = $result->fetch_assoc()) {
    $idCat = $row["id"];
    $option = "<option value=$id> " . $row["categoria"] . "</option>";
}


$sqlCategorie = "SELECT * FROM categorie";
$result = $conn->query($sqlCategorie);
while ($row = $result->fetch_assoc()) {
    $idCat = $row["id"];
    $option = "<option value=$id> " . $row["categoria"] . "</option>";
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
    <title>INSERIMENTO COACH</title>
</head>

<body onload="nascondiDIV('fatturaDIV')">

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
        <nav class="navbar navbar-expand-lg mb-0">
            <div class="container-fluid">
                <a class="navbar-brand font-15" href="#">SAVINO DEL BENE VOLLEY</a>
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

        <ul class="nav nav-tabs tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Anagrafica</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#certificato">Cartellino</a>
            </li>
        </ul>

        <i>
            <p class=" mt-1" style="margin-left: 14px; margin-right:14px;">Ricorda, in questa pagina andrai a inserire un nuovo allenatore, successivamente dalla pagina di gestione delle squadre lo potrai associare a una o più squadre</p>
        </i>


        <form class="tabs mt-3" method="POST" action="../CONFIG/insertCoach.php">
            <p class="mb-0" style="opacity: 0.7;">Dati anagrafici:</p>
            <div class="div-border">
                <div class="div-left-anag">
                    <div class="row mb-3">
                        <label for="" class="col-sm-2 col-form-label">Cognome:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="cognome" name="cognome" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nato il:</label>
                        <div class="col-sm-10">
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control w-35 ml-5" id="dataNascita" name="dataNascita">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nato a:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="luogoNascita" name="luogoNascita" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tipo:</label>
                        <div class="col-sm-10">
                            <select class="form-select w-25 ml-5" aria-label="Default select example" id="tipoVia" name="tipoVia" required>
                                <?php
                                $sqlCategorie = "SELECT * FROM tipoVia";
                                $result = $conn->query($sqlCategorie);
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["id"];
                                    echo "<option value=$id> " . $row["tipologia"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">CAP:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="cap" name="cap" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Città:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="citta" name="citta" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">C.F:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="codiceFiscale" name="codiceFiscale" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tel. 1:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="tel1" name="tel1" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">E-mail:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="email" name="email" required>
                        </div>
                    </div>

                </div>
                <div class="div-right-anag">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Titolo:</label>
                        <div class="col-sm-10">
                            <select class="form-select w-25 ml-5" aria-label="Default select example" id="titolo" name="titolo" required>
                                <?php
                                $sqlCategorie = "SELECT * FROM titolo";
                                $result = $conn->query($sqlCategorie);
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["id"];
                                    echo "<option value=$id> " . $row["titolo"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nome:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="nome" name="nome" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Provincia:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-15 ml-5" id="provinciaNascita" name="provinciaNascita" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Indirizzo:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="indirizzo" name="indirizzo" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Civico:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-15 ml-5" id="civico" name="civico" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Provincia:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-15 ml-5" id="provincia" name="provincia" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Documento:</label>
                        <div class="col-sm-10">
                            <select class="form-select w-35 ml-5" aria-label="Default select example" name="tipoDoc" required>
                                <?php
                                $sqlCategorieCert = "SELECT * FROM tipologiaDocumento";
                                $result = $conn->query($sqlCategorieCert);
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["id"];
                                    echo "<option value=$id> " . $row["tipologia"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">N°Doc:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="documento" name="documento" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Sesso:</label>
                        <div class="col-sm-10">
                            <div class="form-check-inline  ml-5 mt-1">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Maschio
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Femmina
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="div-photo-right div-border">
                <center>
                    <img src="../UPLOADS/UPLOADS_PHOTO/01.png" alt="">
                </center>
            </div>
            <a name="certificato">
                <p class="mb-0 text-re" style="opacity: 0.7;">Dati cartellino:</p>
            </a>

            <div class="div-border">
                <div class="div-left-certificato mb-2">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Qualifica:</label>
                        <div class="col-sm-10">
                            <select class="form-select w-35 ml-5" aria-label="Default select example" name="tipoCert" required>
                                <?php
                                $sqlCategorieCert = "SELECT * FROM qualificaFipav";
                                $result = $conn->query($sqlCategorieCert);
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row["id"];
                                    echo "<option value=$id> " . $row["qualificaFipav"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Numero:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="numeroCert" name="numeroCert" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Scadenza:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control w-35 ml-5" id="scadenzaDocumento" name="scadenzaDocumento" required>
                        </div>
                    </div>
                </div>


                <div class="div-right-note">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Rilasciato:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control w-35 ml-5" id="dataVisita" name="dataVisita" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Comitato:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="dottore" name="dottore" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">S.Coach:</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch ml-5 mt-1">
                                <input class="form-check-input" type="checkbox" role="switch" name="siSmart" id="siSmart" value="1" <?php echo $status ?>>
                                <label class="form-check-label" for="flexSwitchCheckDefault">In possesso</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <center>
                <button class="btn w-100 btn-success backBlue mb-5 mt-3">INSERISCI</button>
            </center>
    </div>

    </form>
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
    <script src="../JS/main.js"></script>

</body>

</html>