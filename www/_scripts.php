<?php

// GLOBAL VARIABLES
$PHP_SELF = $_SERVER['PHP_SELF']; 
if (!isset($_SESSION['s'])) $_SESSION['s'] = "";
if (!isset($_SESSION['w'])) $_SESSION['w'] = "";

// GETTERS
if (isset($_GET['page'])) { $page=$_GET['page']; }  else { $page = "page_home"; }
if (isset($_GET['s'])) { $_SESSION['s'] = $_GET['s']; } // Skin
if (isset($_GET['w'])) { $_SESSION['w'] = $_GET['w']; } // Width

// OLD - NEW PAGE MAPPING
if ($page == "fiche") $page = "page_fiche"; // quick fix : delete this

if (isset($_GET['id'])) { $id=$_GET['id']; }        else { $id = ""; }

///////////////////////////////////////////////////////
/* COMMUN SCRIPTS */
///////////////////////////////////////////////////////

// BODY WIDTH
if ($_SESSION['w'] == '') $bodyWidth = "mainBody";
else $bodyWidth = "mainBodyFull";

// TOTAL TESTS
$result = mysql_query("SELECT count(*) FROM tests") or die (mysql_error()); 
$result = mysql_fetch_row($result); 
$count_num_jeux = $result[0];

// PAGES

$nav_blog = $nav_jeux = $nav_dossiers = $nav_team = $nav_liens = $nav_dico = "";

if ($page == "page_fiche" AND $id !="") // Test page
{
    // Page title
    $result = mysql_query("SELECT nom, support, annee, commentaire FROM tests WHERE id=$id");
    $fetched  =  mysql_fetch_row($result);
    $nomjeu = cleanText($fetched[0]);
    $anneejeu = stripslashes($fetched[1]);
    $supportjeu = stripslashes($fetched[2]);

    // META
    $pageTitle = "Test de ".$nomjeu." - ".$anneejeu." - ".$supportjeu;
    $pageMeta = utf8_encode(metaText($fetched[3]));

    $nav_jeux = "is-active";
    include("_script_fiche.php");
}
elseif ($page == "page_blog") // Blog page
{
    /*
    $result = mysql_query("SELECT titre, texte FROM news WHERE id=$id");
    $fetched  =  mysql_fetch_row($result);
    $titrenews = stripslashes($fetched[0]);

    // META
    $pageTitle = cleanText($titrenews);
    $pageMeta = utf8_encode(metaText($fetched[1]));
    */

    $pageTitle = "Shoot Them Up ! Archive et musée du shoot them up";
    $pageMeta = "";
    
    $nav_blog = "is-active";
    include("_script_blog.php");
}
elseif ($page == "page_team") // Blog page
{
    /*
    $result = mysql_query("SELECT titre, texte FROM news WHERE id=$id");
    $fetched  =  mysql_fetch_row($result);
    $titrenews = stripslashes($fetched[0]);

    // META
    $pageTitle = cleanText($titrenews);
    $pageMeta = utf8_encode(metaText($fetched[1]));
    */

    $pageTitle = "Shoot Them Up ! Archive et musée du shoot them up";
    $pageMeta = "";
    
    $nav_team = "is-active";
    include("_script_team.php");
}
elseif ($page == "page_index") // Index page
{
    /*
    $result = mysql_query("SELECT titre, texte FROM news WHERE id=$id");
    $fetched  =  mysql_fetch_row($result);
    $titrenews = stripslashes($fetched[0]);

    // META
    $pageTitle = cleanText($titrenews);
    $pageMeta = utf8_encode(metaText($fetched[1]));
    */

    $pageTitle = "Shoot Them Up ! Archive et musée du shoot them up";
    $pageMeta = "";
    
    $nav_jeux = "is-active";
    include("_script_index.php");
}
elseif ($page == "page_dico") // Index page
{
    /*
    $result = mysql_query("SELECT titre, texte FROM news WHERE id=$id");
    $fetched  =  mysql_fetch_row($result);
    $titrenews = stripslashes($fetched[0]);

    // META
    $pageTitle = cleanText($titrenews);
    $pageMeta = utf8_encode(metaText($fetched[1]));
    */

    $pageTitle = "Shoot Them Up ! Archive et musée du shoot them up";
    $pageMeta = "";
    
    $nav_dico = "is-active";
    include("_script_dico.php");
}
else // Default page
{
    $pageTitle = "Shoot Them Up ! Archive et musée du shoot them up";
    $pageMeta = "";
}

?>