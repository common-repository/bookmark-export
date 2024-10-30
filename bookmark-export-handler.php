<?php
	require_once('../../../wp-config.php');
	require_once('../../../wp-includes/functions.php');
	error_reporting(0);
	
	$date 			= date('d-m-Y-h-i-s');
	$tag_seperator 	= $_GET["seperator"];
	$type			= $_GET["type"];
	$custom			= $_GET["custom_sep"];
	$export			= $_GET["export"];
	$from			= $_GET["from"];
	$to				= $_GET["to"];
	$last_day		= get_option("boomkark-export-day");
	$last_month		= get_option("boomkark-export-month");
	$last_year		= get_option("boomkark-export-year");
	
	update_option("boomkark-export-year", date('Y'));
	update_option("boomkark-export-month", date('m'));
	update_option("boomkark-export-day", date('d'));
	
  	function filter_where($where = '') {
  		$last_day	= get_option("boomkark-export-day");
		$last_month	= get_option("boomkark-export-month");
		$last_year	= get_option("boomkark-export-year");
    		$where 	   	.= " AND post_date >= \"$last_year-$last_month-$last_day\"";
    		return $where;
  	}
  	
  	function filter_where_specific($where = '') {
  		$from		= $_GET["from"];
		$to		= $_GET["to"];
    		$where 	   	.= " AND post_date >= \"$from\" AND post_date < \"$to\"";
    		return $where;
  	}
  	
  	switch($export) {
		case "Export new only":
			add_filter('posts_where', 'filter_where');
			$filename = "new_" . $last_year . "-" . $last_month . "-" . $last_day . "_" . date('Y') . "-" . date('m') . "-" . date('d');
			break;
		case "Export by time period":
			add_filter('posts_where', 'filter_where_specific');
			$filename = "period_" . $from . "_" . $to;
			break;
		default:
			$filename = "all_" . date('Y') . "-" . date('m') . "-" . date('d');
			break;
	}

	switch($tag_seperator) {
		case 'comma':
			$tag_seperator = ',';
			$filename = "comma-" . $filename;
			break;
		case 'space':
			$tag_seperator = ' ';
			$filename = "space-" . $filename;
			break;
		case 'semicolon':
			$tag_seperator = ';';
			$filename = "semicolon-" . $filename;
			break;
		case 'custom':
			$tag_seperator = $custom;
			$filename = "custom-" . $filename;
			break;
		case 'notags':
			$filename = "notags-" . $filename;
			break;
		default:
			$tag_seperator = ',';
			$filename = "comma-" . $filename;
			break;
	}
	
	switch($type) {
		case 'posts':
			query_posts('posts_per_page=-1&post_status=publish&post_type=post');
			$filename = "posts-" . $filename;
			break;
		case 'pages':
			query_posts('posts_per_page=-1&post_status=publish&post_type=page');
			$filename = "pages-" . $filename;
			break;
		default:
			query_posts('posts_per_page=-1&post_status=publish');
			$filename = "posts-" . $filename;
	}

	while (have_posts()) {
		the_post();
		
		$id 		= get_the_ID();
		$title		= get_the_title($id);
		$time		= get_the_time('U', $id);
		$modified	= get_the_modified_date('U');
		$permalink 	= get_permalink($id);
		$post_tags 	= get_the_tags($id);
		$exerpt 	= get_the_excerpt($id);
		
		if ($tag_seperator != "notags") {
		
			if ($post_tags) {
				foreach($post_tags as $tag) {
					$tags = $tags . $tag->name . $tag_seperator;
				}
			}
			$body 		= $body."<DT><A HREF=\"$permalink\" ADD_DATE=\"$time\" LAST_MODIFIED=\"$modified\" TAGS=\"$tags\">$title</A>\n<DD>$exerpt\n(tags: $tags)\n";
		} else {
			$body 		= $body."<DT><A HREF=\"$permalink\" ADD_DATE=\"$time\" LAST_MODIFIED=\"$modified\" ICON_URI=\"\" ICON=\"\" LAST_CHARSET=\"UTF-8\">$title</A>\n<DD>$exerpt\n";
		}
		
		$id 		= null;
		$title		= null;
		$time		= null;
		$title  	= null;
		$modified	= null;
		$permalink 	= null;
		$post_tags 	= null;
		$exerpt 	= null;		
		$tags		= null;
		$post_tags 	= null;
		$tag		= null;
	}
	
	$head		= 	"<!DOCTYPE NETSCAPE-Bookmark-file-1>\n".
			  		"<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=UTF-8\">\n".
				  	"<TITLE>Bookmarks</TITLE>\n".
				  	"<H1>Bookmarks</H1>\n".
				  	"<DL><p>\n";
				  
 	$foot		= "</DL><p>\n";
 	
 	$complete 	= $head.$body.$foot;
 	
 	header('Content-Type: application/download');
	header('Content-Disposition: attachment; filename="' . $filename . '.html"');
	
 	echo $complete;
?>