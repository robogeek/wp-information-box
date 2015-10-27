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


function dh_infobox_admin_enqueue_scripts($hook) {
    global $wp_scripts;
    wp_enqueue_script('infobox-admin', DHINFOBOXURL . 'js/admin.js', array('jquery-ui-accordion'));
    $queryui = $wp_scripts->query('jquery-ui-core');
    $url = "https://ajax.googleapis.com/ajax/libs/jqueryui/" . $queryui->ver . "/themes/smoothness/jquery-ui.css";
    wp_enqueue_style('jquery-ui-start', $url, false, null);
}
add_action('admin_enqueue_scripts', 'dh_infobox_admin_enqueue_scripts');

function dh_infobox_admin_style() {
	global $pluginsURI;
	wp_register_style('dh_infobox_admin_css', esc_url(plugins_url('css/admin-style.css', __FILE__)), false, '1.0');
	wp_enqueue_style('dh_infobox_admin_css');
}

add_action('admin_enqueue_scripts', 'dh_infobox_admin_style');

add_action('admin_menu', 'dh_infobox_plugin_menu');
add_action('admin_init', 'register_dh_infobox_settings');

function register_dh_infobox_settings() {
	register_setting('dh-infobox-settings-thumb', 'dh_infobox_thumb_float');
	register_setting('dh-infobox-settings-thumb', 'dh_infobox_thumb_maxwidth');
	register_setting('dh-infobox-settings-outerbox', 'dh_infobox_box_float');
	register_setting('dh-infobox-settings-outerbox', 'dh_infobox_box_maxwidth');
	register_setting('dh-infobox-settings-outerbox', 'dh_infobox_box_padding');
	register_setting('dh-infobox-settings-outerbox', 'dh_infobox_box_margin');
	register_setting('dh-infobox-settings-outerbox', 'dh_infobox_box_border');
	register_setting('dh-infobox-settings-outerbox', 'dh_infobox_box_background');
	register_setting('dh-infobox-settings-outerbox', 'dh_infobox_box_linkslabel');
}

function dh_infobox_plugin_menu() {
	add_options_page('Affiliate/Information Link Box', 'Affiliate/Information Link Box',
					 'manage_options', 'dh_infobox_option_page', 'dh_infobox_option_page_fn');
}

