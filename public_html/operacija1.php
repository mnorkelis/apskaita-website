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
</head>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Namų ūkio buhalterinė apskaita</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" >
</head>

<body>


<table class="center" ><tr><td>
            <center><img src="include/top.png"></center>
            <center><b><?php echo $_SESSION['message1']; $_SESSION['message1'] = null; ?></b></center>
        </td></tr><tr><td>


            Atgal į [<a href="index.php">Pradžia</a>]


            <?php
            session_start();
            include("include/meniu.php");
            include("include/nustatymai.php");
            $userlevel=$_SESSION['ulevel'];
            if (($userlevel != $user_roles["Administratorius"])) {
                $dbc = mysqli_connect('localhost', 'marnor2', 'eiGh5ich9phahDil', 'marnor2');
                if (!$dbc) {
                    die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
                }
                if ($_POST != null) {

                    if (!in_array(null, $_POST)) {
                        $pavadinimas = $_POST['pavadinimas'];
                        //iterpiu i duombaze
                        $sql = "INSERT INTO kategorijos (pavadinimas) VALUES ('$pavadinimas')";
                        if (mysqli_query($dbc, $sql)) {
                            $_SESSION['message1'] = "Įrašymas sėkmingas!";
                            header("Location: operacija1.php");
                        } else {
                            $_SESSION['message1'] = "Klaida!";
                            header("Location: operacija1.php");
                            //echo "<script type = 'text/javascript'>alert(`$erroras`);</script>";
                        }
                    }
                };

            }
            ?>
            <br>
            <center><h1><b>Kategorijos registravimas</b></h1></center>
            <center><h6><b>Įveskite išlaidos kategorijos pavadinimą, kuriai skiriate pinigų</b></h6></center>
            <div style="text-align: center; class="container">
                <form method='POST'>
                    <div class="form-group">
                        <label for="pavadinimas" class="control-label">Pavadinimas:</label>
                            <textarea name='pavadinimas' class="form-control input-sm"></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type='submit' name='ok' value='Registruoti' class="btnbtn-default">
                    </div>
                </form>
            </div>
            </body>

