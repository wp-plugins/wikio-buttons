<?php
/*
	Plugin Name: Wikio Buttons
	Plugin URI: http://wikio.com
	Description: Compatible Worpress 2.3 and above. <a href="themes.php?page=wikio-buttons/wikio-buttons.php">Configure it.</a>
	Version: 0.1.8
	Author: Wikio
	Author URI: http://wikio.com
	
	Copyright 2009  Wikio  (email : info@wikio.com)
	
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


// Version ?
	$wikio_plugin_version = "0.1.8";
	
// Where is the plugin?
	$wikio_plugin_place = PLUGINDIR.'/'.dirname(plugin_basename(__FILE__));

// Where are the pics?
	$wikio_plugin_image_dir = get_bloginfo( 'wpurl' ).'/'.$wikio_plugin_place.'/images';

// Localisation
	$wikio_domain = 'wikio-buttons';
	
	load_plugin_textdomain($wikio_domain, PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)));

// All the services
	// All the share items
	$wikio_share_items = array('wikio-share', 'facebook', 'delicious', 'digg', 'googlebookmarks','live-share', 'misterwong', 'myspace', 'newsvine', 'reddit', 'technorati', 'twitter', 'blogmarks', 'yahoobookmarks', 'furl', 'ask', 'mixx', 'spurl', 'magnolia', 'segnalo', 'netvouz', 'fark', 'propeller', 'multiply', 'simpy', 'diigo', 'bluedot', 'linkagogo', 'feedmelinks', 'backflip');
	
	// all the sub items
	$wikio_sub_items = array('wikio', 'netvibes', 'google', 'yahoo', 'bloglines', 'aol', 'msn', 'newsgator', 'pageflakes', 'live', 'rojo', 'rss', 'technorati');
	
	// all the widgets items
	$wikio_widgets_items = array('vista','macos');
	
	// Write default values
	if (!get_option( 'wikio_share_options' )){
		foreach ( $wikio_share_items as $key )
			{
			$wikio_share_option[$key] = $key;
			update_option( wikio_share_options, $wikio_share_option );
			}
	}
	
	if (!get_option( 'wikio_sub_options' )){
		foreach ( $wikio_sub_items as $key )
			{
			$wikio_sub_option[$key] = $key;
			update_option( wikio_sub_options, $wikio_sub_option );
			}
	}
	
	if (!get_option( 'wikio_widgets_options' )){
		foreach ( $wikio_widgets_items as $key_w )
			{
			$wikio_widgets_option[$key_w] = $key_w;
			update_option( wikio_widgets_options, $wikio_widgets_option );
			}
	}
	
	if (!get_option( 'wikio_vote_auto' )){
		update_option( wikio_vote_auto, '0' );
	}
	
	if (!get_option( 'wikio_share_auto' )){
		update_option( wikio_share_auto, 0 );
	}
	
	if (!get_option( 'wikio_share_display' )){
		update_option( wikio_share_display, 0 );
	}
	
	if (!get_option( 'wikio_sub_auto' )){
		update_option( wikio_sub_auto, '0' );
	}

	if (!get_option( 'wikio_sub_title' )){
		update_option( wikio_sub_title, htmlentities(__('S\'abonner',$wikio_domain)) );
	}
	
	// 1 = horizontaly
	if (!get_option( 'wikio_align' )){
		update_option( wikio_align, 0 );
	}
	
	// My wikio
	if (!get_option( 'wikio_tld' )){
		update_option( wikio_tld, 'com' );
	}
	
	// Top Blog badge
	if (!get_option( 'wikio_top_auto' )){
		update_option( wikio_top_auto, '0' );
	}
	
	// Top Blog Title
	if (!get_option( 'wikio_top_title' )){
		update_option( wikio_top_title, htmlentities(__('Top des blogs',$wikio_domain)) );
	}
	
	// Top Blog style
	if (!get_option( 'wikio_top_style' )){
		update_option( wikio_top_style, '1' );
	}
	
	//// Top Blog categ display
//	if (!get_option( 'wikio_top_categ' )){
//		update_option( wikio_top_categ, '1' );
//	}
//	
//	// Top Blog general display
//	if (!get_option( 'wikio_top_gen' )){
//		update_option( wikio_top_gen, '1' );
//	}
	
// Hook for adding admin menus
	add_action( 'admin_menu', 'mt_add_pages' );

// Add géneral sylesheet ( ref wikio_admin_head() )
	add_action( 'wp_head', 'wikio_admin_head' );

	
// action function for above hook
	function mt_add_pages() {
		
		// Add a new submenu under Options:
		add_submenu_page( 'themes.php', 'Wikio - Buttons', 'Wikio - Buttons ', 7, __FILE__, 'mt_main_page' );
		
		// Add sylesheet ( ref wikio_admin_head() )
		add_action( 'admin_print_scripts', 'wikio_admin_head' );
		
	}

	function wikio_admin_head() {
	
		global $wikio_plugin_place;
		
		echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo( 'wpurl' ).'/'.$wikio_plugin_place.'/wikio-buttons-style.css" />'."\n";
	}
	


// mt_options_page() displays the page content for the Test Options submenu
	function mt_main_page() {
		
		global $wikio_plugin_place;
		global $wikio_share_items;
		global $wikio_sub_items;
		global $wikio_widgets_items;
		global $wikio_plugin_image_dir;
		global $wikio_domain;
		
		print('<div class="wrap">');
		
		print('<div class="wikio_pack_content">');
		
		?>
		<script type="text/javascript">
			function share(lst)
			{
			 var d=document.getElementById("share_script");
			 
			 if (lst.selectedIndex==1){
			  d.style.display="block"}
			 else{
			  d.style.display="none"}
			}
			
			function sub(lst2)
			{
			 var d2=document.getElementById("sub_script");
			 var info2=document.getElementById("sub_info");
			 
			 if (lst2.selectedIndex==1){
			  d2.style.display="block";
			  info2.style.display="none"}
			 else{
			  d2.style.display="none";
			  info2.style.display="block"}
			}
			
			function vote(lst3)
			{
			 var d3=document.getElementById("vote_script");
			 			 		 
			 if (lst3.selectedIndex==1){
			  d3.style.display="block"
			  }
			 else{
			  d3.style.display="none"
			  }
			}
			
			function top(lst6)
			{
			 var d6=document.getElementById("top_script");
			 var info3=document.getElementById("top_info");
			 		 
			 if (lst6.selectedIndex==1){
			  d6.style.display="block";
			  info3.style.display="none"
			  }
			 else{
			  d6.style.display="none";
			  info3.style.display="block"
			  }
			}
			
			function mywikio(lst4)
			{
			 var info4=document.getElementById("post-query-submit");
			 info4.style.display="inline"
			}
			
			function please_update(lst5)
			{
			 var info5=document.getElementById("post-query-submit-"+lst5);
			 info5.style.display="inline"
			}
			
		</script>
		
		<?php
		
		
		// Check the post results
		if ($_POST['submit']){
			
			//unset ($wikio_share_option);
			$wikio_share_item = $_POST['wikio_share_item'];
			$wikio_share_auto = htmlentities( $_POST['wikio_share_auto'] );
			$wikio_tld = htmlentities( $_POST['wikio_tld'] );
			$wikio_share_display = htmlentities( $_POST['wikio_share_display'] );
			
			if (!is_array($_POST['wikio_share_item'])){$wikio_share_item = array($_POST['wikio_share_item']);}
			
			foreach ( $wikio_share_item as $key ){
				$wikio_share_option[$key] = $key;
				
				// Save the posted value in the database
				update_option( wikio_share_options, $wikio_share_option );
				
			}
			
			
			// save automatic option
			update_option( wikio_share_auto, $wikio_share_auto );
			update_option( wikio_tld, $wikio_tld );
			update_option( wikio_share_display, $wikio_share_display );
			
			// print ok message
			echo'
			<div id="message" class="updated fade below-h2" style="background-color: rgb(255, 251, 204);">
				<p>
				'.__('Mise a jour effectuee',$wikio_domain).'
				</p>
			</div>';
		}
		
		
		// Return all options values
		$wikio_share_options = get_option( 'wikio_share_options' );
		$wikio_align = get_option( 'wikio_align' );
		$wikio_share_display = get_option( 'wikio_share_display' );
		
		
		foreach ( $wikio_share_options as $key=>$value ){
			$wikio_share_option[$key] = $value;
		}
	
		// Return the "auto" value
		$wikio_share_auto = get_option( 'wikio_share_auto' );
		$wikio_tld = get_option( 'wikio_tld' );	
		
			?>
			<!--<p><?php _e('Le plugin Wikio vous permet d\'ajouter un',$wikio_domain); ?> <a href="#wikio_vote"><?php _e('Bouton de vote',$wikio_domain); ?></a> <?php _e('et celui de',$wikio_domain); ?> <a href="#wikio_share"><?php _e('Partage universel',$wikio_domain); ?></a> <?php _e('sous vos articles',$wikio_domain); ?>, <?php _e('un ou plusieurs widgets de news',$wikio_domain); ?>, <a href="#wikio_subscribe"><?php _e('Le bouton d\'abonnement universel',$wikio_domain); ?></a> <?php _e('et le badge',$wikio_domain); ?> <a href="#wikio_top"><?php _e('Top des blogs',$wikio_domain); ?></a>.</p>-->
			
			<h2 id="wikio"><?php _e('Wikio',$wikio_domain); ?></h2>
			<form name="wikio_share_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Quel est votre Wikio',$wikio_domain); ?>&nbsp;?</th>
						<td>
						<select name="wikio_tld" id="wikio_tld" onchange="mywikio(this);">
							<option value="fr" <?php if ($wikio_tld == "fr"){ echo 'selected="selected"';} ?>><?php _e('Wikio.fr (fr)',$wikio_domain); ?></option>
							<option value="it" <?php if ($wikio_tld == "it"){ echo 'selected="selected"';} ?>><?php _e('Wikio.it (it)',$wikio_domain); ?></option>
							<option value="es" <?php if ($wikio_tld == "es"){ echo 'selected="selected"';} ?>><?php _e('Wikio.es (es)',$wikio_domain); ?></option>
							<option value="de" <?php if ($wikio_tld == "de"){ echo 'selected="selected"';} ?>><?php _e('Wikio.de (de)',$wikio_domain); ?></option>
							<option value="com" <?php if ($wikio_tld == "com"){ echo 'selected="selected"';} ?>><?php _e('Wikio.com (us)',$wikio_domain); ?></option>
							<option value="co.uk" <?php if ($wikio_tld == "co.uk"){ echo 'selected="selected"';} ?>><?php _e('Wikio.co.uk (uk)',$wikio_domain); ?></option>
						</select>
						<input id="post-query-submit" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<br /><br />
			<h2 id="wikio_share"><?php _e('Partage universel',$wikio_domain); ?></h2>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Preview',$wikio_domain); ?></th>
						<td><?php if (function_exists('wikio_share_preview')){wikio_share_preview();} ?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Affichage sur la home page',$wikio_domain); ?></th>
						<td>
						<select name="wikio_share_display" onchange="share(this); please_update(22)">
						<option value="0" <?php if ($wikio_share_display == 0){ echo 'selected="selected"';} ?>><?php _e('Oui',$wikio_domain); ?></option>
						<option value="1" <?php if ($wikio_share_display == 1){ echo 'selected="selected"';} ?>><?php _e('Non',$wikio_domain); ?> (<?php _e('Affichage sur les pages d\'article uniquement',$wikio_domain); ?>)</option>
						</select>
						<input id="post-query-submit-22" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
					<th scope="row"><?php _e('Services',$wikio_domain); ?>
					</th>
					<td>
					<div class="wikio_share_form">
					
					<?php
					$n=0;
					foreach ( $wikio_share_items as $key )
					{
						echo'
						<div class="wikio_share_item">
						<label for="wikio_share_item_'.$n.'">
							<input name="wikio_share_item[]" id="wikio_share_item_'.$n.'" type="checkbox" value="'.$key.'"';
							if ($wikio_share_option[$key] == $key){echo ' checked';}
							echo' onchange="please_update(21);" />
							<img src="'.$wikio_plugin_image_dir.'/icon-'.$key.'.gif" alt="'.$key.'" />
						</label>
						</div>
						
						';
					$n++;
					}
					?></div>
					<?php _e('Cochez les cases correspondantes aux services que vous souhaitez ajouter',$wikio_domain); ?>.<br />
					<input id="post-query-submit-21" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
					</td>
					</tr>
				</tbody>
			</table>
			
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Insertion automatique',$wikio_domain); ?></th>
						<td>
						<select name="wikio_share_auto" onchange="share(this); please_update(2)">
						<option value="0" <?php if ($wikio_share_auto == 0){ echo 'selected="selected"';} ?>><?php _e('Oui',$wikio_domain); ?> (<?php _e('recommande',$wikio_domain); ?>)</option>
						<option value="1" <?php if ($wikio_share_auto == 1){ echo 'selected="selected"';} ?>><?php _e('Non',$wikio_domain); ?> (<?php _e('je copie et colle le script ci dessous dans mon template',$wikio_domain); ?>)</option>
				  
						</select>
						<br />
						<div id="share_script" <?php if ($wikio_share_auto == 1){ echo 'style="display:block"';} else { echo 'style="display:none"';} ?>>
							<strong><?php _e('Script a copier / coller',$wikio_domain); ?> :</strong><br />
							<div class="wikio_share_form">
							<textarea name="1" cols="75" rows="1" onfocus="select()"><?php print("<?php if (function_exists( 'wikio_share_alone' )){wikio_share_alone();} ?>"); ?></textarea>
							<br />
							<label for="wikio_sub_title"><?php _e('Si vous le souhaitez, vous pouvez copier et coller ce script directement dans votre template entre les balises suivantes',$wikio_domain); ?> :<br /><strong>&lt;?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?&gt; et &lt;?php endif; ?&gt;
							<br /></strong></label>
							</div>
							
						</div><input id="post-query-submit-2" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			
			<?php
			
			
			
			// update RSS information
			if (!get_option( 'wikio_sub_rss' )){
				
				$rss_2 = urlencode(get_bloginfo('rss2_url'));
				update_option( wikio_sub_rss, $rss_2 );
				
			}
			
			// Check the post results
			if ($_POST['submit']){
				
				// services
				$wikio_sub_item = $_POST['wikio_sub_item'];
				
				// widgets
				$wikio_widgets_item = $_POST['wikio_widgets_item'];
				
				$wikio_sub_title = htmlentities($_POST['wikio_sub_title']);
				$wikio_sub_auto = htmlentities($_POST['wikio_sub_auto']);
				$wikio_sub_rss = urlencode($_POST['wikio_sub_rss']);
				
				if (!is_array($_POST['wikio_sub_item'])){$wikio_sub_item = array($_POST['wikio_sub_item']);}
				
				foreach ( $wikio_sub_item as $key){
					$wikio_sub_option[$key] = $key;
					
					// Save the posted value in the database
					update_option( wikio_sub_options, $wikio_sub_option );
					
				}
				
				if (!is_array($_POST['wikio_widgets_item'])){$wikio_widgets_item = array($_POST['wikio_widgets_item']);}
				
				foreach ( $wikio_widgets_item as $key_w){
					$wikio_widgets_option[$key_w] = $key_w;
					
					// Save the posted value in the database
					update_option( wikio_widgets_options, $wikio_widgets_option );
					
				}
				
				update_option( wikio_sub_title, $wikio_sub_title);
				update_option( wikio_sub_auto, $wikio_sub_auto);
				update_option( wikio_sub_rss, $wikio_sub_rss);
			}
			
			// return options values
				$wikio_sub_options = get_option( 'wikio_sub_options' );
				$wikio_widgets_options = get_option( 'wikio_widgets_options' );
				$wikio_sub_auto = get_option( 'wikio_sub_auto' );
		
				foreach ( $wikio_sub_options as $key=>$value ){
					$wikio_sub_option[$key] = $value;
				}
				
				foreach ( $wikio_widgets_options as $key_w=>$value_w ){
					$wikio_widgets_option[$key_w] = $value_w;
				}
				
			// Return other values
			$wikio_sub_title = stripslashes(html_entity_decode(get_option('wikio_sub_title')));
			$wikio_sub_rss = urldecode(get_option('wikio_sub_rss'));
			
		
		?>
			
			
			<br /><br />
			<h2 id="wikio_subscribe"><?php _e('Abonnement universel',$wikio_domain); ?></h2>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Preview',$wikio_domain); ?></th>
						<td><?php if (function_exists('wikio_sub_preview')){wikio_sub_preview();} ?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Titre du widget',$wikio_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<input id="wikio_sub_title" name="wikio_sub_title" type="text" value="<?php echo $wikio_sub_title; ?>" onclick="please_update(31);" />
						<br />
						<label for="wikio_sub_title"><?php _e('Donnez un titre a votre widget',$wikio_domain); ?>.</label>
						</div>
						<input id="post-query-submit-31" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Url du flux RSS',$wikio_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<input id="wikio_sub_rss" name="wikio_sub_rss" type="text" value="<?php echo $wikio_sub_rss; ?>" size="70" onclick="please_update(32);" />
						<br />
						<label for="wikio_sub_rss"><?php _e('Url de votre flux RSS. Wordpress propose',$wikio_domain); ?> "<?php echo get_bloginfo('rss2_url'); ?>"</label>
						</div>
						<input id="post-query-submit-32" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
				
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Services',$wikio_domain); ?>
						</th>
						<td>
						<div class="wikio_share_form">
						
						
						<?php
						$n=0;
						foreach ( $wikio_sub_items as $key )
						{
							echo'
							<div class="wikio_sub_item">
							<label for="wikio_sub_item_'.$n.'">
								<input name="wikio_sub_item[]" id="wikio_sub_item_'.$n.'" type="checkbox" value="'.$key.'"';
								if ($wikio_sub_option[$key]==$key){echo ' checked';}
								echo' onchange="please_update(33);" />
								<img src="'.$wikio_plugin_image_dir.'/sub_'.$key.'.gif" alt="'.$key.'" />
							</label>
							</div>
							
							';
						$n++;
						}
						?></div>
						
						<?php _e('Cochez les cases correspondantes aux services que vous souhaitez ajouter',$wikio_domain); ?>.
						<br />
						<input id="post-query-submit-33" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Creation de widgets',$wikio_domain); ?>
						</th>
						<td>
						<div class="wikio_share_form">
						
						
						<?php
						$n=0;
						foreach ( $wikio_widgets_items as $key_w )
						{
							echo'
							<div class="wikio_widgets_item">
							<label for="wikio_widgets_item_'.$n.'">
								<input name="wikio_widgets_item[]" id="wikio_widgets_item_'.$n.'" type="checkbox" value="'.$key_w.'"';
								if ($wikio_widgets_option[$key_w]==$key_w){echo ' checked';}
								echo' onchange="please_update(35);" />
								<img src="'.$wikio_plugin_image_dir.'/widget_'.$key_w.'.gif" alt="'.$key_w.'" />
							</label>
							</div>
							
							';
						$n++;
						}
						?></div>
						
						<?php _e('Cochez les cases correspondantes aux services que vous souhaitez ajouter',$wikio_domain); ?>.
						<br />
						<input id="post-query-submit-35" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Insertion automatique',$wikio_domain); ?></th>
						<td>
						<select name="wikio_sub_auto" onchange="sub(this); please_update(3)">
						<option value="0" <?php if ($wikio_sub_auto == 0){ echo 'selected="selected"';} ?>><?php _e('Oui',$wikio_domain); ?> (<?php _e('recommande',$wikio_domain); ?>)</option>
						<option value="1" <?php if ($wikio_sub_auto == 1){ echo 'selected="selected"';} ?>><?php _e('Non',$wikio_domain); ?> (<?php _e('je copie et colle le script ci dessous dans mon template',$wikio_domain); ?>)</option>
				  
						</select>
						<br />
						<div id="sub_info" <?php if ($wikio_sub_auto == 1){ echo 'style="display:none"';} else { echo 'style="display:block"';} ?>>
						<label for="wikio_sub_title"><?php _e("N'oubliez pas de placer",$wikio_domain); ?> <a href="widgets.php"><?php _e('le widget dans votre template',$wikio_domain); ?></a>.</label>
						</div>
						<div id="sub_script" <?php if ($wikio_sub_auto == 1){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
							<strong><?php _e('Script a copier / coller',$wikio_domain); ?> :</strong><br />
							<div class="wikio_share_form">
							<textarea name="1" cols="75" rows="1" onfocus="select()"><?php print("<?php if (function_exists('wikio_sub_alone')){wikio_sub_alone();} ?>"); ?></textarea>
							<br />
							<label for="wikio_sub_title"><?php _e("Si vous le souhaitez, vous pouvez copier et coller ce script directement dans votre template a l'endroit que vous voulez",$wikio_domain); ?>.
							<br /></label>
							</div>
						</div>
						<input id="post-query-submit-3" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			
			<?php
			
			
			// Check the post results
			if ($_POST['submit']){
				
				$wikio_vote_auto = htmlentities($_POST['wikio_vote_auto']);
				$wikio_align = htmlentities($_POST['wikio_align']);
				$wikio_vote_display = htmlentities( $_POST['wikio_vote_display'] );
					
				// Save the posted value in the database
				update_option( wikio_vote_auto, $wikio_vote_auto);
				update_option( wikio_align, $wikio_align);
				update_option( wikio_vote_display, $wikio_vote_display);
			}
			
			// return options values
				$wikio_vote_auto = get_option( 'wikio_vote_auto' );
				$wikio_align = get_option( 'wikio_align' );
				$wikio_vote_display = get_option( 'wikio_vote_display' );
			?>
			
			<br /><br />
			<h2 id="wikio_vote"><?php _e('Bouton de vote',$wikio_domain); ?></h2>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Preview',$wikio_domain); ?></th>
						<td><img src="<?php echo $wikio_plugin_image_dir.'/vote.png'; ?>" alt="Vote" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Affichage sur la home page',$wikio_domain); ?></th>
						<td>
						<select name="wikio_vote_display" onchange="share(this); please_update(41)">
						<option value="0" <?php if ($wikio_vote_display == 0){ echo 'selected="selected"';} ?>><?php _e('Oui',$wikio_domain); ?></option>
						<option value="1" <?php if ($wikio_vote_display == 1){ echo 'selected="selected"';} ?>><?php _e('Non',$wikio_domain); ?> (<?php _e('Affichage sur les pages d\'article uniquement',$wikio_domain); ?>)</option>
						</select>
						<input id="post-query-submit-41" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Insertion automatique',$wikio_domain); ?></th>
						<td>
						<select name="wikio_vote_auto" onchange="vote(this); please_update(4)">
						<option value="0" <?php if ($wikio_vote_auto == 0){ echo 'selected="selected"';} ?>><?php _e('Oui',$wikio_domain); ?> (<?php _e('recommande',$wikio_domain); ?>)</option>
						<option value="1" <?php if ($wikio_vote_auto == 1){ echo 'selected="selected"';} ?>><?php _e('Non',$wikio_domain); ?> (<?php _e('je copie et colle le script ci dessous dans mon template',$wikio_domain); ?>)</option>
				  
						</select>
						<br />
						<div id="vote_script"<?php if ($wikio_vote_auto == 1){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
							<strong><?php _e('Script a copier / coller',$wikio_domain); ?> :</strong><br />
							<div class="wikio_share_form">
							<textarea name="1" cols="75" rows="1" onfocus="select()"><?php print("<?php if (function_exists('wikio_vote_alone')){wikio_vote_alone();} ?>"); ?></textarea>
							<br />
							<label for="wikio_sub_title"><?php _e('Si vous le souhaitez, vous pouvez copier et coller ce script directement dans votre template entre les balises suivantes',$wikio_domain); ?> :<br />&lt;?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?&gt; et &lt;?php endif; ?&gt;
							<br /></label>
							</div>
						</div>
						<input id="post-query-submit-4" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Alignement des boutons',$wikio_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<select name="wikio_align" onchange="please_update(5)">
						<option value="0" <?php if ($wikio_align == 0){ echo 'selected="selected"';} ?>><?php _e('Horizontalement',$wikio_domain); ?> (<?php _e('recommande',$wikio_domain); ?>)</option>
						<option value="1" <?php if ($wikio_align == 1){ echo 'selected="selected"';} ?>><?php _e('Verticalement',$wikio_domain); ?></option>
				  
						</select>
						<br />
						<label for="wikio_sub_rss"><?php _e('Alignement avec le bouton de partage',$wikio_domain); ?>.</a></label>
						</div>
						<input id="post-query-submit-5" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
				
	
	
<?php
			
			
			// Check the post results
			if ($_POST['submit']){
				
				$wikio_top_auto = htmlentities($_POST['wikio_top_auto']);
				$wikio_top_title = htmlentities($_POST['wikio_top_title']);
				$wikio_top_style = htmlentities($_POST['wikio_top_style']);
				$wikio_top_categ = htmlentities($_POST['wikio_top_categ']);
				$wikio_top_gen = htmlentities($_POST['wikio_top_gen']);
				
				// Save the posted value in the database
				update_option( wikio_top_auto, $wikio_top_auto);
				update_option( wikio_top_title, $wikio_top_title);
				update_option( wikio_top_style, $wikio_top_style);
				update_option( wikio_top_categ, $wikio_top_categ);
				update_option( wikio_top_gen, $wikio_top_gen);
			}
			
			// return options values
				$wikio_top_auto = get_option( 'wikio_top_auto' );
				$wikio_top_title = stripslashes(html_entity_decode(get_option('wikio_top_title')));
				$wikio_top_style = get_option( 'wikio_top_style' );
				$wikio_top_categ = get_option( 'wikio_top_categ' );
				$wikio_top_gen = get_option( 'wikio_top_gen' );
				
			// Checked ?
				
				if ($wikio_top_categ == 1){$wikio_top_categ_checked = "checked";} else {$wikio_top_categ_checked = "";}
				if ($wikio_top_gen == 1){$wikio_top_gen_checked = "checked";} else {$wikio_top_gen_checked = "";}
				
				//echo 'auto-'.$wikio_top_auto;
//				echo '-title-'.$wikio_top_title;
//				echo '-style-'.$wikio_top_style;
//				echo '-categ-'.$wikio_top_categ;
			?>
			
			<br /><br />
			<h2 id="wikio_top"><?php _e('Badge Top des blogs',$wikio_domain); ?></h2>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Preview',$wikio_domain); ?></th>
						<td>
						<table width="400">
							<tr>
								<td valign="top">
								<p><?php _e('Classement general',$wikio_domain); ?>:</p>
								<a href="http://www.wikio.<?php echo $wikio_tld; ?>/blogs/top/">
						<img src="http://external.wikio.<?php echo $wikio_tld; ?>/blogs/top/getrank?url=<?php echo get_bloginfo( 'url' ); ?>&style=<?php echo $wikio_top_style; ?>" style="border: none;" alt="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" title="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" />
								</td>
								<td valign="top">
								<p><?php _e('Classement dans votre categorie',$wikio_domain); ?>:</p>
								<a href="http://www.wikio.<?php echo $wikio_tld; ?>/blogs/top/">
						<img src="http://external.wikio.<?php echo $wikio_tld; ?>/blogs/top/getrank?url=<?php echo get_bloginfo( 'url' ); ?>&cat=1&style=<?php echo $wikio_top_style; ?>" style="border: none;" alt="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" title="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" />
								</td>
							</tr>
						</table>
						<p>
						<?php _e("Si aucun chiffre n'est visible verifiez que votre blog est bien inscrit dans Wikio ou"); ?>
						<a href="http://www.wikio.<?php echo $wikio_tld; ?>/addblog" target="_blank"><?php _e('inscrivez-vous gratuitement.',$wikio_domain); ?></a>
						</p>
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Titre du widget',$wikio_domain); ?></th>
						<td>
						<div class="wikio_share_form">
						<input id="wikio_top_title" name="wikio_top_title" type="text" value="<?php echo $wikio_top_title; ?>" onclick="please_update(61);" />
						<br />
						<label for="wikio_top_title"><?php _e('Donnez un titre a votre widget',$wikio_domain); ?>.</label>
						</div>
						<input id="post-query-submit-61" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Style',$wikio_domain); ?></th>
						<td>
							<table width="400">
							<tr>
							
							<?php
							for ($i=1; $i<9; $i++){
							if ($i == $wikio_top_style){$wikio_top_style_check = "checked";} else {$wikio_top_style_check = "";}
							print('<td><input name="wikio_top_style" id="wikio_top_style_'.$i.'" type="radio" value="'.$i.'" onclick="please_update(62);" '.$wikio_top_style_check.' /></td><td><label for="wikio_top_style_'.$i.'"><img src="http://external.wikio.'.$wikio_tld.'/blogs/top/getrank?url='.urlencode(get_bloginfo( 'url' )).'&style='.$i.'" style="border: none;" /></label></td>'); 
							if ( $i == 4 ){ print ("</tr><tr>");}
							}
							?>
							
							<td>
							</td>
							</tr>
							</table>
						<input id="post-query-submit-62" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Affichage',$wikio_domain); ?></th>
						<td>
						<p><input name="wikio_top_gen" id="wikio_top_gen" type="checkbox" value="1" <?php echo $wikio_top_gen_checked; ?> /> <label for="wikio_top_gen"><?php _e('Afficher mon classement dans le top general'); ?></label>
						</p>
						<p>
						<input name="wikio_top_categ" id="wikio_top_categ" type="checkbox" value="1" <?php echo $wikio_top_categ_checked; ?> /> <label for="wikio_top_categ"><?php _e('Afficher mon classement dans ma categorie'); ?></label></p>
						</td>
					</tr>
				</tbody>
			</table>
						
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><?php _e('Insertion automatique',$wikio_domain); ?></th>
						<td>
						<select name="wikio_top_auto" onchange="top(this); please_update(6)">
						<option value="0" <?php if ($wikio_top_auto == 0){ echo 'selected="selected"';} ?>><?php _e('Oui',$wikio_domain); ?> (<?php _e('recommande',$wikio_domain); ?>)</option>
						<option value="1" <?php if ($wikio_top_auto == 1){ echo 'selected="selected"';} ?>><?php _e('Non',$wikio_domain); ?> (<?php _e('je copie et colle le script ci dessous dans mon template',$wikio_domain); ?>)</option>
				  
						</select>
						<div id="top_info" <?php if ($wikio_top_auto == 1){ echo 'style="display:none"';} else { echo 'style="display:block"';} ?>>
						<label for="wikio_sub_title"><?php _e("N'oubliez pas de placer",$wikio_domain); ?> <a href="widgets.php"><?php _e('le widget dans votre template',$wikio_domain); ?></a>.</label>
						</div>
						<br />
						<div id="top_script"<?php if ($wikio_top_auto == 1){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
							<strong><?php _e('Script a copier / coller',$wikio_domain); ?> :</strong><br />
							<div class="wikio_share_form">
							<textarea name="1" cols="75" rows="4" onfocus="select()"><?php print("<?php if (function_exists('wikio_top_alone')){wikio_top_alone();} ?>"); ?></textarea>
							<br />
							<label for="wikio_sub_title"><?php _e("Si vous le souhaitez, vous pouvez copier et coller ce script directement dans votre template a l'endroit que vous voulez",$wikio_domain); ?>.
							<br /></label>
							</div>
						</div>
						<input id="post-query-submit-6" class="button-secondary" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" style="display:none;" name="submit" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<div class="submit">
			<input class="button-primary" name="submit" type="submit" value="<?php _e('Enregistrer les modifications',$wikio_domain); ?>" />
			</div>
			</form>
	
	
	<?php
			
		
		//print('</div>');
		
		print('</div>');
	}

class wikio_badge{

  function wikio_badge(){
	  
	// after the exerpt
	//add_filter( 'the_excerpt', array(&$this, 'wikio_badge_do' ));
	
	// after the content
	add_filter( 'the_content', array(&$this, 'wikio_badge_do' ));
		 
  }

  function wikio_badge_do($content){ 
	$wikio_tld = get_option( 'wikio_tld' );
	$link = "";
	$title = ""; 
	$link  = urlencode(get_permalink($post->ID));
	$title = urlencode(the_title('','',false));
	 
	 // Return all options values
	$wikio_share_options = get_option( 'wikio_share_options' );
	
	foreach ( $wikio_share_options as $key=>$value ){
		
		$services .= $value.'+';
		
	}
	
	// horizontaly ?
	if ( get_option( 'wikio_align' ) == 1 ){
	
		$badge = "<div class=\"wikio-share\">";
		
	} else {
	
		$badge = "<div class=\"wikio-share-inline\">";
		
	}
	
	 
	 if (get_option('wikio_share_auto') == 0){
	 
		// Display on home ?
		if ( (get_option( 'wikio_share_display' ) == 1) && (is_single()) || (get_option( 'wikio_share_display' ) == 0) ){
			$badge .= "
			<div class=\"wikio-share-button\">
			 <a href=\"http://www.wikio.".$wikio_tld."/sharethis?url=".$link."&amp;title=".$title."\" id=\"wikio-share-popup-button\">Wikio</a><script type=\"text/javascript\" src=\"http://www.wikio.".$wikio_tld."/sharethispopupv2?services=".$services."&amp;url=".$link."&amp;title=".$title."\"></script></div>";
		   }       
	 }
	
	if (get_option('wikio_vote_auto') == 0){
	
		// Display on home ?
		if ( (get_option( 'wikio_vote_display' ) == 1) && (is_single()) || (get_option( 'wikio_vote_display' ) == 0) ){
			$badge .= "
			<div class=\"wikio-share-button\">
			<a class=\"wikio\" href=\"http://www.wikio.".$wikio_tld."\">Wikio</a>
		<script type=\"text/javascript\" src=\"http://www.wikio.".$wikio_tld."/votebadge?style=rounded-open-blue-rating&amp;url=".$link."\"></script>
			 </div>
			 ";
			 }
	 }
	 
	 $badge .= "</div>";
	 
	 // not include this in feed
	 if (is_feed()){
     	return $content;
	 } else {
	 	return $content . $badge;
	 }
  }
  
  
}



class wikio_sub_widget {

	function wikio_sub_widget() {
		add_action( 'widgets_init', array(&$this, 'init_widget' ));
	}

	function init_widget() {
		
		if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
		
		register_sidebar_widget( array(__('Subscribe',$wikio_domain),'widgets'),array(&$this, 'widget') );
		register_widget_control( array(__('Subscribe',$wikio_domain), 'widgets'), array(&$this, 'widget_options') );
	}

	function widget($args) {
		//global $wpdb;
		$wikio_tld = get_option( 'wikio_tld' );
		
		
		// update RSS information
		if (!get_option( 'wikio_sub_rss' )){
			
			$rss_2 = urlencode(get_bloginfo('rss2_url'));
			update_option( wikio_sub_rss, $rss_2 );
			
		}
		
		// Return all options values
		$WidgetTitle = html_entity_decode(get_option( 'wikio_sub_title' ));
		$WidgetTitle = stripslashes($WidgetTitle);
				
		extract($args);
		
		echo $before_widget.$before_title.$WidgetTitle.$after_title;
		
		// widget abo
			// Return all options values
			$wikio_sub_options = get_option( 'wikio_sub_options' );
			
			foreach ( $wikio_sub_options as $key=>$value ){
				
				$services.= $value.'+';
				
			}
			
			$wikio_widgets_options = get_option( 'wikio_widgets_options' );
			
			foreach ( $wikio_widgets_options as $key_w=>$value_w ){
				
				$widgets.= $value_w.'+';
				
			}
			
			?>
			
			<a target="_blank" href="http://www.wikio.<?php echo $wikio_tld; ?>/subscribethis?url=<?php echo get_option('wikio_sub_rss'); ?>" class="wikio-popup-button">Wikio</a><script type="text/javascript" src="http://www.wikio.<?php echo $wikio_tld; ?>/wikiothispopupv2?services=<?php echo $services; ?>&amp;widgets=<?php echo $widgets; ?>&amp;url=<?php echo get_option('wikio_sub_rss'); ?>"></script>
		<?php
				
		echo $after_widget;
	}

	function widget_options() {
		
		if ($_POST['wikio_sub_title']) {
			
			$option = $_POST['wikio_sub_title'];
			update_option( 'wikio_sub_title', $option );
			
		}
		
		echo '<p><a href="themes.php?page='.dirname(plugin_basename(__FILE__)).'/wikio-buttons.php">'.__('Cliquez ici pour configurer le widget !',$wikio_domain).'</a></p>';
	}
	
}

// sub button alone
	function wikio_sub_alone(){
	$wikio_tld = get_option( 'wikio_tld' );
	
	if (get_option( 'wikio_sub_auto' ) == 1){
		
		// update RSS information
		if (!get_option( 'wikio_sub_rss' )){
			
			$rss_2 = urlencode(get_bloginfo('rss2_url'));
			update_option( wikio_sub_rss, $rss_2 );
			
		}
		
		$wikio_sub_options = get_option( 'wikio_sub_options' );
					
					foreach ( $wikio_sub_options as $key=>$value ){
						
						$services .= $value.'+';
						
					}
					
		$wikio_widgets_options = get_option( 'wikio_widgets_options' );
			
					foreach ( $wikio_widgets_options as $key_w=>$value_w ){
						
						$widgets.= $value_w.'+';
						
					}			
					?>
					
					<a target="_blank" href="http://www.wikio.<?php echo $wikio_tld; ?>/subscribethis?url=<?php echo get_option( 'wikio_sub_rss' ); ?>" class="wikio-popup-button">Wikio</a><script type="text/javascript" src="http://www.wikio.<?php echo $wikio_tld; ?>/wikiothispopupv2?services=<?php echo $services; ?>&amp;widgets=<?php echo $widgets; ?>&amp;url=<?php echo get_option( 'wikio_sub_rss' ); ?>"></script>
				<?php
		}
	}

// top alone
	function wikio_top_alone(){
	$wikio_tld = get_option( 'wikio_tld' );
	$wikio_top_style = get_option( 'wikio_top_style' );
	$wikio_top_categ = get_option( 'wikio_top_categ' );
	$wikio_top_gen = get_option( 'wikio_top_gen' );
	
	if ( ( get_option( 'wikio_top_auto' ) == 1) && ( $wikio_top_gen == 1 ) ){
		echo '<p><a href="http://www.wikio.'.$wikio_tld.'/blogs/top/">
		<img src="http://external.wikio.'.$wikio_tld.'/blogs/top/getrank?url='.urlencode(get_bloginfo( 'url' )).'&amp;style='.$wikio_top_style.'" style="border: none;" alt="'.__('Wikio - Top des blogs',$wikio_domain).' title="'.__('Wikio - Top des blogs',$wikio_domain).'" /></a></p>';
		
		}
	
	if ( ( get_option( 'wikio_top_auto' ) == 1) && ( $wikio_top_categ == 1 ) ){
		echo '<p><a href="http://www.wikio.'.$wikio_tld.'/blogs/top/">
		<img src="http://external.wikio.'.$wikio_tld.'/blogs/top/getrank?url='.urlencode(get_bloginfo( 'url' )).'&amp;cat=1&amp;style='.$wikio_top_style.'" style="border: none;" alt="'.__('Wikio - Top des blogs',$wikio_domain).' title="'.__('Wikio - Top des blogs',$wikio_domain).'" /></a></p>';
		
		}
		
	}
	
// share button alone
	function wikio_share_alone(){
	$wikio_tld = get_option( 'wikio_tld' );
	
	if ( get_option( 'wikio_share_auto' ) == 1 ){
		$wikio_share_options = get_option( 'wikio_share_options');
				
				$title = urlencode(the_title('', '', false));
				$link = urlencode(get_permalink());
				
				foreach ( $wikio_share_options as $key=>$value ){
					
					$services.= $value.'+';
					
				}
				
			// Display on home ?
			if ( (get_option( 'wikio_vote_display' ) == 1) && (is_single()) || (get_option( 'wikio_vote_display' ) == 0) ){
				// not include this in feed
				if (!is_feed()){
					?>
						
						<a href="http://www.wikio.<?php echo $wikio_tld; ?>/sharethis?url=<?php echo $link; ?>&amp;title=<?php echo $title; ?>" id="wikio-share-popup-button">Wikio</a><script type="text/javascript" src="http://www.wikio.<?php echo $wikio_tld; ?>/sharethispopupv2?services=<?php echo $services; ?>&amp;url=<?php echo $link; ?>&amp;title=<?php echo $title; ?>"></script>
				<?php
				}
			}
		}
	
	}


// vote button alone
	function wikio_vote_alone(){
			$wikio_tld = get_option( 'wikio_tld' );
						
			if (get_option( 'wikio_vote_auto' ) == 1){
			
			$link = urlencode(get_permalink());
			
			// Display on home ?
			if ( (get_option( 'wikio_vote_display' ) == 1) && (is_single()) || (get_option( 'wikio_vote_display' ) == 0) ){
				// not include this in feed
				if (!is_feed()){
						?>
						<a class="wikio" href="http://www.wikio.<?php echo $wikio_tld; ?>">Wikio</a>
			<script type="text/javascript" src="http://www.wikio.<?php echo $wikio_tld; ?>/votebadge?style=rounded-open-blue-rating&amp;url=<?php echo $link; ?>"></script>
						<?php
						}
				}
			}
		
		}


// share button preview
	function wikio_share_preview(){
		$wikio_tld = get_option( 'wikio_tld' );
		
		$wikio_share_options = get_option( 'wikio_share_options');
				
				$title = urlencode(the_title('', '', false));
				$link = urlencode(get_permalink());
				
				foreach ( $wikio_share_options as $key=>$value ){
					
					$services.= $value.'+';
					
				}
				// not include this in feed
				if (!is_feed()){
					?>
						
					<a href="http://www.wikio.<?php echo $wikio_tld; ?>/sharethis?url=<?php echo $link; ?>&amp;title=<?php echo $title; ?>" id="wikio-share-popup-button">Wikio</a><script type="text/javascript" src="http://www.wikio.<?php echo $wikio_tld; ?>/sharethispopupv2?services=<?php echo $services; ?>&amp;url=<?php echo $link; ?>&amp;title=<?php echo $title; ?>"></script>
				<?php
				}	
	}


// vote button preview
	function wikio_vote_preview(){
			$wikio_tld = get_option( 'wikio_tld' );
			
			$link = urlencode(get_permalink());
			
			// not include this in feed
			if (!is_feed()){
					?>
						<a class="wikio" href="http://www.wikio.<?php echo $wikio_tld; ?>">Wikio</a>
						<script type="text/javascript" src="http://www.wikio.<?php echo $wikio_tld; ?>/votebadge?style=rounded-open-blue-rating&amp;url=<?php echo $link; ?>"></script>
					<?php
					}
		}

// sub button alone
	function wikio_sub_preview(){
		
		$wikio_tld = get_option( 'wikio_tld' );
		
		// update RSS information
		if (!get_option( 'wikio_sub_rss' )){
			
			$rss_2 = urlencode(get_bloginfo('rss2_url'));
			update_option( wikio_sub_rss, $rss_2 );
			
		}
		
		$wikio_sub_options = get_option( 'wikio_sub_options' );
					
					foreach ( $wikio_sub_options as $key=>$value ){
						
						$services .= $value.'+';
						
					}
					
		$wikio_widgets_options = get_option( 'wikio_widgets_options' );
			
					foreach ( $wikio_widgets_options as $key_w=>$value_w ){
						
						$widgets.= $value_w.'+';
						
					}
								
					?>
					
					<a target="_blank" href="http://www.wikio.<?php echo $wikio_tld; ?>/subscribethis?url=<?php echo get_option('wikio_sub_rss'); ?>" class="wikio-popup-button">Wikio</a><script type="text/javascript" src="http://www.wikio.<?php echo $wikio_tld; ?>/wikiothispopupv2?services=<?php echo $services; ?>&amp;widgets=<?php echo $widgets; ?>&amp;url=<?php echo get_option('wikio_sub_rss'); ?>"></script>
				<?php
	}



// widget news
class wikio_news_widget {
    //var $plugin_folder = '';

    var $default_options = array(
            'title' => 'News', 
			'theme' => '',
			'max_item' => '1',
			'show_more' => '0'
    );
	
	function wikio_news_widget(){
	
		add_action( 'widgets_init', array(&$this, 'init') );
		
	}
    
    function init() {
        
		if (!$options = get_option( 'wikio_news_options' ))
        $options = array();
            
        $widget_ops = array('classname' => 'wikio_news_options', 'description' => __('Toutes les news sur les themes que vous voulez',$wikio_domain).' !');
        $control_ops = array('width' => 250, 'height' => 100, 'id_base' => 'wikio_news');
        $name = __('Actus',$wikio_domain);
        
        $registered = false;
        
		foreach ( array_keys($options) as $o ) {
            if ( !isset($options[$o]['title']) )
            continue;
                
            $id = "wikio_news-$o";
            $registered = true;
            wp_register_sidebar_widget( $id, $name, array(&$this, 'widget'), $widget_ops, array( 'number' => $o ) );
            wp_register_widget_control( $id, $name, array(&$this, 'control'), $control_ops, array( 'number' => $o ) );
        }
        if (!$registered) {
		
            wp_register_sidebar_widget( 'wikio_news-1', $name, array(&$this, 'widget'), $widget_ops, array( 'number' => -1 ) );
            wp_register_widget_control( 'wikio_news-1', $name, array(&$this, 'control'), $control_ops, array( 'number' => -1 ) );
        }
    }

    function widget($args, $widget_args = 1) {
        
		extract($args);
        global $post;
		
		$wikio_tld = get_option( 'wikio_tld' );
		
        if (is_numeric($widget_args))
        
		$widget_args = array('number' => $widget_args);
        $widget_args = wp_parse_args($widget_args, array( 'number' => -1 ));
        extract($widget_args, EXTR_SKIP);
        $options_all = get_option( 'wikio_news_options' );
        
		if (!isset($options_all[$number]))
        return;

        $options = $options_all[$number];
		
		// Thema text
		$option_theme = $options["theme"];
		
		// Thema url
		$option_theme_url = $options["theme_url"];
		
		// tld ?
		switch ($wikio_tld){
			case "fr":
				$wikio_une_url = "http://www.wikio.fr/a_la_une";
			break;
			case "it":
				$wikio_une_url = "http://www.wikio.it/prima_pagina";
			break;
			case "es":
				$wikio_une_url = "http://www.wikio.es/portada";
			break;
			case "de":
				$wikio_une_url = "http://www.wikio.de/aktuell";
			break;
			case "co.uk":
				$wikio_une_url = "http://www.wikio.co.uk/home";
			break;
			case "com":
				$wikio_une_url = "http://www.wikio.com/home";
			break;
		}
		
        echo $before_widget.$before_title;
        echo stripslashes($options["title"]);
        echo $after_title;
		
		// la page
        //echo $this->render_pages(isset($options["pages"]) ? explode(',', $options["pages"]) : array(), $options["sort"]);
		// widget
			// Get RSS Feed(s)
			
				include_once(ABSPATH . WPINC . '/rss.php');
				
				if (empty($option_theme)){$flux_xml="http://rss.wikio.".$wikio_tld."/".$wikio_une_url.".rss";} else {
				$flux_xml = "http://rss.wikio.".$wikio_tld."/search/".$option_theme_url.".rss?go=1";}
				//$flux_xml = "http://rss.wikio.fr/rss?tags=$opt_val&lang=fr&country=fr";
				$rss = fetch_rss($flux_xml);
				$maxitems = $options["max_item"];
				if (is_array($rss->items)) {$items = array_slice($rss->items, 0, $maxitems);}
				?>
				
				<ul>
				<?php if (empty($items)) echo '<li>'.__("Pas encore d'information...",$wikio_domain).'</li>';
				else
				foreach ( $items as $item ) : ?>
				<li>
					<a href='<?php echo $item['link']; ?>' title='<?php echo stripslashes($item['title']); ?>'>
						<?php echo stripslashes($item['title']); ?>
					</a>
					<?php if ($options["show_more"]) {echo $item['description'];} ?>
				</li>
				<?php endforeach; ?>
				</ul>
				<?php if (empty($option_theme)){ ?>
				<a href="http://www.wikio.<?php echo $wikio_tld; ?>/" target="_blank">Wikio</a>
				<?php } else { ?>
				<a href="http://www.wikio.<?php echo $wikio_tld; ?>/search/<?php echo urlencode($option_theme_url); ?>" target="_blank"><?php _e("Suite",$wikio_domain); ?>... &raquo;</a>
				<?php } ?>
		<?php
		
		
        echo $after_widget;
    }

    function control($widget_args = 1) {
        
		global $wp_registered_widgets;
        static $updated = false;

        if ( is_numeric($widget_args) )
		
        $widget_args = array('number' => $widget_args);
        $widget_args = wp_parse_args($widget_args, array('number' => -1));
        extract($widget_args, EXTR_SKIP);
        $options_all = get_option('wikio_news_options');
        
		if (!is_array($options_all))
            $options_all = array();  
            
        if (!$updated && !empty($_POST['sidebar'])) {
            $sidebar = (string)$_POST['sidebar'];

            $sidebars_widgets = wp_get_sidebars_widgets();
            
			if (isset($sidebars_widgets[$sidebar]))
                $this_sidebar =& $sidebars_widgets[$sidebar];
            else
                $this_sidebar = array();

            foreach ( $this_sidebar as $_widget_id ) {
                
				if ('wikio_news_options' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number'])) {
                    
					$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
                    if (!in_array("wikio_news-$widget_number", $_POST['widget-id']))
                        unset($options_all[$widget_number]);
						
                }
            }
			
            foreach ( (array)$_POST['wikio_news_options'] as $widget_number => $posted ) {
                
				if (!isset($posted['title']) && isset($options_all[$widget_number]))
                continue;
                
                $options = array();
                
				// traitement des données envoyées
                $options['title'] = $posted['title'];                
				
				// pour le theme
				$option_theme = str_replace('+','+',$posted['theme']);
				
				// pour le passage dans l'url
				$option_theme_url = sanitize_title($posted['theme']);
				$option_theme_url = str_replace('-','+',$option_theme_url);
				$options['theme_url'] = $option_theme_url;
				
				$options['theme'] = $option_theme;
                
				// nombre d'articles max
				$options['max_item'] = $posted['max_item'];
				
				// contenu?
				$options['show_more'] = $posted['show_more'];
				
                $options_all[$widget_number] = $options;
            }
            update_option('wikio_news_options', $options_all);
            $updated = true;
        }

        if (-1 == $number) {
            
			$number = '%i%';
            $values = $this->default_options;
			
        }
        else {
		
            $values = $options_all[$number];
			
        }
        
		// uniquement affichage
		$option_theme = urldecode( $values['theme'] );
		$option_theme = str_replace( '+', ' ', $option_theme );
		
		?>
		<label for="wikio_news-<?php echo $number; ?>-title"><?php _e("Titre du widget",$wikio_domain); ?> :</label><br />
		<input class="widefat" id="wikio_news-<?php echo $number; ?>-title" name="wikio_news_options[<?php echo $number; ?>][title]" type="text" value="<?php echo stripslashes($values['title']); ?>" />
		
		<label for="wikio_news-<?php echo $number; ?>-theme"><?php _e("Theme (ex:Emploi France)",$wikio_domain); ?> :</label><br />
		<input class="widefat" id="wikio_news-<?php echo $number; ?>-theme" name="wikio_news_options[<?php echo $number; ?>][theme]" type="text" value="<?php echo stripslashes($option_theme); ?>" />
		
		<br /><label for="wikio_news-<?php echo $number; ?>-max_item"><?php _e("Nombre de news affichees",$wikio_domain); ?> :</label><br />
		<select id="wikio_news-<?php echo $number; ?>-max_item" name="wikio_news_options[<?php echo $number; ?>][max_item]">
			  <option value="1" <?php if ($values['max_item']==1){ echo 'selected="selected"';} ?>>1</option>
			  <option value="2" <?php if ($values['max_item']==2){ echo 'selected="selected"';} ?>>2</option>
			  <option value="3" <?php if ($values['max_item']==3){ echo 'selected="selected"';} ?>>3</option>
			  <option value="4" <?php if ($values['max_item']==4){ echo 'selected="selected"';} ?>>4</option>
			  <option value="5" <?php if ($values['max_item']==5){ echo 'selected="selected"';} ?>>5</option>
			  <option value="6" <?php if ($values['max_item']==6){ echo 'selected="selected"';} ?>>6</option>
			  <option value="7" <?php if ($values['max_item']==7){ echo 'selected="selected"';} ?>>7</option>
			  <option value="8" <?php if ($values['max_item']==8){ echo 'selected="selected"';} ?>>8</option>
			  <option value="9" <?php if ($values['max_item']==9){ echo 'selected="selected"';} ?>>9</option>
			  <option value="10" <?php if ($values['max_item']==10){ echo 'selected="selected"';} ?>>10</option>
			</select>
		
		<?php
		echo '(<b>'.$values['max_item'].'</b> '; _e('actuellement',$wikio_domain); echo ')';
		?>
		<br /><label for="wikio_news-<?php echo $number; ?>-show_more"><?php _e("Afficher une partie du contenu",$wikio_domain); ?>:</label><br />
		<select id="wikio_news-<?php echo $number; ?>-show_more" name="wikio_news_options[<?php echo $number; ?>][show_more]">
			  <option value="1" <?php if ($values['show_more']==1){ echo 'selected="selected"';} ?>><?php _e("Oui",$wikio_domain); ?></option>
			  <option value="0" <?php if ($values['show_more']==0){ echo 'selected="selected"';} ?>><?php _e("Non",$wikio_domain); ?></option>
			</select>
		<p><?php _e('Pensez a enregistrer vos modifications',$wikio_domain); ?>&nbsp;!</p>
		
<?php
		
    }

} // class new

class wikio_top_widget {

	function wikio_top_widget() {
		add_action( 'widgets_init', array(&$this, 'init_widget' ));
	}

	function init_widget() {
		
		if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;
		register_sidebar_widget( array(__('Top des blogs',$wikio_domain),'widgets'),array(&$this, 'widget') );
		register_widget_control( array(__('Top des blogs',$wikio_domain), 'widgets'), array(&$this, 'widget_options') );
		
	}

	function widget($args) {
		//global $wpdb;
		$wikio_tld = get_option( 'wikio_tld' );
		
		
		// Return all options values
		$WidgetTitle = html_entity_decode(get_option( 'wikio_top_title' ));
		$WidgetTitle = stripslashes($WidgetTitle);
		$wikio_top_style = get_option( 'wikio_top_style' );
		$wikio_top_categ = get_option( 'wikio_top_categ' );
		$wikio_top_gen = get_option( 'wikio_top_gen' );
				
		extract($args);
		echo $before_widget.$before_title.$WidgetTitle.$after_title;
		
		if ( $wikio_top_gen == 1 ){
			?>	
			<p><a href="http://www.wikio.<?php echo $wikio_tld; ?>/blogs/top/">
			<img src="http://external.wikio.<?php echo $wikio_tld; ?>/blogs/top/getrank?url=<?php echo get_bloginfo( 'url' ); ?>&amp;style=<?php echo $wikio_top_style; ?>" style="border: none;" alt="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" title="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" /></a></p>
		<?php
		}
		
		if ( $wikio_top_categ == 1 ){
			?>	
			<p><a href="http://www.wikio.<?php echo $wikio_tld; ?>/blogs/top/">
			<img src="http://external.wikio.<?php echo $wikio_tld; ?>/blogs/top/getrank?url=<?php echo get_bloginfo( 'url' ); ?>&amp;cat=1&amp;style=<?php echo $wikio_top_style; ?>" style="border: none;" alt="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" title="<?php _e('Wikio - Top des blogs',$wikio_domain); ?>" /></a></p>
		<?php
		}
		
		echo $after_widget;
	}

	function widget_options() {
		
		if ($_POST['wikio_sub_title']) {
			
			$option = $_POST['wikio_sub_title'];
			update_option( 'wikio_sub_title', $option );
			
		}
		
		echo '<p><a href="themes.php?page='.dirname(plugin_basename(__FILE__)).'/wikio-buttons.php">'.__('Cliquez ici pour configurer le widget !',$wikio_domain).'</a></p>';
	}
	
} // class top


// All the class
$wikio_sub_widget &= new wikio_sub_widget();
$wikio_badge &= new wikio_badge();
$wikio_news_widget &= new wikio_news_widget();
$wikio_top_widget &= new wikio_top_widget();
?>