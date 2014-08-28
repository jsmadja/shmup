<?php

//Url rewrite
function make_link($id,$title,$page) {

	$StringTab=explode(" ",$title);
	if (count($StringTab)>80) { $tot=80; } else { $tot=count($StringTab); }

	$title_ok = "";
	for($i=0;$i<$tot;$i++) { $title_ok.=" "."$StringTab[$i]"; }
	$title_ok = @eregi_replace("[[:punct:]]","",$title_ok);
	$title_ok = ucfirst(str_replace(" ","_",trim($title_ok)));
	$title_ok = stripAccents($title_ok);
	
	$link = $page."-".$id."-".$title_ok.".html";
	
	return $link;
}

function affiche_date($date1)
{	
	$jour	= substr($date1, 8, 2);
	$mois	= substr($date1, 5, 2);
	$annee	= substr($date1, 0, 4);	// année, 4 chiffres (ex: 2002)
	$annee2	= substr($date1, 2, 2);	// année, 2 chiffres (ex:  02)
	$heure	= substr($date1, 11, 5);

	$date = $jour.'/'.$mois.'/'.$annee.' à '.$heure;

	return $date;
}

function stripAccents($texte) {
	$texte = str_replace(
		array(
			'à', 'â', 'ä', 'á', 'ã', 'å',
			'î', 'ï', 'ì', 'í', 
			'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
			'ù', 'û', 'ü', 'ú', 
			'é', 'è', 'ê', 'ë', 
			'ç', 'ÿ', 'ñ',
			'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
			'Î', 'Ï', 'Ì', 'Í', 
			'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø', 
			'Ù', 'Û', 'Ü', 'Ú', 
			'É', 'È', 'Ê', 'Ë', 
			'Ç', 'Ÿ', 'Ñ', 
		),
		array(
			'a', 'a', 'a', 'a', 'a', 'a', 
			'i', 'i', 'i', 'i', 
			'o', 'o', 'o', 'o', 'o', 'o', 
			'u', 'u', 'u', 'u', 
			'e', 'e', 'e', 'e', 
			'c', 'y', 'n', 
			'A', 'A', 'A', 'A', 'A', 'A', 
			'I', 'I', 'I', 'I', 
			'O', 'O', 'O', 'O', 'O', 'O', 
			'U', 'U', 'U', 'U', 
			'E', 'E', 'E', 'E', 
			'C', 'Y', 'N', 
		),$texte);
	return $texte;
}

function cleanDate($timestamp) {
	$timestamp = date("d/m/y - H:i:s",$timestamp);
	return $timestamp;
}

function cleanText($text) {
	$text = nl2br(utf8_encode(stripslashes($text)));
	return $text;	
}

function get_snippet( $str, $wordCount = 10 ) {
  return implode( 
    '', 
    array_slice( 
      preg_split(
        '/([\s,\.;\?\!]+)/', 
        $str, 
        $wordCount*2+1, 
        PREG_SPLIT_DELIM_CAPTURE
      ),
      0,
      $wordCount*2-1
    )
  );
}

function metaText($text){ 
  $text = preg_replace('/^\s+|\n|\r|\s+$/m', '', $text);
  $text = strip_tags($text);
  $text = get_snippet($text, 40);
  $text .= "...";
  return $text; 
} 

function postPreviewText($text,$qty='40') {	
	$text = preg_replace('/^\s+|\n|\r|\s+$/m', '', $text);
	$text = strip_tags($text);
	$text = utf8_encode(stripslashes($text));
	$text = get_snippet($text, $qty);
	$text .= "...";
	return $text;	
}

function addLinks($text, $self="") {

	$originalText = $text;

	// CLEAN HTML AND PUNCT
	$text = strip_tags($text);
	$text = html_entity_decode($text);
	$text = preg_replace("/(?![.=$'€%-])\p{P}/u", "", $text);
	//$text = preg_replace("/[^a-zA-Z 0-9]+/", "", $text);

	// GET WANTED WORDS LIST
	$dico = array();
	$blacklist = array();

	if ($self != "") $blacklist[] = $self;
	
	$results = mysql_query("SELECT id, nom FROM tests") or die (mysql_error()); 
	
	while ($games = mysql_fetch_assoc($results)) {
		$dico[$games['nom']]['type'] = 'test';
		$dico[$games['nom']]['id'] = $games['id'];
	}

	$results = mysql_query("SELECT id, mot FROM dictionnaire") or die (mysql_error()); 
	
	while ($mots = mysql_fetch_assoc($results)) {
		$dico[$mots['mot']]['type'] = 'dictionnaire';
		$dico[$mots['mot']]['id'] = $mots['id'];
	}

	// EXPLODE WORDS

	$text= explode(" ", $text);
	$wordcount = count($text);
	$returntext = "";
	$maxNumWords = "4";
	$j = "0";

	// var_dump($text);
	
	for ($i = $maxNumWords; $i >= 1; $i--) 
	{
		$returntext .= "$i word<br />";

		for ($l = 0; $l <= $wordcount-$i; $l++)
		{

			$expression = "";

			for ($k = 0; $k <= $i-1; $k++) 
			{
				$expression .= " ".$text[$l+$k];
			}

			$expression = trim($expression);

			// CHECKS AGAINST BLACKLIST
			if (in_array($expression, $blacklist))
			{
				$returntext .= "ALREADY DEFINED - ";
			}
			else 
			{

				if (array_key_exists($expression, $dico)) 
				{
					$returntext .= "<b>FOUND</b> - ";

					// DEFINE TYPE
					$link = make_link($dico[$expression]['id'],$expression,$dico[$expression]['type']);
					if ($dico[$expression]['type'] == 'dictionnaire') {
						$typepage = "la d&eacute;finition";
						$ico = 'icon-bookmark-empty';
					}
						else  {
						$typepage = "le test";
						$ico = 'icon-gamepad';
					}

					// REPLACES IN ORIGINAL TEXT
					$originalText=preg_replace(
					"/(\A|[[:space:]])$expression([[:space:]]|[[:punct:]]|\z)/i",
					" <a class=\"def\" title=\"Afficher $typepage de $expression\" href=\"$link\">$expression <sup><i class=\"is-silent $ico\"></i></sup></a>\\2",
					$originalText);

					// ADDS COMPONENT TO BLACKLIST
					$blacklist[] = $expression;
					$expressionComponents = explode(" ", $expression);
					foreach ($expressionComponents as $v) {
						$blacklist[] = $v;
					}

				}
				else  {
					$returntext .= "NOT FOUND - ";
				}
				
			}

			$returntext .= $expression."<br />";

		}

	}
	
	$returntext .= "<br /><br />$originalText";
	return $originalText;
}

function getScreenshot($file,$id,$name,$option,$position='') {
	$sc = '';

	foreach ($file as $v) {
		if ($option == 'thumb') {
			$sc .= '<img src="'.$v.'" alt="Screenshot de '.$name.'" class="position-float-right size-width-100p margin-bottom-20" />';
		}
		elseif ($option == 'tiny') {
			$sc .= '<div class="size-square-30 background-cover '.$position.'" style="background-image:url(\''.$v.'\'); background-position: center center"></div>';
		}
	}
	return $sc;
}

function isPlural($number, $type='s') {
	if ($number > 1) return $type;
	else return "";
}
?>