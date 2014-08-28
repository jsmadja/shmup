<?php 
session_start();
// Includes
include("../_connexion.php");

// Fill a link table

$sql = "SELECT * FROM tests";
$result=mysql_query($sql);
while ($test = mysql_fetch_assoc($result))
{
	$id = $test['id'];
	$site = $test['site'];
	if ($site !="http://" && $site !="")	
	{
		echo "$id - $site<br />";
		$query_add = "INSERT INTO tests_links (id, link) VALUES ('$id','$site')";
		echo "$query_add <br />";
		$resultat_add=mysql_query($query_add);
	}
}
?>