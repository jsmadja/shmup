<?php 
session_start();
// Includes
include("../_connexion.php");

// Look for auteurs and fills a table

$sql = "SELECT auteur FROM tests GROUP BY auteur";
$result=mysql_query($sql);
while ($auteur = mysql_fetch_assoc($result))
{
	$pseudo = $auteur['auteur'];
	
	// Look into member table
	$sql_m = "SELECT descriptif, email, naissance, site, sexe FROM membres WHERE pseudo = '$pseudo'";

	$result_m = mysql_query($sql_m);
	$details = mysql_fetch_assoc($result_m);

	//echo $pseudo.'<br />'.$details['descriptif'].'<br />'.$details['email'].' - '.$details['naissance'].' - '.$details['site'].' - '.$details['sexe'].' <br /><br /><br /><br />';
	$description = mysql_real_escape_string($details['descriptif']);
	$email = $details['email'];
	$ddn = $details['naissance'];
	$sex = $details['sexe'];
	$query_add = "INSERT INTO team (name, description, email, ddn, sex) VALUES ('$pseudo','$description','$email','$ddn','$sex')";
	echo "$query_add <br /><br />";
	$resultat_add=mysql_query($query_add);
}
?>