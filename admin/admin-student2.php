<?php
    // VERIFICATION 
    session_start();

    if(!isset($_SESSION['ID'])){
        header("Location: //localhost/connexion.php"); // redirige l'utilisateur
    }
    $server = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'projet';
    try{
        $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
        //On définit le mode d'erreur de PDO sur Exception	
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlREQ = "SELECT * FROM `authentication` WHERE id_login = '" . $_SESSION['ID'] . "';";
		$recipesStatement = $conn->prepare($sqlREQ);
		$recipesStatement->execute();
        $recipes = $recipesStatement->fetchAll();
		foreach ($recipes as $recipe) {
			$idadmin = $recipe['admin'];
		}
        if($idadmin!=1){
            header("Location: //localhost/connexion.php"); // redirige l'utilisateur
            $conn=null;
        }
        $conn=null;
    }
    catch(PDOException $e){ echo "<p class='textError'>Erreur lié à la base de données.</p>";}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Page de connexion." />
    <!-- CSS -->
	<link rel="stylesheet" href="/assets/ind.css">
    <link rel="stylesheet" href="/assets/admin-style.css">
    <link rel="stylesheet" href="/assets/addstud.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <!-- FONT FAMILY LINK -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish&display=swap">
    <!-- ICON -->
    <link rel="shortcut icon" href="/assets/img/logo.ico" alt="IconImg"/>
	<title>Admin - Elève</title>
