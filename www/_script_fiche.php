<?php 
// TEST ELEMENTS
$result=mysql_query("SELECT * FROM tests WHERE id=$id");
$nbr_result = mysql_num_rows($result);

// MAIN TEST
if ($nbr_result == 0) {
	// relocate
	header("Location: http://www.shmup.com/404.html");
	break;
}

$test = mysql_fetch_assoc($result);

// COMMON VARIABLES
$test_id		= $test['id'];
$test_name 		= cleanText($test['nom']);
$test_name_m 	= addLinks(cleanText($test['etymologie']),$test_name);
$test_author 	= $test['auteur'];
$test_year 		= $test['annee'];
$test_scroll 	= $test['sens'];
$test_players 	= $test['joueur'];
$test_editor 	= $test['fabriquant'];
$test_support 	= $test['support'];
$test_comment 	= addLinks(cleanText($test['commentaire']),$test_name);
$test_link 		= $test['site'];
$test_note		= $test['note_tot'];
$test_note_gra 	= addLinks(cleanText($test['note_gra']),$test_name);
$test_note_son 	= addLinks(cleanText($test['note_son']),$test_name);

if ($test['date_update'] != "") { 
	$test_update=cleanDate($test['date_update']);
} else { 
	$test_update = ""; 
}

// CHECK FOR $test_group (invaders, 19XX) -> common group id linking games between them, no static page

// CHECK FOR NAME MEANING
if ($test_name_m != "") 
{
	$meaning = '
	<div class="alert-box margin-top-15 margin-bottom-15">
		<span class="title"><i class="icon-question-sign icon-2x icon-muted position-float-right"></i>Pourquoi ce titre?</span><br />
		'.$test_name_m.'
	</div>';
}
else $meaning = '';

// CHECK FOR $test_link
$result_links=mysql_query("SELECT * FROM tests_links WHERE id=$test_id");
$row_links  = mysql_num_rows($result_links);

if ($row_links > 0)
{
	$test_links = '<hr /><div class="set-light padding-15 size-width-100p position-float-right>';
	$test_links .= '<h4 class="margin-none padding-none">Liens</h4><ul class="text-ellipsis">';
	while ($fetched_links  =  mysql_fetch_assoc($result_links)) 
	{
		$test_links .= '<li><a href="'.$fetched_links['link'].'"><i class="icon-external-link"></i>&nbsp;'. cleanText($fetched_links['link']).'</a></li>';
	}
	$test_links .= '</ul>';
	$test_links .= '</div>';
}
else $test_links = "";

// CHECK IF THE GAME IS IN THE TOP 100 -> make a top 100 page

// CHECK FOR CLONES
$result_clone=mysql_query("SELECT nom FROM tests_clone WHERE id=$test_id ORDER BY nom");
$row_clone  = mysql_num_rows($result_clone);

if ($row_clone > 0)
{
	$test_clones = '<h4 class="margin-none padding-none"><span class="color-darker shadow-none">A.k.a.</span> ';
	while ($fetched_clone  =  mysql_fetch_assoc($result_clone)) 
	{
		$test_clones .= cleanText($fetched_clone['nom']).', ';
	}
	$test_clones = substr($test_clones,0,-2);
	$test_clones .= '</h4>';
}
else $test_clones = "";

// CHECK FOR RECOMMENDED GAMES
$sql_related = "
	SELECT 
	tests.id AS test_related_id, 
	tests.nom AS test_related_nom 
	FROM tests, tests_related 
	WHERE tests.id = tests_related.id_related 
	AND tests_related.id = $test_id";

$result_related=mysql_query($sql_related);
$row_related  = mysql_num_rows($result_related);

if ($row_related > 0)
{
	if ($row_related > 1) {
		$related_x = "x";
		$related_s = "s";
	}
	else $related_x = $related_s = "";

	$test_related = '
	<div class="alert-box">
	<span class="title">'.$row_related.' jeu'.$related_x.' conseillé'.$related_s.' :</span>
	<hr class="hr-spacer margin-5"/>
	<ul class="list-simple">';


	while ($fetched_related=mysql_fetch_assoc($result_related))
	{
		$test_related .= '<li><a href="'.make_link($fetched_related['test_related_id'],$fetched_related['test_related_nom'],'test').'">'.cleanText($fetched_related['test_related_nom']).'</a></li>';
	}

	$test_related .= '</ul></div>';
	$test_related .= '<hr class="hr-spacer" />';
}
else $test_related = "";

// CHECK FOR COVER

// CHECK FOR AVAILABITIY ON OTHER SUPPORTS

// CHECK FOR PICTURES
foreach (glob('images/screenshots/sc_'.$test_id.'_*.*') as $filename) { $screenshots[] = $filename; }

// CHECK FOR NUMBER OF PLAYERS
switch ($test_players) {
    case 1:
        $print_players = "Un seul joueur";
        break;
    case 2:
        $print_players = "Deux joueurs";
        break;
    case 3:
        $print_players = "Deux joueurs simultanés";
        break;
    case 4:
        $print_players = "Quatre joueurs";
        break;
    case 6:
        $print_players = "Six joueurs (!!!)";
        break;
    default:
    	$print_players = "Nombre de joueurs inconnu";
        break;
}

// CHECk FOR TYPE OF SCROLLING
switch ($test_scroll) {
    case "hor":
        $print_scroll = "Scrolling Horizontal";
        break;
    case "ver":
        $print_scroll = "Scrolling Vertical";
        break;
    case "mul":
        $print_scroll = "Scrolling Multidirectionnel";
        break;
    case "nop":
        $print_scroll = "Pas de scrolling";
        break;
    case "tra":
        $print_scroll = "Train fantôme";
        break;
    default:
    	$print_scroll = "Nombre de joueurs inconnu";
        break;
}
/*

// Navigation fiches
/*
$nomjeu_ok=addslashes($nomjeu);
if (@ereg("'",$nomjeu)) { $limit_page = "2"; } else { $limit_page = "1"; }

$resultprev=mysql_query("SELECT * FROM shmup WHERE nom < '$nomjeu_ok' AND clone ='' ORDER BY nom DESC LIMIT 0,$limit_page");
while ($row  =  mysql_fetch_row($resultprev)) {
$idprev=$row[0];
$nomprev=stripslashes($row[1]);
}
$resultnext=mysql_query("SELECT * FROM shmup WHERE nom > '$nomjeu_ok' AND clone ='' ORDER BY nom ASC LIMIT 0,$limit_page");
while ($row  =  mysql_fetch_row($resultnext)) {
$idnext=$row[0];
$nomnext=stripslashes($row[1]);
}
*/
///////////////// VOTING /////////////////

// AVG VISITOR VOTE
$result = mysql_query("SELECT * FROM votes WHERE Num_Jeu = '$test_id' ORDER BY Date_Vote ASC");
$nbresultatvisiteur = mysql_num_rows($result);

// OLDEST VOTE
$oldestvote = mysql_fetch_row($result);

$result2 = mysql_query("SELECT moy FROM moyennes WHERE id = '$test_id'");
$nbresultat2 = mysql_num_rows($result2);
$ligne = mysql_fetch_row($result2);

if ($nbresultat2 > 0 )
{
$Note_Jeu_Moy = $ligne[0];
$Note_Jeu_Moy_Round =  round($Note_Jeu_Moy, 2);
}

//////////////////////////////////////////////////////////////////////////////////


?>