<?php

// TEST ELEMENTS
$result=mysql_query("SELECT * FROM tests ORDER BY nom ASC LIMIT 0,50");
$nbr_result = mysql_num_rows($result);

// TABLE
$table = '<table class="table table-bordered table-striped table-hover">
	        <thead>
	          <tr>
	          	<th></th>
	            <th class="size-width-30p">Nom</th>
	            <th>Année</th>
	            <th>Support</th>
	            <th>Editeur</th>
	            <th>Scroll</th>
	            <th>Note</th>
	          </tr>
	        </thead>
	        <tbody>';

while ($test = mysql_fetch_assoc($result)) {

	// COMMON VARIABLES
	$test_id		= $test['id'];
	$test_name 		= cleanText($test['nom']);
	$test_name_m 	= cleanText(addDictionary($test['etymologie']));
	$test_author 	= $test['auteur'];
	$test_year 		= $test['annee'];
	$test_scroll 	= $test['sens'];
	$test_players 	= $test['joueur'];
	$test_editor 	= $test['fabriquant'];
	$test_support 	= $test['support'];
	$test_comment 	= cleanText(addDictionary($test['commentaire']));
	$test_link 		= $test['site'];
	$test_note		= $test['note_tot'];
	$test_note_gra 	= cleanText(addDictionary($test['note_gra']));
	$test_note_son 	= cleanText(addDictionary($test['note_son']));

	if ($test['date_update'] != "") { 
		$test_update=cleanDate($test['date_update']);
	} else { 
		$test_update = ""; 
	}

	//SC
	//foreach (glob('images/screenshots/sc_'.$test_id.'_1_.*') as $filename) { $screenshots[] = $filename; echo $filename; }
	$screenshots = array();
	foreach (glob('images/screenshots/sc_'.$test_id.'_1.*') as $filename) { $screenshots[] = $filename; }

	$table .= '
		<tr class="clickable" data-url="'.make_link($test_id,$test_name,'test').'">
			<td>'.getScreenshot($screenshots,$test_id,$test_name,'tiny').'</td>
            <td>'.$test_name.'</td>
            <td>'.$test_year.'</td>
            <td>'.$test_support.'</td>
            <td>'.$test_editor.'</td>
            <td>'.$test_scroll.'</td>
            <td>'.$test_note.'</td>
          </tr>
	';

}

$table .= '
	</tbody>
      </table>';

?>