</head>
<body>
<header>
        <!-- HAUT DE PAGE (NAV + LOGO) -->
        <nav class="navbar">
            <a href="./admin.php"><img src="/assets/img/logo.png" alt="LogoPic" class="logo"></a>
            <div class="nav-links">
                <ul>
                    <li><a href="./admin.php">Accueil</a></li>
                    <li><a href="./admin-companie.html">Entreprise</a></li>
                    <li><a href="#">Stage</a></li>
                    <li><a href="./admin-pilote.php">Pilote</a></li>
                    <li><a class="main" href="./admin-student2.php">Etudiant</a></li>
                    <li><a href="#">Candidature</a></li>
                </ul>
            </div>
            <img src="/assets/img/Hamburger_icon.svg.png" alt="menu burger"
            class="menu-burger">
        </nav>
    </header>   
    <!-- SEPARATION -->
    <div class="green-rect"></div>

    <!-- INFO DE L'ADMIN -->
    <section class="aff-login-admin">
        <?php
            echo "<img class='admin-pic' src='/users/" . $_SESSION['ID'] . "/admin-user-icon.jpg' alt='pic3'>";
            $server = 'localhost';
			$username = 'root';
			$password = '';
			$database = 'projet';
            try{
                $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
                //On définit le mode d'erreur de PDO sur Exception	
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sqlREQ = "SELECT * FROM `authentication` WHERE id_login = '" . $_SESSION['ID'] . "';";
				$recipesStatement = $conn->prepare($sqlREQ);
				$recipesStatement->execute();
                $recipes = $recipesStatement->fetchAll();
				foreach ($recipes as $recipe) {
					echo "<p>" . $recipe['login'] . "</p>" ;
				}
                $conn=null;
            }
            catch(PDOException $e){ echo "<p class='textError'>Erreur lié à la base de données.</p>";}
        ?>
        <a href="./deconnexion.php"><img name="deco" class="deco" src="/assets/img/deconn.png" alt="deco"></a>
    </section>

    <!-- SEPARATION -->
    <div class="green-rect2"></div>

    <div class="a">
        <a href="./admin-create-student.php">Créer un élève</a>
        <a href="./admin-search-student.php">Chercher des élève</a>
    </div>
   
    <section class="tableau">
    
        <table>
        <thead>
            <th>ID_LOGIN</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>E-mail</th>
            <th>Centre</th>
            <th>Promotion</th>
            <th>Modifier</th>
            <th>Supprimer</th>
            <th>Stats</th>
        </thead>
            <?php
                $server = 'localhost';
                $username = 'root';
                $password = '';
                $database = 'projet';
                try{
                    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
                    //On définit le mode d'erreur de PDO sur Exception	
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    if(!isset($_SESSION['mark-page'])){
                        $sqlREQ = "SELECT id_student, first_student, last_student, name_promo, name_centre, d.id_login, login, d.id_login FROM (SELECT id_student, first_student, last_student, name_promo, name_centre, id_login  FROM (SELECT id_student, first_student, last_student, student.id_centre, id_promo, name_centre, id_login 
                        FROM `student`
                        INNER JOIN centre ON centre.id_centre = student.id_centre) as h
                        INNER JOIN promotion ON promotion.id_promo = h.id_promo
                        WHERE first_student IS NOT NULL) as d
                        INNER JOIN authentication ON authentication.id_login = d.id_login
                        ORDER BY id_login
                        LIMIT 0, 25;";
                    }
                    else {
                        $tot = $_SESSION['mark-page'] * 25;
                        $sqlREQ = "SELECT id_student, first_student, last_student, name_promo, name_centre, d.id_login, login, d.id_login FROM (SELECT id_student, first_student, last_student, name_promo, name_centre, id_login  FROM (SELECT id_student, first_student, last_student, student.id_centre, id_promo, name_centre, id_login 
                        FROM `student`
                        INNER JOIN centre ON centre.id_centre = student.id_centre) as h
                        INNER JOIN promotion ON promotion.id_promo = h.id_promo
                        WHERE first_student IS NOT NULL) as d
                        INNER JOIN authentication ON authentication.id_login = d.id_login
                        ORDER BY id_login
                           LIMIT " . $tot . ", 25;";
                    }
                    $recipesStatement = $conn->prepare($sqlREQ);
                    $recipesStatement->execute();
                    $recipes = $recipesStatement->fetchAll();
                    foreach ($recipes as $recipe) {
                        echo "<tr>";
                        echo "<td>" . $recipe['id_login'] . "</td>";
                        echo "<td>" . $recipe['first_student'] . "</td>";
                        echo "<td>" . $recipe['last_student'] . "</td>";
                        echo "<td>" . $recipe['login'] . "</td>";
                        echo "<td>" . $recipe['name_centre'] . "</td>";
                        echo "<td>" . $recipe['name_promo'] . "</td>";
                        
                        echo "<td><a href='admin-modif-student.php?id=" . $recipe['id_login'] . "'><img class='mod-pic' src='/assets/img/mod.png' alt='ModPic'></a></td>";
                        echo "<td><a href='admin-delete-student.php?id=" . $recipe['id_login'] . "'><img class='del-pic' src='/assets/img/sup.png' alt='SupPic'></a></td>";
                        echo "<td><a href='admin-stats-student.php?id=" . $recipe['id_login'] . "'><img class='mod-pic' src='/assets/img/stats.png' alt='ModPic'></a></td>";
                        echo "</tr>";
                    }
                    $conn=null;
                }
                catch(PDOException $e){ echo "<p class='textError'>Erreur lié à la base de données.</p>";}
            ?>
        </table>
    </section>
    <div class="navigate">
        <a href="./iwin/iloose.php"><</a>
        <a href="./iwin/iwin.php">></a>
    </div>

    <footer>
            <li>
                <a href="#" class="hyperlinkFooter">
                    Mentions légales
                </a>
            </li>
            <label class="barreFooter">
                |
            </label>
            <li>
                <a href="#" class="hyperlinkFooter">
                    Politique de confidentialité
                </a>
            </li>
            <label class="barreFooter">
                |
            </label>
            <li>
                <a href="#" class="hyperlinkFooter">
                    © Copyright 2023
                </a>
            </li>
        </footer>
    <script>
        const menuHamburger = document.querySelector(".menu-burger")
        const navLinks = document.querySelector(".nav-links")
        menuHamburger.addEventListener('click',()=>{
        navLinks.classList.toggle('mobile-menu')
        })
    </script>
</body>
</html>