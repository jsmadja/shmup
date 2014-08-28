<?php


if($id != "") 
{ 
	// MEMBER VIEW
	$sql_team = "
	SELECT count(*) AS total, team.* FROM team, tests 
	WHERE team.name = tests.auteur AND team.id = $id";

	$post = '<h2>La team Shmup</h2>
			<p>Les membres de l\'équipe du site et du forum.</p>';

	// MEMBER
	$action = mysql_query($sql_team);
	$fetched=mysql_fetch_assoc($action);
	
	$team_id = $fetched['id'];
	$team_name = cleanText($fetched['name']);
	$team_texte = postPreviewText($fetched['description'],40);
	$team_texte_full = cleanText($fetched['description']);
	$team_email= $fetched['email'];
	$team_ddn = $fetched['ddn'];
	$team_tests = $fetched['total'];

	$post = '<h2>'.$team_name.'</h2>
			<p>'.$team_texte_full.'</p>';

}
else 
{ 
	// TEAM VIEW
	$sql_team = "
	SELECT count(*) AS total, team.* FROM team, tests 
	WHERE team.name = tests.auteur AND team.core = 1
	GROUP BY team.id 
	ORDER BY team.name ASC";

	$sql_testers = "
	SELECT count(*) AS total, team.* FROM team, tests 
	WHERE team.name = tests.auteur AND team.core != 1
	GROUP BY team.id 
	ORDER BY total DESC, team.name ASC";

	$post = '<h2>La team Shmup</h2>
			<p>Les membres de l\'équipe du site et du forum.</p>';

	//$post .= '<h3 class="margin-bottom-none padding-bottom-none">Core team</h3>';

	// TEMPORARY CLOSE COL-CONTENT
	$post .= '</div>';

	// CORE TEAM LIST
	$action = mysql_query($sql_team);
	while ($fetched=mysql_fetch_assoc($action)) 
	{
		$team_id = $fetched['id'];
		$team_name = cleanText($fetched['name']);
		$team_texte = postPreviewText($fetched['description'],30);
		$team_texte_full = cleanText($fetched['description']);
		$team_email= $fetched['email'];
		$team_ddn = $fetched['ddn'];
		$team_tests = $fetched['total'];

		$post .= '
		<div class="col-half">
			<div class="col-content size-height-150 clickable" data-url="'.make_link($team_id,$team_name,'team').'">
				<h3 class="margin-none padding-none text-lineheight-medium">'.$team_name.'</h3>
				<span class="color-contrast"><i class="icon-circle-arrow-right"></i>&nbsp;'.$team_tests.' test'.isPlural($team_tests).'</span>
				<p class="text-size-mini text-lineheight-large color-dark">'.$team_texte.'</p>
			</div>
		</div>
		';
	}

	// REOPEN COL-CONTENT
	$post .= '<div class="col-content"><hr class="hr-spacer" /><hr class="margin-20 clearfix" />';

	// TESTERS TEAM LIST

	$post .= '<h3>Les testeurs</h3>
				<p>Tous les contributeurs de la rubrique tests.</p>';

	// TEMPORARY CLOSE COL-CONTENT
	$post .= '</div>';

	$action = mysql_query($sql_testers);
	while ($fetched=mysql_fetch_assoc($action)) 
	{
		$team_id = $fetched['id'];
		$team_name = cleanText($fetched['name']);
		$team_texte = postPreviewText($fetched['description'],20);
		$team_texte_full = cleanText($fetched['description']);
		$team_email= $fetched['email'];
		$team_ddn = $fetched['ddn'];
		$team_tests = $fetched['total'];

		$post .= '
		<div class="col-third">
			<div class="col-content size-height-150 clickable" data-url="'.make_link($team_id,$team_name,'team').'">
				<h3 class="margin-none padding-none text-lineheight-medium">'.$team_name.'</h3>
				<span class="color-contrast"><i class="icon-circle-arrow-right"></i>&nbsp;'.$team_tests.' test'.isPlural($team_tests).'</span>
				<p class="text-size-mini text-lineheight-large color-dark">'.$team_texte.'</p>
			</div>
		</div>
		';
	}

	// REOPEN COL-CONTENT
	$post .= '<div class="clearfix"></div><div class="col-content">';
}
?>