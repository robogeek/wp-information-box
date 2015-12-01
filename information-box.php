<?php
/*
  Plugin Name: Information Link Box
  Plugin URI: https://github.com/robogeek/wp-information-box
  Description: A inline or aside box to display information with links
  Version: 0.1.3
  Author: David Herron
  Author URI: http://davidherron.com/wordpress
  slug: information-box
  License: GPLv2 or later

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define("DHINFOBOXDIR", plugin_dir_path( __FILE__ ));
define("DHINFOBOXURL", plugin_dir_url( __FILE__ ));

if (is_admin()) {
	require_once DHINFOBOXDIR.'admin.php';
}

function dh_infobox_shortcode($atts, $content = "") {
    

	$thumbfloat    = get_option('dh_infobox_thumb_float', 'right');
	$thumbmaxwidth = get_option('dh_infobox_thumb_maxwidth', '200px');
	$float         = get_option('dh_infobox_box_float');
	$maxwidth      = get_option('dh_infobox_box_maxwidth');
	$padding       = get_option('dh_infobox_box_padding');
	$margin        = get_option('dh_infobox_box_margin');
	$border        = get_option('dh_infobox_box_border');
	$background    = get_option('dh_infobox_box_background');
	$linkslabel    = get_option('dh_infobox_box_linkslabel');
    
    $links = '';
    $thumbimg = '';
    
    foreach ($atts as $key => $value) {
        // thumb ==> create <img> tag
        if ($key === 'thumburl') {
            $thumbimg = <<<IMG
<span class="infobox-img" style="float: $thumbfloat">
<img src='$value' align='$thumbfloat' style='max-width: $thumbmaxwidth;'>
</span>
IMG;
            continue;
        }
        
        // thumbfloat ==> style="... float: $value ..."
        if ($key === 'thumbfloat') {
            $thumbfloat = $value;
            continue;
        }
        
        // thumbmaxwidth ==> style="... max-width: $value ..."
        if ($key === 'thumbmaxwidth') {
            $thumbmaxwidth = $value;
            continue;
        }
        
        // float ==> style="... float: $value ..."
        if ($key === 'float') {
            $float = $value;
            continue;
        }
        
        // maxwidth ==> style="... max-width: $value ..."
        if ($key === 'maxwidth') {
            $maxwidth = $value;
            continue;
        }
        
        // padding ==> style="... padding: $value ..."
        if ($key === 'padding') {
            $padding = $value;
            continue;
        }
        
        // margin ==> style="... margin: $value ..."
        if ($key === 'margin') {
            $margin = $value;
            continue;
        }
        
        // border ==> style="... border: $value ..."
        if ($key === 'border') {
            $border = $value;
            continue;
        }
        
        // background ==> style="... background: $value ..."
        if ($key === 'background') {
            $background = $value;
            continue;
        }
        
        // linkslabel ==> $linkslabel: $links
        if ($key === 'linkslabel') {
            $linkslabel = $value;
            continue;
        }
        
        // title ==> <h4>title</h4>
        if ($key === 'title') {
            $title = "<h4>$value</h4>";
            continue;
        }
        
        $urlloc = strpos($key, 'url');
        if ($urlloc !== false && $urlloc === 0) {
            $linktext = $value;
            $reltext = 'nofollow noskim';
            $urlParts = parse_url($linktext);
            $links .= " [<a rel='$reltext' href='$linktext'>". $urlParts['host'] ."</a>]";
            continue;
        }
        
    }

    $content = do_shortcode($content);

    if (!empty($float))      $float       = "float: $float;";
    if (!empty($maxwidth))   $maxwidth    = "max-width: $maxwidth;";
    if (!empty($padding))    $padding     = "padding: $padding;";
    if (!empty($margin))     $margin      = "margin: $margin;";
    if (!empty($border))     $border      = "border: $border;";
    if (!empty($background)) $background  = "background: $background;";
    
    $ret = <<<EOD
<div class="infobox-block" style="{$border}{$background}{$float}{$maxwidth}{$padding}{$margin}">
$thumbimg
<span class="infobox-title">$title</span>
<span class="infobox-content">$content</span>
<span class="infobox-links">{$linkslabel}{$links}</span>
</div>
EOD;
	return $ret;
}
add_shortcode('infobox', 'dh_infobox_shortcode');

// moot?
function dh_infobox_domainEndsWith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && stripos($haystack, $needle, $temp) !== FALSE);
}
