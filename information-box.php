<?php
/*
  Plugin Name: Affiliate/Information Link Box
  Plugin URI: https://github.com/robogeek/wp-ebook-maker
  Description: A box for your content to display information or an affiliate product
  Version: 0.1.0
  Author: David Herron
  Author URI: http://davidherron.com/wordpress
  slug: info-affiliate-box
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

/**
 * TODO:
 *
 * a) fix admin screen so Label and TextField are on same row, rather than split
 * b) noskim, nofollow
 * c) special handling for various destinations
 * z) zazzle.com
 *
 * For configuring Rakuten merchant ID's
 *
 * 1) add a new option pane in the accordion
 * 2) give it a big textarea
 * 3) give instructions to enter lines with "domain.com ID" values
 *
 * Ideally this would have an appropriate UI.
 *
 * For example, a table where each row is one domain.com
 * Each row has textfield for domain.com, and the ID, as well as DELETE and EDIT buttons
 * At the bottom is an empty row, with an ADD button instead of DELETE
 **/

define("DHAFFPRODUCTDIR", plugin_dir_path( __FILE__ ));
define("DHAFFPRODUCTURL", plugin_dir_url( __FILE__ ));

if (is_admin()) {
	require_once DHAFFPRODUCTDIR.'admin.php';
}

function dh_affproduct_shortcode($atts, $content = "") {
    
	$amzncode    = get_option('dh_affproduct_amazon_code');
	$rakutenid     = get_option('dh_affproduct_rakuten_id');
    
    // TODO: Configure
    $rakutendata = array(
        'example.com' => array(
            "mid" => "EXAMPLE"
        ),
        'refurb.io' => array(
            "mid" => "40098"
        ),
        'dreamstime.com' => array(
            "mid" => "39291"
        ),
        'marketing.rakuten.com' => array(
            "mid" => "560"
        ),
        'rakuten.com' => array(
            "mid" => "36342"
        ),
        'buy.com' => array(
            "mid" => "36342"
        ),
        'shambhala.com' => array(
            "mid" => "35631"
        ),
        'heartmath.com' => array(
            "mid" => "35610"
        ),
        'interstatebatteries.com' => array(
            "mid" => "2898"
        ),
        'relaxtheback.com' => array(
            "mid" => "2750"
        ),
        'alibris.com' => array(
            "mid" => "2653"
        ),
        'gaiam.com' => array(
            "mid" => "2311"
        ),
        'beadroom.com' => array(
            "mid" => "1139"
        )
    );

	$thumbfloat    = get_option('dh_affproduct_thumb_float', 'right');
	$thumbmaxwidth = get_option('dh_affproduct_thumb_maxwidth', '200px');
	$float         = get_option('dh_affproduct_box_float');
	$maxwidth      = get_option('dh_affproduct_box_maxwidth');
	$padding       = get_option('dh_affproduct_box_padding');
	$margin        = get_option('dh_affproduct_box_margin');
	$border        = get_option('dh_affproduct_box_border');
	$background    = get_option('dh_affproduct_box_background');
	$linkslabel    = get_option('dh_affproduct_box_linkslabel');
    
    $links = '';
    $thumbimg = '';
    
    foreach ($atts as $key => $value) {
        // thumb ==> create <img> tag
        if ($key === 'thumburl') {
            $thumbimg = <<<IMG
<span class="affproduct-img" style="float: $thumbfloat">
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
        
        // asinANYTHING ==> amazon.com link
        $asinloc = strpos($key, 'asin');
        if ($asinloc !== false && $asinloc === 0) {
            $links .= " [<a rel='nofollow noskim' href='http://www.amazon.com/dp/$value?tag=$amzncode'>amazon.com</a>]";
            continue;
        }
        
        $urlloc = strpos($key, 'url');
        if ($urlloc !== false && $urlloc === 0) {
            $afflink = $value;
            $reltext = 'nofollow noskim';
			$urlParts = parse_url($value);
            
            // If this is a Rakuten/Linkshare affiliate, it needs special treatment
            foreach ($rakutendata as $rakutenhost => $rakdata) {
                if (dh_affproduct_domainEndsWith($urlParts['host'], $rakutenhost)) {
                    // This is a known Rakuten/Linkshare host, set up special link
                    if (dh_affproduct_domainEndsWith($urlParts['host'], "rakuten.com")) {
                        $afflinkbase = "http://affiliate.rakuten.com/";
                    } else if (dh_affproduct_domainEndsWith($urlParts['host'], "walmart.com")) {
                        $afflinkbase = "http://linksynergy.walmart.com/";
                    } else {
                        $afflinkbase = "http://click.linksynergy.com/";
                    }
                    $urlEncoded = urlencode($value);
                    $afflink = $afflinkbase ."deeplink?id={$rakutenid}&mid={$rakdata['mid']}&murl={$urlEncoded}";
                    $reltext = 'nofollow noskim';
                }
            }
            
            $links .= " [<a rel='$reltext' href='$afflink'>". $urlParts['host'] ."</a>]";
            continue;
        }
        
    }
    
    if (!empty($float))      $float       = "float: $float;";
    if (!empty($maxwidth))   $maxwidth    = "max-width: $maxwidth;";
    if (!empty($padding))    $padding     = "padding: $padding;";
    if (!empty($margin))     $margin      = "margin: $margin;";
    if (!empty($border))     $border      = "border: $border;";
    if (!empty($background)) $background  = "background: $background;";
    
    $ret = <<<EOD
<div class="affproduct-block" style="{$border}{$background}{$float}{$maxwidth}{$padding}{$margin}">
$thumbimg
<span class="affproduct-title">$title</span>
<span class="affproduct-content">$content</span>
<span class="affproduct-links">{$linkslabel}{$links}</span>
</div>
EOD;
	return $ret;
}
add_shortcode('affproduct', 'dh_affproduct_shortcode');

function dh_affproduct_domainEndsWith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && stripos($haystack, $needle, $temp) !== FALSE);
}
