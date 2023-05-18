<?php
session_start();
include("CONFIG/config.php");

$string = "";

if ((isset($_SESSION["nominativo"]))) {
    header("Location: Pages/home.php");
} else {

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $pw = $_POST["password"];

        //$email = stripcslashes($email);
        //$pw = stripcslashes($pw);

        $sql = "SELECT id, email, nome, cognome, type, id_persona FROM userData WHERE email = '$email' and password = '$pw'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if ($count == 1 && $row["type"] != 1) {
            $_SESSION["nominativo"] = $row["cognome"] . " " . $row["nome"];
            $_SESSION["id_nominativo"] = $row["id"];
            $email = "";
            $pw = "";
            header("location: PAGES/home.php");
        } else if ($count == 1 && $row["type"] == 1) {
            $_SESSION["nominativo"] = $row["cognome"] . " " . $row["nome"];
            $_SESSION["id_nominativo"] = $row["id"];
            $email = "";
            $pw = "";
            $id = $row["id_persona"];
            header("location: PAGES/onlyShow.php?id=$id");
        }else{
            $string = "Email o password non corretti";
        }
    }
}

$conn = null;

/*
    $password = 'LaM1aPassW0rd'; //password valida
$hashedPassword = crypt($password, '$2a$07$usesomesillystringforsalt$'); //hash memorizzato nel database
$userPassword = 'LaM1aPassW0rd'; //password inserita dall'utente nel login
$hashedUserPassword = crypt($userPassword, '$2a$07$usesomesillystringforsalt$');
if(hash_equals($hashedPassword, $hashedUserPassword)) {
    echo "Accesso effettuato con successo";
} else {
    echo "La password inserita non è corretta";
}
*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="ICON/door-open.svg">
    <link href="CSS/style.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body class="bg-color-login">

    <div class="login-central">
        <div class="child">
            <h2 class="text-center mb-4">LOGIN</h2>
            <i><p class="text-center"><?php echo $string?></p></i>
            <form method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address / Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                    <div id="emailHelp" class="form-text">We'll never share your password with anyone else.</div>

                </div>
                <center>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </center>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

</html>