<?php 
session_start();
// Includes
include("../_connexion.php");

// Clean the clone from the test table and adds to the relational tests_clone

$sql = "SELECT * FROM tests WHERE link!=''";
$result=mysql_query($sql);

$pairs = array();

while ($test = mysql_fetch_assoc($result))
{
	$id = $test['id'];
	$id_related = explode("/", $test['link']);

	foreach ($id_related as $id_related)
	{
		echo $id.", ".$id_related."<br />";

		// test if pair exists, then add
		$sql_pair = "SELECT * FROM tests_related WHERE id=$id AND id_related=$id_related";
		$result_pair = mysql_num_rows(mysql_query($sql_pair));

		if ($result_pair == 0) {
			$query_add = "INSERT INTO tests_related (id, id_related) VALUES ('$id','$id_related')";
			echo "$query_add <br />";
			$resultat_add=mysql_query($query_add);
		}
		else echo "Already linked<br />";

		// test if reverse pair exists, then add
		$sql_pair = "SELECT * FROM tests_related WHERE id=$id_related AND id_related=$id";
		$result_pair = mysql_num_rows(mysql_query($sql_pair));

		if ($result_pair == 0) {
			$query_add = "INSERT INTO tests_related (id, id_related) VALUES ('$id_related','$id')";
			echo "$query_add <br />";
			$resultat_add=mysql_query($query_add);
		}
		else echo "Already linked<br />";
		
	}
	//echo "$id - $id_related<br />";
	//$query_add = "INSERT INTO tests_clone (id, nom) VALUES ('$id','$nom')";
	//echo "$query_add <br />";
	//$resultat_add=mysql_query($query_add);
	//$query_delete = "DELETE FROM tests WHERE id='$id_clone'";
	//echo "$query_delete <br /><br />";
	//$resultat_del=mysql_query($query_delete);
}

?>