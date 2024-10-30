<?php
/*
Plugin Name: Bookmark Export
Plugin URI: http://www.t-muh.de/bookmark-export/
Description: Bookmark Export helps you push your blogs popularity importing your blog-posts/pages into social bookmarking services.
Version: 2.4
Author: Timo Schlueter
Author URI: http://www.t-muh.de/bookmark-export/
Min WP Version: 2.5.0
Max WP Version: 2.9.2
*/
 
/*  Copyright 2010  Timo Schlueter  (email : timo@t-muh.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function bookmarkexport_menu() {
  add_options_page('Bookmark Export Options', 'Bookmark Export', 8, __FILE__, 'bookmarkexport_options');
}

function bookmarkexport_options() {
	$plugin_dir = basename(dirname(__FILE__)) . "/lang/";
	load_plugin_textdomain( 'bookmark-export', 'wp-content/plugins/' . $plugin_dir, $plugin_dir );

	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui-core");
	
	$file_dir 		= get_option("siteurl")."/wp-content/plugins/bookmark-export";
	$last_day		= get_option("boomkark-export-day");
	$last_month		= get_option("boomkark-export-month");
	$last_year		= get_option("boomkark-export-year");
	
	echo '<script type="text/javascript" src="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/js/jquery-ui-1.8.1.custom.min.js"></script>';
	echo '<script type="text/javascript" src="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/js/jquery.qtip-1.0.0-rc3.min.js"></script>';
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/css/smoothness/jquery-ui-1.8.1.custom.css">';

	echo '<script type="text/javascript">';
	echo 'jQuery(function() {';
		echo 'jQuery("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });';
		echo 'jQuery("#datepicker2").datepicker({ dateFormat: "yy-mm-dd" });';
		echo 'jQuery(".tooltip1").qtip({';
   			echo 'content: "<ul><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/alltagz-icon.png\" alt=\"alltagz-icon\" /> alltagz</li> <li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/delicious-icon.png\" alt=\"delicious-icon\" /> delicious</li><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/linksilo-icon.png\" alt=\"linksilo-icon\" /> linksilo</li></ul>",';
   			echo 'style: {name: "light",tip: "topLeft"}});';
		echo 'jQuery(".tooltip2").qtip({';
   			echo 'content: "<ul><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/misterwong-icon.png\" alt=\"mister-wong-icon\" /> mister-wong</li><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/linksilo-icon.png\" alt=\"linksilo-icon\" /> linksilo</li></ul>",';
			echo 'style: {name: "light",tip: "topLeft"}});';
		echo 'jQuery(".tooltip3").qtip({';
   			echo 'content: "' . __('In this field you can enter a specific tag separator. You can enter whatever you want.','bookmark-export') . '",';
			echo 'style: {name: "light",tip: "topLeft"}});';		
		echo 'jQuery(".tooltip4").qtip({';
   			echo 'content: "<ul><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/linkarena-icon.png\" alt=\"linkarena-icon\" /> linkarena</li> <li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/firefox-icon.png\" alt=\"firefox-icon\" /> Firefox</li><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/chrome-icon.jpg\" alt=\"chrome-icon\" /> Chrome</li><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/safari-icon.jpg\" alt=\"safari-icon\" /> Safari</li><li><img src=\"' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/opera-icon.jpg\" alt=\"opera-icon\" /> Opera</li></ul>",';
   			echo 'style: {name: "light",tip: "topLeft"}});';	
		echo 'jQuery(".tooltip5").qtip({';
   			echo 'content: "' . __('Choose this to export your Posts.','bookmark-export') . '",';
			echo 'style: {name: "light",tip: "topLeft"}});';
		echo 'jQuery(".tooltip6").qtip({';
   			echo 'content: "' . __('Choose this to export your Pages.','bookmark-export') . '",';
			echo 'style: {name: "light",tip: "topLeft"}});';
		echo 'jQuery(".tooltip7").qtip({';
   			echo 'content: "' . __('Choose a specific time-range. This can be used to export only a few posts which have been published in that time period.','bookmark-export') . '<br />' . __('If you want to use this, click on the','bookmark-export') . ' <strong>\"Export by time period\"</strong>-' . __('Button below','bookmark-export') . '",';
			echo 'style: {name: "light",tip: "topLeft",width: "200"}});';
		echo 'jQuery(".tooltip8").qtip({';
   			echo 'content: "' . __('Exports only single post/page which have been published in time period specified under the','bookmark-export') . ' <strong>\"' . __('Date','bookmark-export') . '\"</strong>-' . __('Option','bookmark-export') . '",';
			echo 'style: {name: "light",tip: "topLeft",width: "200"}});';
		echo 'jQuery(".tooltip9").qtip({';
   			echo 'content: "' . __('Exports only the Posts/Pages which have been published since the last export. This happened on:','bookmark-export') . ' <strong>' . $last_day . '-' . $last_month . '-' .  $last_year . '",';
			echo 'style: {name: "light",tip: "topLeft",width: "200"}});';
		echo 'jQuery(".tooltip10").qtip({';
   			echo 'content: "' . __('Exports every single post/page on your blog. No guaranteed functionality!','bookmark-export') . '",';
			echo 'style: {name: "light",tip: "topLeft",width: "200"}});';
	echo '});';
	echo '</script>';
	
	/* Begin Userinterface */
	echo '<div class="wrap">';
	echo '<h2>' . __('Bookmark Export Plugin for WordPress', 'bookmark-export') . '</h2>';
	echo '<div id="poststuff" class="metabox-holder has-right-sidebar">';
	echo '<div class="inner-sidebar">';
		echo '<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position: relative;">';
			echo '<div class="postbox">';
				echo '<h3 class="hndle"><span>' . __('Social Bookmarking Services', 'bookmark-export') . '</span></h3>';
				echo '<div class="inside">';
					echo '<ul>';
					echo '<li>';
						echo '<img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/misterwong-icon.png" alt="misterwong-icon" /><a href="http://www.mister-wong.de" style="text-decoration:none; margin-left:5px;">mister-wong.de</a>';
					echo '</li>';
					echo '<li>';
						echo '<img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/linkarena-icon.png" alt="linkarena-icon.png" /><a href="http://www.linkarena.de" style="text-decoration:none; margin-left:5px;">linkarena.de</a>';
					echo '</li>';
					echo '<li>';
						echo '<img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/delicious-icon.png" alt="delicous-icon" /><a href="http://www.delicious.com" style="text-decoration:none; margin-left:5px;">delicious.com</a>';
					echo '</li>';
					echo '<li>';
						echo '<img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/alltagz-icon.png" alt="alltagz-icon" /><a href="http://www.alltagz.de" style="text-decoration:none; margin-left:5px;">alltagz.de</a>';
					echo '</li>';
					echo '<li>';
						echo '<img src="' . get_bloginfo('wpurl') . '/wp-content/plugins/bookmark-export/img/linksilo-icon.png" alt="linksilo-icon" /><a href="http://www.linksilo.de" style="text-decoration:none; margin-left:5px;">linksilo.de</a>';
					echo '</li>';
				echo '</ul>';
				echo '</div>';
			echo '</div>';
		echo '<div class="postbox">';
			echo '<h3 class="hndle"><span>' . __('Contact me', 'bookmark-export') . '</span></h3>';
			echo '<div class="inside">';
				echo '<ul>';
					echo '<li>';
						echo 'Mail: <a href="mailto:timo@t-muh.de">timo@t-muh.de</a>';
					echo '</li>';
					echo '<li>';
						echo 'ICQ: 108585887';
					echo '</li>';
					echo '<li>';
						echo 'MSN: t-muh@hotmail.de';
					echo '</li>';
					echo '<li>';
						echo 'Twitter: <a href="http://www.twitter.com/tmuuh">tmuuh</a>';
					echo '</li>';
				echo '</ul>';
			echo '</div>';
		echo '</div>';
		echo '<div class="postbox">';
			echo '<h3 class="hndle"><span>' . __('Donation', 'bookmark-export') . '</span></h3>';
			echo '<div class="inside">';
				echo '<div style="text-align:center;">';
					echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
					echo '<input type="hidden" name="cmd" value="_s-xclick">';
					echo '<input type="hidden" name="hosted_button_id" value="QJ6DZHZ2XD8PW">';
					echo '<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG_global.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">';
					echo '<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">';
				echo '</form>';
				echo '</div>';
				echo '<div style="clear: left; height: 1px;"></div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';
