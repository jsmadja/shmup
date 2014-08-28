<?php
switch ($page) {
    case "page_blog":
        $nav = '
        	<h2>Blog</h2>
        	<ul id="subnav">
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-quote-left"></i>&nbsp;Actu générale</a></li>
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-calendar"></i>&nbsp;Sortie de jeu</a></li>
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-off"></i>&nbsp;Emulation</a></li>
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-coffee"></i>&nbsp;Shmup.com</a></li>
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-tags"></i>&nbsp;Divers</a></li>
        	</ul>
        	<h4 class="margin-bottom-none padding-bottom-none"><i class="icon-search"></i>&nbsp;Chercher une actu</h4>
			<fieldset>
				<form>
					<input type="text" class="set-black size-width-100p" placeholder="Chercher une actu" />
				</form>
			</fieldset>';
        break;
    case "page_fiche" || 'page_index':
        $nav = '
       		<h2 class="margin-bottom-none">Jeux</h2>
       		<p>'.$count_num_jeux.' jeux testés.</p>
        	<ul id="subnav">
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-bookmark"></i>&nbsp;Index des jeux</a></li>
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-star"></i>&nbsp;Top 100</a></li>
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-list-ol"></i>&nbsp;Séries</a></li>
        		<li><a href="#" class="bg-lighter padding-10 display-block"><i class="icon-laptop"></i>&nbsp;Supports</a></li>
        	</ul>
        	<h4 class="margin-bottom-none padding-bottom-none"><i class="icon-search"></i>&nbsp;Chercher un jeu</h4>
			<fieldset>
				<form>
					<input type="text" class="set-black size-width-100p" placeholder="Chercher un jeu" />
				</form>
			</fieldset>';
        break;
    case "page_home":
        $nav = '';
        break;
    default:
    	$nav = "";
        break;
}
echo $nav;
?>