<?php

$lastposts = '';

if ($page == "page_actu" || $page == "page_blog") $lastposts = "15";
if ($page == "page_home" || $page == "page_team") $lastposts = "10";

if ($lastposts != "") {

	echo '<h3>Derniers posts</h3>';

	$query = "SELECT * FROM news ORDER BY id DESC LIMIT 0,$lastposts";
	$action = mysql_query($query);

	echo '<ul class="list-simple">';

	while ($fetchedi=mysql_fetch_row($action)) 
	{
		$post_id = $fetchedi[0];
		$post_rubrique = cleanText($fetchedi[1]);
		$post_titre = cleanText($fetchedi[2]);
		$post_texte = cleanText($fetchedi[3]);
		$post_auteur = cleanText($fetchedi[4]);
		$post_image = $fetchedi[6];
		$post_url = $fetchedi[7];
		$post_link = $fetchedi[8];
		$post_date = date("d/m/y - H:i:s",$fetchedi[9]);

		// Texte
		echo '<li><a href="'.make_link($post_id,$post_titre,'blog').'">'.$post_titre.'</a></li>';
	}

	echo '</ul>';
}
?>