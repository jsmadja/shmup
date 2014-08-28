<?php 
session_start();
// Includes
include("../_connexion.php");

// Rename and relocates all the thumbnails

$sql = "SELECT * FROM shmup";
$result=mysql_query($sql);

while ($test = mysql_fetch_assoc($result))
{
	$id = $test['id'];
	$pic1 = $test['url_img1'];
	$pic2 = $test['url_img2'];
	$pic3 = $test['url_img3'];
	$pic4 = $test['url_img4'];
	$pic5 = $test['url_img5'];

	$original_path = "../images/thumbs/";
	$new_path = "../images/screenshots/";

	for ($i = 1; $i <= 5; $i++) {

		if ($pic1 == "") $pic1 = "empty";
		if ($pic2 == "") $pic2 = "empty";
		if ($pic3 == "") $pic3 = "empty";
		if ($pic4 == "") $pic4 = "empty";
		if ($pic5 == "") $pic5 = "empty";

		if ($i==1) $original_name = $original_path.$pic1;
		if ($i==2) $original_name = $original_path.$pic2;
		if ($i==3) $original_name = $original_path.$pic3;
		if ($i==4) $original_name = $original_path.$pic4;
		if ($i==5) $original_name = $original_path.$pic5;
		

		if (file_exists($original_name)) 
		{
			$image = getimagesize($original_name);
			$type = $image['mime'];

			if ($type == "image/gif") $ext = ".gif";
			if ($type == "image/png") $ext = ".png";
			if ($type == "image/jpeg") $ext = ".jpg";
			if ($type == "image/x-ms-bmp") $ext = ".bmp";

			$new_name = $new_path.'sc_'.$id.'_'.$i.$ext;

			echo $id.' - '.$original_name.' - '.$type.' ==> '.$new_name.'<br />';
			// Move
			copy($original_name, $new_name) or die("!!! Unable to copy $original_name to $new_name.<br />");
		}
		else {
			echo "$original_name n'existe pas<br />";
		}
	}
}

?>