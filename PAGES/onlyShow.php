<?php

use function PHPSTORM_META\exitPoint;

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

$status = "disabled";
$statusShow = "none";

if (isset($_GET["id"]))
    $id = $_GET["id"];
else
    $id = $_SESSION["id"];



$sqlGiocatore = "SELECT 

P.provinciaNascita AS pNascita, P.luogo_nascita AS luogo, P.cod_utente AS codUtente, P.data_nascita AS dataNascita, P.cod_utente AS id, P.cod_fiscale AS codFiscale, P.nome AS nomePersona, P.cognome AS cognome, P.dataCreazione AS dataCreazionePersona,
SS.sesso AS sesso, 
T.titolo AS titolo, 
R.citta AS citta, R.cap AS cap, R.indirizzo AS indirizzo, R.civico AS civico, R.provincia AS rProvincia, R.id_TipoVia AS tipoVia,
D.numero_documento AS nDoc,
C.cellulare AS cellulare, C.prefissoCell AS prefisso, C.email AS email

FROM persona AS P

JOIN contatto AS C ON C.id = P.id_contatti
JOIN residenza AS R on P.id_residenza = R.id
JOIN titolo AS T ON P.id_titolo = T.id
JOIN sesso AS SS ON P.id_sesso = SS.id
JOIN documento AS D ON D.id = P.id_documento

WHERE P.cod_utente = $id";

$result = $conn->query($sqlGiocatore);
while ($row = $result->fetch_assoc()) {
    $codUtente = $row["codUtente"];
    $cognome = $row["cognome"];
    $dataNascita = $row["dataNascita"];
    $luogo = $row["luogo"];
    $indirizzo = $row["indirizzo"];
    $civico = $row["civico"];
    $cap = $row["cap"];
    $citta = $row["citta"];
    $titolo = $row["titolo"];
    $nomeP = $row["nomePersona"];
    $provinciaNascita = $row["pNascita"];
    $provinciaResidenza = $row["rProvincia"];
    $numDocumento = $row["nDoc"];
    $numTelefono = "+" . $row["prefisso"] . " " . $row["cellulare"];
    $email = $row["email"];
    $img = '01.png';
    $dataCreazione = $row["dataCreazionePersona"];
    $tipoVia = $row["tipoVia"];
    if ($row["sesso"] == "Maschio") {
        $checkMaschio = "checked";
    } else {
        $checkFemmina = "checked";
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
    <title><?php echo $cognome . " " . $nomeP ?></title>
</head>

<body>

    
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

        <form class="tabs mt-3" style="display: <?php echo $dispalyRicerca ?>;">
            <p class="mb-0" style="opacity: 0.7;">Dati anagrafici:</p>
            <div class="div-border">
                <div class="div-left-anag">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Matricola:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-25 ml-5" id="inputEmail3" placeholder="<?php echo $codUtente ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Cognome:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($cognome) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nato il:</label>
                        <div class="col-sm-10">
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo $dataNascita ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nato a:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($luogo) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tipo:</label>
                        <div class="col-sm-10">
                            <select class="form-select w-25 ml-5" aria-label="Default select example" <?php echo $status ?>>
                                <?php
                                $sqlCategorie = "SELECT * FROM tipoVia";
                                $result = $conn->query($sqlCategorie);
                                while ($row = $result->fetch_assoc()) {
                                    $idTipoVia = $row["id"];
                                    if ($tipoVia == $row["id"]) {
                                        echo "<option value=$idTipoVia selected> " . $row["tipologia"] . "</option>";
                                    }
                                    echo "<option value=$idTipoVia> " . $row["tipologia"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Civico:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-15 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($civico) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Città:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($citta) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">C.F:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($codiceFiscale) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tel. 1:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($numTelefono) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                </div>
                <div class="div-right-anag">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Titolo:</label>
                        <div class="col-sm-10">
                            <select class="form-select w-25 ml-5" aria-label="Default select example" <?php echo $status ?>>
                                <?php
                                $sqlCategorie = "SELECT * FROM titolo";
                                $result = $conn->query($sqlCategorie);
                                while ($row = $result->fetch_assoc()) {
                                    $idtitolo = $row["id"];
                                    if ($titolo == $row["titolo"]) {
                                        echo "<option value=$idtitolo selected> " . $row["titolo"] . "</option>";
                                    }
                                    echo "<option value=$idtitolo> " . $row["titolo"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nome:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($nomeP) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Sesso:</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline ml-5 mt-1">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" <?php echo $checkMaschio ?> <?php echo $status ?>>
                                <label class="form-check-label" for="inlineRadio1">Maschio</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"  <?php echo $status ?>>
                                <label class="form-check-label" for="inlineRadio2">Femmina</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Provincia:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-15 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($provinciaNascita) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Indirizzo:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($indirizzo) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">CAP:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($cap) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Provincia:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-15 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($provinciaResidenza) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Documento:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo strtoupper($numDocumento) ?>" <?php echo $status ?>>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">E-mail:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control w-35 ml-5" id="inputEmail3" placeholder="<?php echo $email ?>" <?php echo $status ?>>
                        </div>
                    </div>
                </div>
            </div>


            <div class="div-photo-right">
                <center>
                    <img src="../UPLOADS/UPLOADS_PHOTO/01.png" alt="" class="w-100">
                    
                    <button type="button" class="btn btn-primary mt-2" style="background-color: #012E63; border: 0px solid black;" data-bs-toggle="modal" data-bs-target="#exampleModal" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                            <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z" />
                            <path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z" />
                            <path d="M7 9H2v5h5V9Zm-4 1h3v3H3v-3Zm8-6h1v1h-1V4Z" />
                            <path d="M9 2h5v5H9V2Zm1 1v3h3V3h-3ZM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8H8Zm2 2H9V9h1v1Zm4 2h-1v1h-2v1h3v-2Zm-4 2v-1H8v1h2Z" />
                            <path d="M12 9h2V8h-2v1Z" />
                        </svg>
                    </button>
                    
                   
                    <button type="button" class="btn btn-primary mt-2" style="background-color: #012E63; border: 0px solid black;" onclick="window.print();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                    </button>
                    <p class="mt-3">Utente creato il: <?php echo $dataCreazione ?></p>
                </center>
            </div>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">QR CODE <?php echo $cognome . " " . $nomeP ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <center><iframe class="" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $codiceFiscale?>" style="margin-left: 7%; border:0px #ffffff none;" name="myiFrame" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="200px" width="200px" allowfullscreen></iframe></center>
        <i><p>* il QR-CODE contiene il Codice Fiscale della persona</p></i>
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
    <script src="jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>