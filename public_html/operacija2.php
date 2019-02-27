<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
    </script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!--  jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

    <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
</head>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Namų ūkio buhalterinė apskaita</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" >
</head>
<?php
// operacija2.php
// tiesiog rodomas  tekstas ir nuoroda atgal

session_start();

if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
{ header("Location: logout.php");exit;}
?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
        <title>Operacija 2</title>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <table class="center" ><tr><td> <center><img src="../include/top.png"></center> </td></tr><tr><td>

      <table style="border-width: 2px; border-style: dotted;"><tr><td>
         Atgal į [<a href="index.php">Pradžia</a>]
      </td></tr></table>
			
		<div style="text-align: center;color:black">
            <h1>Įplaukos į banką registravimas</h1>
        </div><br>
                    <?php
                    $userlevel=$_SESSION['ulevel'];
                    if (($userlevel == $user_roles["Tėvai"]) || ($userlevel == $user_roles[DEFAUKT_LEVEL] ))  {
                        include("include/meniu.php");
                        $dbc = mysqli_connect('localhost', 'marnor2', 'xei1ayooK2aet0Oh', 'marnor2');
                        if (!$dbc) {
                            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
                        }
                        if (isset($_POST['ok'])) {
                            $kategorija = $_POST['kategorija'];
                            $suma = $_POST['suma'];
                            $data = $_POST['data'];
                            $username = $_SESSION['user'];
                            $sql = "INSERT INTO israsai (kategorija, suma, data, username) VALUES ('$kategorija', '$suma', '$data', '$username')";
                            $result = mysqli_query($dbc, $sql);
                            $sql = "SELECT likutis FROM users WHERE username='$username'";
                            $result = mysqli_query($dbc, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $sumele = $row['likutis'] + $suma;
                            $sql = "UPDATE users SET likutis = '$sumele' WHERE username='$username'";
                            $result = mysqli_query($dbc, $sql);
                            header("Location: http://marnor2.stud.if.ktu.lt/operacija4.php");
                        }
                    }
                    ?>
                    <br>

                    <div style="text-align: center; class="container">
                        <form method='POST'>

                            <div class="form-group">
                                <label for="kategorija" class="control-label">Pavadinimas:</label>
                                <textarea name='kategorija' class="form-control input-sm"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="suma" class="control-label">Suma:</label>
                                <input type="number" name='suma' min="1" class="form-control input-sm">
                            </div>

                            <label for="deleteDate">Data:</label>
                            <input type="date" id="data" name="data"
                                   value=
                                   "<?php
                                   echo date("Y-m-d");
                                   ?>"
                                   min="2018-01-01" max="2018-12-31">

                            <br>

                            <div style="text-align: center;class="form-group col-lg-2">
                                <input type='submit' name='ok' value='Papildyti' class="btnbtn-default">
                            </div>


                        </form>
                    </div>