<?php
// meniu.php  rodomas meniu pagal vartotojo rolę

if (!isset($_SESSION)) { header("Location: logout.php");exit;}
include("include/nustatymai.php");
$user=$_SESSION['user'];
$userlevel=$_SESSION['ulevel'];
$role="";
{foreach($user_roles as $x=>$x_value)
			      {if ($x_value == $userlevel) $role=$x;}
} 

     echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
        echo "<tr><td>";
        echo "Prisijungęs vartotojas: <b>".$user."</b>     Rolė: <b>".$role."</b> <br>";
        echo "</td></tr><tr><td>";
        if (($userlevel == $user_roles["Vaikas"]))
        {
            echo "[<a href=\"useredit.php\">Redaguoti paskyrą</a>] &nbsp;&nbsp;";
            echo "[<a href=\"operacija2.php\">Papildyti banką</a>] &nbsp;&nbsp;";
            echo "[<a href=\"operacija4.php\">Registruoti išlaidą</a>] &nbsp;&nbsp;";
        }
        if (($userlevel == $user_roles["Tėvai"]))
        {
            echo "[<a href=\"useredit.php\">Redaguoti paskyrą</a>] &nbsp;&nbsp;";
            echo "[<a href=\"operacija1.php\">Sukurti kategoriją</a>] &nbsp;&nbsp;";
            echo "[<a href=\"operacija4.php\">Registruoti išlaidą</a>] &nbsp;&nbsp;";
        }
        if (($userlevel == $user_roles["Administratorius"]) || ($userlevel == $user_roles[ADMIN_LEVEL] ))
        {
            echo "[<a href=\"admin.php\">Administratoriaus sąsaja</a>] &nbsp;&nbsp;";
            echo "[<a href=\"useredit.php\">Redaguoti paskyrą</a>] &nbsp;&nbsp;";
            echo "[<a href=\"operacija2.php\">Papildyti banką</a>] &nbsp;&nbsp;";
            echo "[<a href=\"operacija4.php\">Registruoti išlaidą</a>] &nbsp;&nbsp;";
        }

        echo "[<a href=\"logout.php\">Atsijungti</a>]";
      echo "</td></tr></table>";
?>       
    
 