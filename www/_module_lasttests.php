<?php

$lasttests = '';

if ($page == "page_fiche" || $page == "page_index") $lasttests = "15";
if ($page == "page_home" || $page == "page_team") $lasttests = "10";

if ($lasttests != "") {

	echo '<h3>Derniers tests</h3>';
	echo '<ul>';

	$result_last = mysql_query("SELECT * FROM tests ORDER BY id DESC LIMIT 0,$lasttests");

	while ($last_test = mysql_fetch_assoc($result_last))
	{

		// COMMON VARIABLES
		$last_test_id		= $last_test['id'];
		$last_test_name 	= cleanText($last_test['nom']);
		$last_test_name_m 	= addLinks(cleanText($last_test['etymologie']));
		$last_test_author 	= $last_test['auteur'];
		$last_test_year 	= $last_test['annee'];
		$last_test_scroll 	= $last_test['sens'];
		$last_test_players 	= $last_test['joueur'];
		$last_test_editor 	= $last_test['fabriquant'];
		$last_test_support 	= $last_test['support'];
		$last_test_comment 	= addLinks(cleanText($last_test['commentaire']));
		$last_test_link 	= $last_test['site'];
		$last_test_note		= $last_test['note_tot'];
		$last_test_note_gra = addLinks(cleanText($last_test['note_gra']));
		$last_test_note_son = addLinks(cleanText($last_test['note_son']));
		
		$screenshots_last = array();
		foreach (glob('images/screenshots/sc_'.$last_test_id.'_1.*') as $filename_last) { $screenshots_last[] = $filename_last; }

		echo '
		<li class="overflow-hidden text-lineheight-medium">
			<a href="'.make_link($last_test_id,$last_test_name,'test').'">
				'.getScreenshot($screenshots_last,$last_test_id,$last_test_name,'tiny','position-float-left margin-right-10').'
				<p class="padding-right-20 margin-none">'.$last_test_name.'<br />
				<span class="text-size-mini color-dark">'.$last_test_year.' - '.$last_test_support.' - '.$last_test_author.' ('.$last_test_note.')</span>
				</p>
			</a>
		</li>
		<hr class="padding-none border-light border-dotted border-top-none margin-top-5 margin-bottom-5" />
		';
	}
	echo '</ul>';
}
?>