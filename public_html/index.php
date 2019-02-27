<?php
// index.php
// jei vartotojas prisijungęs rodomas demonstracinis meniu pagal jo rolę
// jei neprisijungęs - prisijungimo forma per include("login.php");
// toje formoje daugiau galimybių...

session_start();
include("include/functions.php");
include("include/nustatymai.php");
?>

<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
    <title>Namų ūkio buhalterinė apskaita</title>
    <link href="include/styles.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
    </script>
    <style>#lentele {
            font-family: Arial; border-collapse: collapse; width: 50%;
        }
        #lentele td {
            border: 1px solid #ddd; padding: 8px;
        }

        #lentele tr:nth-child(even){background-color: #f2f2f2;}

        #lentele tr:hover {background-color: #ddd;}</style>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

    var data = google.visualization.arrayToDataTable([
    ['Weekly task', 'Percentage'],

    <?php
    $dbc=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if(!$dbc){die ("Negaliu prisijungti prie MySQL:" .mysqli_error($dbc)); }
    $username = $_SESSION['user'];
    $query = "SELECT pavadinimas, suma FROM isleidimai WHERE username='$username'";

    $exec = mysqli_query($dbc,$query);
    while($row = mysqli_fetch_array($exec)){

        echo "['".$row['pavadinimas']."',".$row['suma']."],";
    }
    ?>

    ]);

    var options = {
    title: 'Stebėkite kam išleidžiate daugiausiai'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
    }
    </script>

    <style>
    #istorija {
        border-radius: 5px;
        width: auto;
        margin: 0px auto;
        float: none;
    }
    </style>


</head>
<body>
<table class="center" ><tr><td>
            <center><img src="include/top.png"></center>
        </td></tr><tr><td>
            <?php

            if (!empty($_SESSION['user']))     //Jei vartotojas prisijungęs, valom logino kintamuosius ir rodom meniu
            {                                  // Sesijoje nustatyti kintamieji su reiksmemis is DB
                // $_SESSION['user'],$_SESSION['ulevel'],$_SESSION['userid'],$_SESSION['umail']

                inisession("part");   //   pavalom prisijungimo etapo kintamuosius
                $_SESSION['prev']="index";

                include("include/meniu.php"); //įterpiamas meniu pagal vartotojo rolę
                ?>

                <div style="text-align: center;color:red">
                    <br><br>
                    <h1>Jūsų banko sąsk. likutis:</h1>
                </div>

                <?php
                $dbc=mysqli_connect('localhost','marnor2', 'xei1ayooK2aet0Oh','marnor2');
                if(!$dbc)
                {
                    die ("Negaliu prisijungti prie MySQL:" .mysqli_error($dbc));
                }

                $sql = "SELECT likutis FROM users WHERE username='{$_SESSION['user']}'";
                $result = mysqli_query($dbc, $sql);
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo
                        "<div>
						<h1 style=\"text-align: center;color:red\">".$row['likutis']." EUR</h1>
					</div>";
                }
                ?>

                <br>


                <?php
                if (mysqli_num_rows($result) < 1)
                {echo "<h3>Tuščia!</h3>";}


                else{
                    echo "

	        <table style='margin: 0px auto;' id='lentele'>
	        <tr>
             <td><b>Paskirtis</b></td>
	         <td><b>Suma</b></td>
	         <td><b>Data</b></td>
	            </tr>";

                    $dbc=mysqli_connect('localhost','marnor2', 'xei1ayooK2aet0Oh','marnor2');
                    if(!$dbc)
                    {
                        die ("Negaliu prisijungti prie MySQL:" .mysqli_error($dbc));
                    }
                    $username = $_POST['username'];
                    $sql = "SELECT * FROM israsai WHERE username='{$_SESSION['user']}'";
                    $result = mysqli_query($dbc, $sql);
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo '
		<form method="post">
		<tr>
		  <td>'.$row['kategorija'].'</td>
		  <td>'.$row['suma'].' EUR</td>
		  <td>'.$row['data'].'</td>
         </tr>
		 </form>';
                    }
                }
                echo "</table>";
                ?>
                <br>
                <div id="piechart" style="width: 900px; height: 500px; display: block; margin: 0 auto;"></div>
                <br>
                <p></p>
                <h2 align = "center"> Filtruokite išrašus</h2>
                <form method = "POST" action = "">

                    <table align = "center">
                        <tr>
                            <td>
                                <label for="kategorija">Kategorija:</label>
                                <?php
                                $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                                $sql = "SELECT pavadinimas FROM kategorijos";
                                $result = mysqli_query($db, $sql);
                                echo "<select name=\"kategorija\">";
                                while ($row = mysqli_fetch_assoc($result))
                                {$pavadinimas= $row['pavadinimas'];
                                    echo "<option value=".$pavadinimas.">".$pavadinimas."</option>";
                                }
                                echo "</select>";
                                ?>

                            <label for="datanuo">Data nuo:</label>
                            <input type="date" id="datanuo" name="datanuo"
                                   value=
                                   "<?php
                                   echo date("Y-m-d");
                                   ?>"
                                   min="2018-01-01" max="2019-12-31">

                            <label for="dataiki">Data iki:</label>
                            <input type="date" id="dataiki" name="dataiki"
                                   value=
                                   "<?php
                                   echo date("Y-m-d");
                                   ?>"
                                   min="2018-01-01" max="2019-12-31">

                                <p></p>
                                <center><input type="submit" name = "filter" value = "Filtruoti"></center>
                        </tr>
                    </table>

                </form>
                <?php
                if(isset($_POST['filter'])) {
                    $dbc = mysqli_connect('localhost', 'marnor2', 'xei1ayooK2aet0Oh', 'marnor2');
                    if (!$dbc) {
                        die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
                    }
                    $kategorija = $_POST['kategorija'];
                    $username = $_SESSION['user'];
                    $datanuo = $_POST['datanuo'];
                    $dataiki = $_POST['dataiki'];
                    $sql = "SELECT * FROM israsai WHERE data>='$datanuo' AND data<='$dataiki' AND kategorija='$kategorija' AND username='$username'";
                    $result = mysqli_query($dbc, $sql);

                    ?>
                    <table align="center" with="400" class="table table-striped table-bordered">
                    <tr>
                        <th>Paskirtis</th>
                        <th>Suma</th>
                        <th>Data</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo
                            "<tr>
						<td>" . $row['kategorija'] . "</td>
						<td>" . $row['suma'] . "</td>
						<td>" . $row['data'] . "</td>
					</tr>";

                    }
                }
                    ?>
                </table>


                <?php
            }

            else {

                if (!isset($_SESSION['prev'])) inisession("full");             // nustatom sesijos kintamuju pradines reiksmes
                else {if ($_SESSION['prev'] != "proclogin") inisession("part"); // nustatom pradines reiksmes formoms
                }
                // jei ankstesnis puslapis perdavė $_SESSION['message']
                echo "<div align=\"center\">";echo "<font size=\"4\" color=\"#ff0000\">".$_SESSION['message'] . "<br></font>";

                echo "<table class=\"center\"><tr><td>";
                include("include/login.php");                    // prisijungimo forma
                echo "</td></tr></table></div><br>";

            }
            ?>
</body>
</html>
