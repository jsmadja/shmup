<?php


if($id != "") { 
	$sql_id="WHERE id='$id'"; 
	$post = '';
} else { 
	$sql_id="ORDER BY id DESC LIMIT 0,10"; 
	$post = '<h2>Dernières actus</h2>';
}

$query = "SELECT * FROM news $sql_id";
$action = mysql_query($query);



while ($fetched=mysql_fetch_assoc($action)) 
{
	$post_id = $fetched['id'];
	$post_rubrique = cleanText($fetched['rubrique']);
	$post_titre = cleanText($fetched['titre']);
	$post_texte = postPreviewText($fetched['texte']);
	$post_texte_full = cleanText($fetched['texte']);
	$post_auteur = cleanText(ucfirst($fetched['auteur']));
	$post_image = $fetched['image'];
	$post_url = $fetched['url'];
	$post_link = $fetched['link'];
	$post_date = cleanDate($fetched['date']);

	// BEGIN POST
	if($id != "") { 

		if ($post_image != "") 	{ 
			$post_image = '<img class="position-float-right margin-left-20 margin-bottom-20" src="images/news/img_news'.$post_id.''.$post_image.'" />';
		}

		$post .= '
			<h2 class="margin-bottom-5 text-lineheight-medium">'.$post_titre.'</h2>
			<span class="text-size-mini color-dark">Le '.$post_date.' - '.$post_rubrique.' - '.$post_auteur.'</span>
			
			<p>'.$post_image.''.$post_texte_full.'</p>
		';
	}
	else {

		if ($post_image != "") 	{ 
			$post_image = '
			<div class="size-square-100 position-float-right margin-left-20 background-cover" style="background-image:url(\'images/news/img_news'.$post_id.''.$post_image.'\'); background-position: center center"></div>';
		}

		$post .= '
			<div class="clickable" data-url="'.make_link($post_id,$post_titre,'blog').'">
				'.$post_image.'
				<h3 class="margin-bottom-5 text-lineheight-medium">'.$post_titre.'</h3>
				<span class="text-size-mini color-dark">Le '.$post_date.' - '.$post_rubrique.' - '.$post_auteur.'</span>
				<p>'.$post_texte.'</p>
			</div>
			<hr class="margin-top-20 margin-bottom-20"/>
		';
	}

	// Image
	/*
	if ($post_url != "") 	{ echo '<a href="'.$post_url.'" target="_blank">';}
	
	if ($post_url != "") 	{ echo "</a>";}
	*/

	// Texte
	/*
	echo '
	<a href="?id='.$post_id.'"><h3 class="margin-bottom-none">'.$post_titre.'</h3></a>
	<span class="text-size-mini">Le '.$post_date.' [<a href=\"?id=post_id\" >lien</a>] - '.$post_rubrique.' - '.$post_auteur.'</span>';

	echo '<p>'.$post_texte.'</p>';

/*
if ($fetched[8]!="") {
	echo "<img src=\"images/puce_lien3.gif\" height=\"7\" width=\"10\" border=\"0\">A voir aussi : <br>";
	$jeu_lien_vgl = str_replace("/",", ",$fetched[8]);
	//echo $jeu_lien_vgl;
	$requete="SELECT id, titre FROM news WHERE id IN ($jeu_lien_vgl)";
	//echo $requete;
	$action2=mysql_query("$requete");
	while ($fetched2=mysql_fetch_row($action2))
	{ $links="<a href=\"?id=$fetched2[0]\">$fetched2[1]</a>, ";
	echo $links;
	}
}
*/
}
?>