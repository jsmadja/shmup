<?php 
session_start();
// Includes
include("../_connexion.php");

// Clean the clone from the test table and adds to the relational tests_clone

$sql = "SELECT * FROM tests WHERE clone!=''";
$result=mysql_query($sql);
while ($test = mysql_fetch_assoc($result))
{
	$id = $test['clone'];
	$id_clone = $test['id'];
	$nom = $test['nom'];
	echo "$id - $nom<br />";
	$query_add = "INSERT INTO tests_clone (id, nom) VALUES ('$id','$nom')";
	echo "$query_add <br />";
	$resultat_add=mysql_query($query_add);
	$query_delete = "DELETE FROM tests WHERE id='$id_clone'";
	echo "$query_delete <br /><br />";
	$resultat_del=mysql_query($query_delete);
}
?>