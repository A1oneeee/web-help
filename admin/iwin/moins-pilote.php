<?php
    session_start();
    if(isset($_SESSION['mark-page2'])){
        if( $_SESSION['mark-page2']==0){
            header("Location: //localhost/admin/admin-pilote.php"); // redirige l'utilisateur
        }
        else{
            $_SESSION['mark-page2'] -= 1;
            header("Location: //localhost/admin/admin-pilote.php"); // redirige l'utilisateur
        }
    }
    header("Location: //localhost/admin/admin-pilote.php"); // redirige l'utilisateur
?>