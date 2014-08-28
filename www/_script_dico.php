<?php

// MAIN WORD LIST
if ($id == "") 
{
	$query = "SELECT *, LOWER(substr(mot,1,1)) as firstletter FROM dictionnaire WHERE texte !='' ORDER BY mot ASC";
	$result = mysql_query($query);

	$total_dico = mysql_num_rows($result);
	$tiers = ceil($total_dico/3);

	$post = '<h1 class="margin-bottom-none">Le dictionnaire du Shmup</h1>';
	$post .= '<p>'.$total_dico.' définitions dans le dictionnaire</p>';
	$currentfirst = '';
	$i = '1';
	$breakline = "0";

	// TEMPORARY CLOSE COL-CONTENT
	$post .= '</div>';

	// FIRST COLUMN
	$post .= '<div class="col-third"><div class="col-content">';

	while ($dico  =  mysql_fetch_assoc($result)) 
	{
		$firstletter = ucfirst(cleanText($dico['firstletter']));
		$dico_id = $dico['id'];
		$dico_mot = ucfirst(cleanText($dico['mot']));

		// LETTER CHANGE
		if ($currentfirst != $firstletter) {
			if ($breakline != '0') {
				$post .= '</div></div><div class="col-third"><div class="col-content">';
				$breakline = "0";
			}
			$post .= '<h2>'.$firstletter.'</h2>';
		}

		$currentfirst = $firstletter;
		$post .= '<a href="'.make_link($dico_id,$dico_mot,'dictionnaire').'">'.$dico_mot.'</a><br />';

		// COLUMN CHANGE
		if ($i % $tiers == 0) {
			$breakline = "1";
		}

		$i++;
	}

	// REOPEN COL-CONTENT
	$post .= '</div></div><div class="col-content">';

}
else 
{
	$query = "SELECT * FROM dictionnaire WHERE id = $id";
	$result = mysql_query($query);

	$dico  =  mysql_fetch_assoc($result);
	$dico_id = $dico['id'];
	$dico_mot = ucfirst(cleanText($dico['mot']));
	$dico_definition = addLinks(cleanText($dico['texte']));
	$dico_auteur = cleanText($dico['auteur']);
	$dico_ext = $dico['image'];

	if ($dico_ext != "") $dico_image = '<img src="images/dico/img_dico'.$id.''.$dico_ext.'" class="position-float-right margin-left-20 margin-bottom-10">';
		else $dico_image = "";

	$post = '
		<h2 class="margin-bottom-5 text-lineheight-medium">Définition : '.$dico_mot.'</h2>
		<span class="text-size-mini color-dark">Par '.$dico_auteur.'</span>
		<p>'.$dico_image.''.$dico_definition.'</p>
	';

	// POSSIBLE RELATED GAMES
	$query_related = "
	SELECT id, nom,
	MATCH(commentaire) AGAINST('$dico_mot') AS score 
	FROM tests 
	WHERE MATCH(commentaire) AGAINST('$dico_mot') 
	ORDER BY score DESC 
	LIMIT 0,10";

	//echo $query_related;

	$result_related=mysql_query($query_related);
	$nbr_result_related = mysql_num_rows($result_related);

	if ($nbr_result_related > 0) {
		$post .= '<hr /><div class="alert-box">
					<span class="title">'.$nbr_result_related.' jeu'.isPlural($nbr_result_related,'x').' lié'.isPlural($nbr_result_related).' :</span>
					<hr class="hr-spacer margin-5"/>
					<ul class="list-simple">';
	}

	while ($test = mysql_fetch_assoc($result_related)) {

		// COMMON VARIABLES
		$test_id		= $test['id'];
		$test_name 		= cleanText($test['nom']);

		$post .= '<li><a href="'.make_link($test_id,$test_name,'test').'">'.$test_name.'</a></li>';
	}

	$post .= '</ul></div>';
}


/*
// Recup des données du mot
$action1=mysql_query("SELECT * FROM dictionnaire WHERE id=$id_affiche");
$fetched1=mysql_fetch_row($action1);

$queryprev="SELECT * FROM dictionnaire WHERE mot < '$motquery' AND texte != '' ORDER BY mot DESC LIMIT 0,1";
$resultprev=mysql_query("$queryprev");
while ($row  =  mysql_fetch_row($resultprev)) {
$idprev=$row[0];
$nomprev=$row[1];
}

$querynext="SELECT * FROM dictionnaire WHERE mot > '$motquery' AND texte != '' ORDER BY mot ASC LIMIT 0,1";
$resultnext=mysql_query("$querynext");
while ($row  =  mysql_fetch_row($resultnext)) {
$idnext=$row[0];
$nomnext=$row[1];
}

*/
?>