echo '<form action="' . $file_dir . '/bookmark-export-handler.php" name="exportForm" onsubmit="setTimeout(\'document.exportForm.reset();\', 3000);return true;">';
echo '<div class="has-sidebar">';
	echo '<div id="post-body-content" class="has-sidebar-content">';
		echo '<div class="meta-box-sortabless">';
			echo '<div class="postbox">';
				echo '<h3 class="hndle"><span>' . __('Information','bookmark-export') . '</span></h3>';
				echo '<div class="inside">';
					echo '<p>
					' . __('Bookmark Export is a plugin which automatically generates bookmark files which you can easily import into your several social-bookmarking service. It exports every single post or page you have written and automatically adds the needed information to the bookmark-file.','bookmark-export') . '</p>';
				echo '</div>';
			echo '</div>';
			
		echo '<div class="postbox">';
			echo '<h3 class="hndle"><span>' . __('Options','bookmark-export') . '</span></h3>';
			echo '<div class="inside">';
					echo '<h4 style="font-size:14px;">' . __('Tag separator','bookmark-export') . '</h4>';
						echo '<ul>';
							echo '<li>';
								echo '<input type="radio" name="seperator" value="comma" checked="checked"><span class="tooltip1"> ' . __('Comma','bookmark-export') . ' ( , )</span><br />';
							echo '</li>';
							echo '<li>';
								echo '<input type="radio" name="seperator" value="space"><span class="tooltip2"> ' . __('Space','bookmark-export') . ' ( " "  )</span><br />';
							echo '</li>';
							echo '<li>';
								echo '<input type="radio" name="seperator" value="semicolon"> ' . __('Semicolon','bookmark-export') . ' ( ; )';
							echo '</li>';
							echo '<li>';
								echo '<input type="radio" name="seperator" value="custom"><span class="tooltip3"> ' . __('Custom','bookmark-export') .'</span>'. ' <input name="custom_sep" type="text" size="1" maxlength="1"><br />';
							echo '</li>';
							echo '<li>';
								echo '<input type="radio" name="seperator" value="notags"><span class="tooltip4"> ' . __('No Tags','bookmark-export') . '</span>';
							echo '</li>';
						echo '</ul>';
					echo '<h4 style="font-size:14px;">' . __('Type','bookmark-export') . '</h4>';
						echo '<ul>';
							echo '<li>';
								echo '<input type="radio" name="type" value="posts" checked="checked"><span class="tooltip5"> ' . __('Posts', 'bookmark-export') . '</span><br/ >';
							echo '</li>';
							echo '<li>';
								echo '<input type="radio" name="type" value="pages"><span class="tooltip6"> ' . __('Pages', 'bookmark-export') . '</span><br />';
							echo '</li>';
						echo '</ul>';
					echo '<h4 style="font-size:14px;">' . __('Date','bookmark-export') . '</h4>';
						echo '' . __('From','bookmark-export') . ' <input id="datepicker" class="tooltip7" name="from" type="text" maxlength="10" size="10" value="' . $last_year . '-'. $last_month . '-' . $last_day . '">';
						echo ' ' . __('To','bookmark-export') . ' <input id="datepicker2" class="tooltip7" name="to" type="text" maxlength="10" size="10" value="' . date('Y') . '-' . date('m') . '-' . date('d') . '"><br />';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="postbox">';
			echo '<h3 class="hndle"><span>' . __('Export','bookmark-export') . '</span></h3>';
			echo '<div class="inside">';
				echo '' . __('By clicking on "Export" the export-file is going to be generated. It may take up to one minute until the download starts. Please dont reload this page!','bookmark-export') . '<br /><br />';
				echo '<input type="submit" class="button-primary tooltip8" name="export" value="Export by time period" ><br />';
				if (empty($last_day) || empty($last_month) || empty($last_year)) {
					echo '<input type="submit" class="button-primary" name="export" value="Export new only" disabled="true"><br />';
				} else {
					echo '<input type="submit" class="button-primary tooltip9" name="export" value="Export new only"><br />';
				}
				echo '<input type="submit" class="button-primary tooltip10" name="export" value="Export all">';
			echo '</div>';
		echo '</div>';
		echo '</form>';
echo '</div>';
echo '</div>';
}


/* Add the Adminmenu */
add_action('admin_menu', 'bookmarkexport_menu');
?>