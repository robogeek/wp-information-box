<?php

/*
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


function dh_affproduct_admin_enqueue_scripts($hook) {
    global $wp_scripts;
    wp_enqueue_script('dhaffproduct-admin', DHAFFPRODUCTURL . 'js/admin.js', array('jquery-ui-accordion'));
    $queryui = $wp_scripts->query('jquery-ui-core');
    $url = "https://ajax.googleapis.com/ajax/libs/jqueryui/" . $queryui->ver . "/themes/smoothness/jquery-ui.css";
    wp_enqueue_style('jquery-ui-start', $url, false, null);
}
add_action( 'admin_enqueue_scripts', 'dh_affproduct_admin_enqueue_scripts');

function dh_affproduct_admin_style() {
	global $pluginsURI;
	wp_register_style('dh_affproduct_admin_css', esc_url(plugins_url('css/admin-style.css', __FILE__)), false, '1.0');
	wp_enqueue_style('dh_affproduct_admin_css');
}

add_action( 'admin_enqueue_scripts', 'dh_affproduct_admin_style' );

add_action('admin_menu', 'dh_affproduct_plugin_menu');
add_action('admin_init', 'register_dh_affproduct_settings');

function register_dh_affproduct_settings() {
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_amazon_code');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_rakuten_id');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_thumb_float');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_thumb_maxwidth');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_box_float');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_box_maxwidth');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_box_padding');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_box_margin');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_box_border');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_box_background');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_box_linkslabel');
	register_setting('dh-affproduct-settings-group', 'dh_affproduct_rakuten_mids');
}

function dh_affproduct_plugin_menu() {
	add_options_page('Affiliate/Information Link Box', 'Affiliate/Information Link Box',
					 'manage_options', 'dh_affproduct_option_page', 'dh_affproduct_option_page_fn');
}

function dh_affproduct_option_page_fn() {
	$dh_affproduct_amazon_code    = get_option('dh_affproduct_amazon_code');
	$dh_affproduct_rakuten_id     = get_option('dh_affproduct_rakuten_id');
	$dh_affproduct_thumb_float    = get_option('dh_affproduct_thumb_float');
	$dh_affproduct_thumb_maxwidth = get_option('dh_affproduct_thumb_maxwidth');
	$dh_affproduct_box_float      = get_option('dh_affproduct_box_float');
	$dh_affproduct_box_maxwidth   = get_option('dh_affproduct_box_maxwidth');
	$dh_affproduct_box_padding    = get_option('dh_affproduct_box_padding');
	$dh_affproduct_box_margin     = get_option('dh_affproduct_box_margin');
	$dh_affproduct_box_border     = get_option('dh_affproduct_box_border');
	$dh_affproduct_box_background = get_option('dh_affproduct_box_background');
	$dh_affproduct_box_linkslabel = get_option('dh_affproduct_box_linkslabel');
	$dh_affproduct_rakuten_mids   = get_option('dh_affproduct_rakuten_mids');
	?>
	<div class="wrap">
		<h2>Affiliate/Information Link Box</h2>
		<div class="content_wrapper">
			<div class="left">
                    
        <div id="accordion">
        <h3>Affiliate ID codes</h3>
                    
        <div>
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('dh-affproduct-settings-group'); ?>
				
				<input type="hidden"
					   name="dh_affproduct_thumb_float"
					   value="<?php echo $dh_affproduct_thumb_float; ?>">
				<input type="hidden"
					   name="dh_affproduct_thumb_maxwidth"
					   value="<?php echo $dh_affproduct_thumb_maxwidth; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_float"
					   value="<?php echo $dh_affproduct_box_float; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_maxwidth"
					   value="<?php echo $dh_affproduct_box_maxwidth; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_padding"
					   value="<?php echo $dh_affproduct_box_padding; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_margin"
					   value="<?php echo $dh_affproduct_box_margin; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_border"
					   value="<?php echo $dh_affproduct_box_border; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_background"
					   value="<?php echo $dh_affproduct_box_background; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_linkslabel"
					   value="<?php echo $dh_affproduct_box_linkslabel; ?>">
				<input type="hidden"
					   name="dh_affproduct_rakuten_mids"
					   value="<?php echo $dh_affproduct_rakuten_mids; ?>">
				
				<div>
				<label for="dh_affproduct_amazon_code"><strong><?php _e( 'Amazon Affiliate Code:' ); ?></strong></label> 
				<input  id="dh_affproduct_amazon_code" name="dh_affproduct_amazon_code" type="text"
					   value="<?php echo esc_attr($dh_affproduct_amazon_code); ?>">
				</div>
				
				<p>Enter your Amazon affiliate tracking code for this website.</p>
				
				<div>
				<label for="dh_affproduct_rakuten_id"><strong><?php _e( 'Linkshare/Rakuten Affiliate Code:' ); ?></strong></label> 
				<input id="dh_affproduct_rakuten_id" name="dh_affproduct_rakuten_id" type="text"
					   value="<?php echo esc_attr($dh_affproduct_rakuten_id); ?>">
				</div>
				
				<p>Enter your Linkshare/Rakuten affiliate code.  To get this code:</p>
				<ul style="list-style: disc; list-style-position: inside;">
					<li>Sign up with the <a href="http://click.linksynergy.com/fs-bin/click?id=PPTIpcZ17qI&offerid=311675.10000156&type=3&subid=0&LSNSUBSITE=LSNSUBSITE">Rakuten Affiliate Marketing program</a></li>
					<li>Join one or more programs</li>
					<li>Click on Programs => My Advertisers</li>
					<li>Click on one of them, then click on Get Links</li>
					<li>Select one of the link types, select one of the links offered</li>
					<li>Click on <em>Get Link</em> and in the dialog box look the URL provided.  Copy the value of the <tt>id=</tt> parameter in the URL.</li>
				</ul>
				<p>Every link Rakuten generates for you has the same <tt>id=</tt> parameter.  It's different from the affiliate ID that shows elsewhere on the Rakuten dashboard.
				</p>
		
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
				
        </div>
        
        <h3>Thumbnail Styling</h3>
        
        <div>
			
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('dh-affproduct-settings-group'); ?>
							
				<input type="hidden"
					   name="dh_affproduct_amazon_code"
					   value="<?php echo $dh_affproduct_amazon_code; ?>">
				<input type="hidden"
					   name="dh_affproduct_rakuten_id"
					   value="<?php echo $dh_affproduct_rakuten_id; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_float"
					   value="<?php echo $dh_affproduct_box_float; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_maxwidth"
					   value="<?php echo $dh_affproduct_box_maxwidth; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_padding"
					   value="<?php echo $dh_affproduct_box_padding; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_margin"
					   value="<?php echo $dh_affproduct_box_margin; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_border"
					   value="<?php echo $dh_affproduct_box_border; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_background"
					   value="<?php echo $dh_affproduct_box_background; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_linkslabel"
					   value="<?php echo $dh_affproduct_box_linkslabel; ?>">
				<input type="hidden"
					   name="dh_affproduct_rakuten_mids"
					   value="<?php echo $dh_affproduct_rakuten_mids; ?>">
							
				<div>
				<label for="dh_affproduct_thumb_float"><strong><?php _e( 'Thumbnail Float right/left:' ); ?></strong></label>
				
				<input type="radio" name="dh_affproduct_thumb_float" value="none" <?php
				if (!empty($dh_affproduct_thumb_float) && $dh_affproduct_thumb_float === "none") {
					?>checked<?php
				}
				?> >None
				<input type="radio" name="dh_affproduct_thumb_float" value="left" <?php
				if (!empty($dh_affproduct_thumb_float) && $dh_affproduct_thumb_float === "left") {
					?>checked<?php
				}
				?> >Left
				<input type="radio" name="dh_affproduct_thumb_float" value="right" <?php
				if (!empty($dh_affproduct_thumb_float) && $dh_affproduct_thumb_float === "right") {
					?>checked<?php
				}
				?> >Right
				
				</div>
				
				<p> This becomes a <tt>float: .. ;</tt> CSS property on the thumbnail image</p>
				
				<div>
				<label for="dh_affproduct_thumb_maxwidth"><strong><?php _e( 'Thumbnail Max-Width:' ); ?></strong></label> 
				<input id="dh_affproduct_thumb_maxwidth" name="dh_affproduct_thumb_maxwidth" type="text"
					   value="<?php echo esc_attr($dh_affproduct_thumb_maxwidth); ?>">
				</div>
				
				<p>Enter a string either like "150px" or "90%".  This becomes the <tt>max-width: .. ;</tt> property on the thumbnail image.</p>
				
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
				
        </div>
        
        <h3>Outer Box Styling</h3>
        
        <div>
			
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('dh-affproduct-settings-group'); ?>
							
				<input type="hidden"
					   name="dh_affproduct_amazon_code"
					   value="<?php echo $dh_affproduct_amazon_code; ?>">
				<input type="hidden"
					   name="dh_affproduct_rakuten_id"
					   value="<?php echo $dh_affproduct_rakuten_id; ?>">
				<input type="hidden"
					   name="dh_affproduct_thumb_float"
					   value="<?php echo $dh_affproduct_thumb_float; ?>">
				<input type="hidden"
					   name="dh_affproduct_thumb_maxwidth"
					   value="<?php echo $dh_affproduct_thumb_maxwidth; ?>">
				<input type="hidden"
					   name="dh_affproduct_rakuten_mids"
					   value="<?php echo $dh_affproduct_rakuten_mids; ?>">
				
				<div>
				<label for="dh_affproduct_box_float"><strong><?php _e( 'Float right/left:' ); ?></strong></label>
				<input type="radio" name="dh_affproduct_box_float" value="none" <?php
				if (!empty($dh_affproduct_box_float) && $dh_affproduct_box_float === "none") {
					?>checked<?php
				}
				?> >None
				<input type="radio" name="dh_affproduct_box_float" value="left" <?php
				if (!empty($dh_affproduct_box_float) && $dh_affproduct_box_float === "left") {
					?>checked<?php
				}
				?> >Left
				<input type="radio" name="dh_affproduct_box_float" value="right" <?php
				if (!empty($dh_affproduct_box_float) && $dh_affproduct_box_float === "right") {
					?>checked<?php
				}
				?> >Right
				
				</div>
				
				<p>This becomes a <tt>float: .. ;</tt> CSS property on the outermost &lt;div&gt; of the box.</p>
				
				<div>
				<label for="dh_affproduct_box_maxwidth"><strong><?php _e( 'Max-Width:' ); ?></strong></label> 
				<input id="dh_affproduct_box_maxwidth" name="dh_affproduct_box_maxwidth" type="text"
					   value="<?php echo esc_attr($dh_affproduct_box_maxwidth); ?>">
				</div>
				
				<p>Enter a string either like "150px" or "90%".  This becomes the <tt>max-width: .. ;</tt> property on the outermost &lt;div&gt; of the box.</p>
				
				<div>
				<label for="dh_affproduct_box_padding"><strong><?php _e( 'Padding:' ); ?></strong></label> 
				<input id="dh_affproduct_box_padding" name="dh_affproduct_box_padding" type="text"
					   value="<?php echo esc_attr($dh_affproduct_box_padding); ?>">
				</div>
				
				<p>Enter an allowable padding value, like <tt>5px</tt>.</p>
				
				<div>
				<label for="dh_affproduct_box_margin"><strong><?php _e( 'Margin:' ); ?></strong></label> 
				<input id="dh_affproduct_box_margin" name="dh_affproduct_box_margin" type="text"
					   value="<?php echo esc_attr($dh_affproduct_box_margin); ?>">
				</div>
				
				<p>Enter an allowable margin value, like <tt>10px</tt>.</p>
				
				<div>
				<label for="dh_affproduct_box_border"><strong><?php _e( 'Border:' ); ?></strong></label> 
				<input id="dh_affproduct_box_border" name="dh_affproduct_box_border" type="text" size="40"
					   value="<?php echo esc_attr($dh_affproduct_box_border); ?>">
				</div>
				
				<p>Enter a CSS border descriptor, like <tt>3px dashed red</tt>.</p>
				
				<div>
				<label for="dh_affproduct_box_background"><strong><?php _e( 'Background:' ); ?></strong></label> 
				<input id="dh_affproduct_box_background" name="dh_affproduct_box_background" type="text"
					   value="<?php echo esc_attr($dh_affproduct_box_background); ?>">
				</div>
				
				<p>Enter an allowable background value, like <tt>#eeeeee</tt>.</p>
				
				<div>
				<label for="dh_affproduct_box_linkslabel"><strong><?php _e( 'Label:' ); ?></strong></label> 
				<input id="dh_affproduct_box_linkslabel" name="dh_affproduct_box_linkslabel" type="text" size="40"
					   value="<?php echo esc_attr($dh_affproduct_box_linkslabel); ?>">
				</div>
				
				<p>Enter the string to put before the links, such as <tt>&lt;strong&gt;Buy&lt;/strong&gt;</tt></p>
		
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
				
        </div>
		
		<h3>Linkshare Merchant ID's</h3>
        
		<div>
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('dh-affproduct-settings-group'); ?>
				<input type="hidden"
					   name="dh_affproduct_amazon_code"
					   value="<?php echo $dh_affproduct_amazon_code; ?>">
				<input type="hidden"
					   name="dh_affproduct_rakuten_id"
					   value="<?php echo $dh_affproduct_rakuten_id; ?>">
				<input type="hidden"
					   name="dh_affproduct_thumb_float"
					   value="<?php echo $dh_affproduct_thumb_float; ?>">
				<input type="hidden"
					   name="dh_affproduct_thumb_maxwidth"
					   value="<?php echo $dh_affproduct_thumb_maxwidth; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_float"
					   value="<?php echo $dh_affproduct_box_float; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_maxwidth"
					   value="<?php echo $dh_affproduct_box_maxwidth; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_padding"
					   value="<?php echo $dh_affproduct_box_padding; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_margin"
					   value="<?php echo $dh_affproduct_box_margin; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_border"
					   value="<?php echo $dh_affproduct_box_border; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_background"
					   value="<?php echo $dh_affproduct_box_background; ?>">
				<input type="hidden"
					   name="dh_affproduct_box_linkslabel"
					   value="<?php echo $dh_affproduct_box_linkslabel; ?>">
				
				<textarea name="dh_affproduct_rakuten_mids" width="100%" rows="10" cols="50"><?php
					echo $dh_affproduct_rakuten_mids;
				?></textarea>
				
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
		</div>
		
        </div>
            </div>
        </div>
    </div>
<?php
}

function dh_affproduct_affiliate_codes_fn() {
    ?>
	<div class="wrap">
		<h2>Affiliate Codes</h2>
		<div class="content_wrapper">
        </div>
    </div>
<?php
}
