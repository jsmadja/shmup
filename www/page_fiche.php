<?php

// TITLE
echo '<h1 class="margin-bottom-none">'.$test_name.'</h1>';

// CLONES
echo $test_clones;

// MEANING
echo $meaning;

// INFOS
echo '
<table class="table table-striped table-bordered table-condensed margin-top-15">
<tbody>
  <tr>
    <td>Testeur</td>
    <td><a href="index.php?page=moteur&rech_auteur='.$test_author.'&go_recherche=1">'.$test_author.'</a></td>
  </tr>
  <tr>
    <td>Année</td>
    <td>'.$test_year.'</td>
  </tr>
  <tr>
    <td>Support</td>
    <td><a href="index.php?page=moteur&rech_support='.$test_support.'&go_recherche=1">'.$test_support.'</a>
  </tr>
  <tr>
    <td>Editeur</td>
    <td>'.$test_editor.'</td>
  </tr>
  <tr>
    <td>Joueurs</td>
    <td>'.$print_players.'</td>
  </tr>
  <tr>
    <td>Scrolling</td>
    <td>'.$print_scroll.'</td>
  </tr>
</tbody>
</table>';

echo '<hr />';

// PICTURES
echo '
<div class="size-width-40p position-float-right margin-left-20 margin-bottom-20" style="max-width:250px">';
echo getScreenshot($screenshots,$test_id,$test_name,'thumb');
	// LINKS
	echo $test_links;
echo '</div>';

// COMMENT
echo $test_comment;

echo '<hr class="hr-spacer" />';

// SEE ALSO
echo $test_related;
	
// TESTER OPINION BLOCK
echo '
<div class="set-lighter overflow-hidden">
	<div class="col-3">
		<div class="col-content text-align-center hero-unit">
		<span class="text-size-mini" style="line-height:5px !important">L\'avis de <a href="index.php?page=moteur&rech_auteur='.$test_author.'&go_recherche=1">'.$test_author.'</a></span><br />
		<h1 class="margin-none padding-none color-contrast">'.$test_note.'</h1>
		</div>
	</div>

	<div class="col-9">
		<div class="col-content">
			<h4 class="padding-none margin-none">Graphisme</h4>
			'.$test_note_gra.'
			<h4 class="padding-none margin-none">Son</h4>
			'.$test_note_son.'
		</div>
	</div>
</div>';

echo '<hr />';

// VISITORS OPINION BLOCK
if ($nbresultatvisiteur > 0) {
echo '
	<div class="set-lighter overflow-hidden">
		<div class="col-3">
    		<div class="col-content text-align-center margin-15">
    		<h1 class="margin-none padding-none color-contrast">'.$Note_Jeu_Moy_Round.'</h1>
    		</div>
    	</div>

    	<div class="col-9">
    		<div class="col-content">
    			Notes de <b>'.$nbresultatvisiteur.' visiteur(s)</b><br />
    			depuis le '.date("d\-m\-Y",$oldestvote[3]).'
    		</div>
    	</div>
	</div>';
}
else {
	echo '<p class="alert-box is-silent margin-top-15">Pas encore de vote des visiteurs sur '.$nomjeu.'</p>';
}


	// COMMENTS BLOCK
	//if ( $debut== "") $debut = 0;
	$query = "SELECT auteur, email, texte, date 
				FROM commentaires 
				WHERE nom=$id 
				ORDER BY id DESC"; // LIMIT
	$sql = mysql_query($query);
	$nbResults = mysql_num_rows($sql);

	$nbTotalComment = mysql_query("SELECT COUNT(*) FROM commentaires WHERE nom = $id");
	$nbTotalComment_enr = mysql_fetch_array($nbTotalComment);
	$nbTotalComment = $nbTotalComment_enr[0];
	/*
	$nbPages = ceil($nbTotalComment/$nb_comment_par_page);
	$numPage = ( $debut/$nb_comment_par_page ) + 1;
	*/

	// affichage des commentaires

	if ( $nbResults > 0 ) {

		echo '<h4><i class="icon-comment-alt"></i>&nbsp;'.$nbResults.' commentaires visiteurs</h4>';

		while ( $enr = mysql_fetch_array($sql) )
			{
			$auteur	= $enr[0];
			$email	= $enr[1];
			$texte	= $enr[2];
			$date	= $enr[3];

			$texte = utf8_encode(htmlspecialchars($texte));
			$auteur = utf8_encode(ucfirst(htmlspecialchars($auteur)));
			// $texte = nl2br($texte);
			$texte = @eregi_replace("([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])", "<a href=\"\\1://\\2\\3\" title=\"\\1://\\2\\3\" target=\"_blank\">[url]</a>", $texte);
			$auteur_date = str_replace('{DATE}', affiche_date($date), ', le {DATE}');

			echo '<p>
				<i class="icon-comment-alt"></i>&nbsp;<strong>'.$auteur.'</strong><span class="color-dark">'.$auteur_date.'</span><br />
				<span class="text-size-small">'.$texte.'</span>
			</p>';
			}
		
		/*
		$j=1;

		$debut2 = $debut;
		echo "<div align='right'><img src=\"images/puce_lien.gif\" height=\"7\" width=\"10\" border=\"0\">Page n°";
		while ( $j <= $nbPages)
			{
			$debut=$debut+$nb_comment_par_page;
			if ($j == '1') $debut = 0;
			if ($j != $numPage) echo '<a href="index.php?page=fiche&id='.$id.'&debut='.$debut.'">';
			echo '['.$j.']';
			if ($j != $numPage) echo '</a>';
			echo '&nbsp;';
			$j++;
			}

		echo '&nbsp;&nbsp;</div>';	
		*/
		}
	else
	{
	echo '<p class="alert-box is-silent margin-top-15">Pas encore de commentaires sur '.$nomjeu.'</p>';
	}
	?>
		