function dh_infobox_option_page_fn() {
	$dh_infobox_thumb_float    = get_option('dh_infobox_thumb_float');
	$dh_infobox_thumb_maxwidth = get_option('dh_infobox_thumb_maxwidth');
	$dh_infobox_box_float      = get_option('dh_infobox_box_float');
	$dh_infobox_box_maxwidth   = get_option('dh_infobox_box_maxwidth');
	$dh_infobox_box_padding    = get_option('dh_infobox_box_padding');
	$dh_infobox_box_margin     = get_option('dh_infobox_box_margin');
	$dh_infobox_box_border     = get_option('dh_infobox_box_border');
	$dh_infobox_box_background = get_option('dh_infobox_box_background');
	$dh_infobox_box_linkslabel = get_option('dh_infobox_box_linkslabel');
	?>
	<div class="wrap">
		<h2>Affiliate/Information Link Box</h2>
		<div class="content_wrapper">
			<div class="left">
                    
        <div id="accordion">
        
        <h3>Thumbnail Styling</h3>
        
        <div>
			
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields('dh-affproduct-settings-thumb'); ?>
							
				<div>
				<label for="dh_infobox_thumb_float"><strong><?php _e('Thumbnail Float right/left:'); ?></strong></label>
				
				<input type="radio" name="dh_infobox_thumb_float" value="none" <?php
				if (!empty($dh_infobox_thumb_float) && $dh_infobox_thumb_float === "none") {
					?>checked<?php
				}
				?> >None
				<input type="radio" name="dh_infobox_thumb_float" value="left" <?php
				if (!empty($dh_infobox_thumb_float) && $dh_infobox_thumb_float === "left") {
					?>checked<?php
				}
				?> >Left
				<input type="radio" name="dh_infobox_thumb_float" value="right" <?php
				if (!empty($dh_infobox_thumb_float) && $dh_infobox_thumb_float === "right") {
					?>checked<?php
				}
				?> >Right
				
				</div>
				
				<p> This becomes a <tt>float: .. ;</tt> CSS property on the thumbnail image</p>
				
				<div>
				<label for="dh_infobox_thumb_maxwidth"><strong><?php _e('Thumbnail Max-Width:'); ?></strong></label> 
				<input id="dh_infobox_thumb_maxwidth" name="dh_infobox_thumb_maxwidth" type="text"
					   value="<?php echo esc_attr($dh_infobox_thumb_maxwidth); ?>">
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
				<?php settings_fields('dh-affproduct-settings-outerbox'); ?>

				<div>
				<label for="dh_infobox_box_float"><strong><?php _e('Float right/left:'); ?></strong></label>
				<input type="radio" name="dh_infobox_box_float" value="none" <?php
				if (!empty($dh_infobox_box_float) && $dh_infobox_box_float === "none") {
					?>checked<?php
				}
				?> >None
				<input type="radio" name="dh_infobox_box_float" value="left" <?php
				if (!empty($dh_infobox_box_float) && $dh_infobox_box_float === "left") {
					?>checked<?php
				}
				?> >Left
				<input type="radio" name="dh_infobox_box_float" value="right" <?php
				if (!empty($dh_infobox_box_float) && $dh_infobox_box_float === "right") {
					?>checked<?php
				}
				?> >Right
				
				</div>
				
				<p>This becomes a <tt>float: .. ;</tt> CSS property on the outermost &lt;div&gt; of the box.</p>
				
				<div>
				<label for="dh_infobox_box_maxwidth"><strong><?php _e('Max-Width:'); ?></strong></label> 
				<input id="dh_infobox_box_maxwidth" name="dh_infobox_box_maxwidth" type="text"
					   value="<?php echo esc_attr($dh_infobox_box_maxwidth); ?>">
				</div>
				
				<p>Enter a string either like "150px" or "90%".  This becomes the <tt>max-width: .. ;</tt> property on the outermost &lt;div&gt; of the box.</p>
				
				<div>
				<label for="dh_infobox_box_padding"><strong><?php _e('Padding:'); ?></strong></label> 
				<input id="dh_infobox_box_padding" name="dh_infobox_box_padding" type="text"
					   value="<?php echo esc_attr($dh_infobox_box_padding); ?>">
				</div>
				
				<p>Enter an allowable padding value, like <tt>5px</tt>.</p>
				
				<div>
				<label for="dh_infobox_box_margin"><strong><?php _e( 'Margin:' ); ?></strong></label> 
				<input id="dh_infobox_box_margin" name="dh_infobox_box_margin" type="text"
					   value="<?php echo esc_attr($dh_infobox_box_margin); ?>">
				</div>
				
				<p>Enter an allowable margin value, like <tt>10px</tt>.</p>
				
				<div>
				<label for="dh_infobox_box_border"><strong><?php _e('Border:'); ?></strong></label> 
				<input id="dh_infobox_box_border" name="dh_infobox_box_border" type="text" size="40"
					   value="<?php echo esc_attr($dh_infobox_box_border); ?>">
				</div>
				
				<p>Enter a CSS border descriptor, like <tt>3px dashed red</tt>.</p>
				
				<div>
				<label for="dh_infobox_box_background"><strong><?php _e('Background:'); ?></strong></label> 
				<input id="dh_infobox_box_background" name="dh_infobox_box_background" type="text"
					   value="<?php echo esc_attr($dh_infobox_box_background); ?>">
				</div>
				
				<p>Enter an allowable background value, like <tt>#eeeeee</tt>.</p>
				
				<div>
				<label for="dh_infobox_box_linkslabel"><strong><?php _e('Label:'); ?></strong></label> 
				<input id="dh_infobox_box_linkslabel" name="dh_infobox_box_linkslabel" type="text" size="40"
					   value="<?php echo esc_attr($dh_infobox_box_linkslabel); ?>">
				</div>
				
				<p>Enter the string to put before the links, such as <tt>&lt;strong&gt;Buy&lt;/strong&gt;</tt></p>
		
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
