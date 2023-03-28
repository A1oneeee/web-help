<?php
    session_start();
    if(isset($_SESSION['mark-page'])){
        if( $_SESSION['mark-page']==0){
            header("Location: //localhost/admin/admin-student2.php"); // redirige l'utilisateur
        }
        else{
            $_SESSION['mark-page'] -= 1;
            header("Location: //localhost/admin/admin-student2.php"); // redirige l'utilisateur
        }
    }
    header("Location: //localhost/admin/admin-student2.php"); // redirige l'utilisateur
?>