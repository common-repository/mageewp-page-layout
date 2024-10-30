<?php
	
	$about_active     = '';
	$themes_active    = '';
	$content          = '';
	
	if ( !isset($_GET['tab']) ){
		
		$themes_active = '';
		$about_active  = 'nav-tab-active';
		$content       =  __('Mageewp Page Layout, accompanied with different kinds of page layout styles, makes page building and editing a much easier thing.Mageewp Page Layout also comes with pre-set modules like Banner, promo, service and team etc., which will help users build their site page layout from blank canvas whithin few minutes. More page layout styles you can expect from our new updates.', 'mageewp-page-layout');
		
		}
?>

<div class="theme-overlay"></div>

<h2 class="nav-tab-wrapper">
<a class="nav-tab <?php echo $about_active;?>" href="?page=mageewp_page_layout&tab=about"><?php _e('About Mageewp Page Layout', 'mageewp-page-layout');?></a>
<!--<a class="nav-tab <?php echo $themes_active;?>" href="?page=mageewp_page_layout"><?php _e('Mageewp Themes', 'mageewp-page-layout');?></a>-->
</h2>
<div class="mpl-info" style="padding: 20px 10px;">
<?php echo $content;?>
<?php
if ( isset($_GET['tab']) && $_GET['tab'] == 'themes' ){
?>
<div class="theme-browser">
	<div class="themes wp-clearfix">

<?php
$themes = wp_prepare_themes_for_js( array( wp_get_theme('onetone'), wp_get_theme('peony') ) );

foreach ( $themes as $theme ) :
	$aria_action = esc_attr( $theme['id'] . '-action' );
	$aria_name   = esc_attr( $theme['id'] . '-name' );
	?>
    <?php if ( ! empty( $theme['screenshot'][0] ) ) { ?>
<div class="theme<?php if ( $theme['active'] ) echo ' active'; ?>" tabindex="0" aria-describedby="<?php echo $aria_action . ' ' . $aria_name; ?>">
	
		<div class="theme-screenshot">
			<img src="<?php echo $theme['screenshot'][0]; ?>" alt="" />
		</div>
	<?php if ( $theme['hasUpdate'] ) : ?>
		<div class="update-message notice inline notice-warning notice-alt">
		<?php if ( $theme['hasPackage'] ) : ?>
			<p><?php _e( 'New version available. <button class="button-link" type="button">Update now</button>', 'mageewp-page-layout' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'New version available.', 'mageewp-page-layout' ); ?></p>
		<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="theme-author"><?php printf( __( 'By %s', 'mageewp-page-layout' ), $theme['author'] ); ?></div>

	<?php if ( $theme['active'] ) { ?>
		<h2 class="theme-name" id="<?php echo $aria_name; ?>">
			<?php
			/* translators: %s: theme name */
			printf( __( '<span>Active:</span> %s', 'mageewp-page-layout' ), $theme['name'] );
			?>
		</h2>
	<?php } else { ?>
		<h2 class="theme-name" id="<?php echo $aria_name; ?>"><?php echo $theme['name']; ?></h2>
	<?php } ?>

	<div class="theme-actions">

	<?php if ( $theme['active'] ) { ?>
		<?php if ( $theme['actions']['customize'] && current_user_can( 'edit_theme_options' ) && current_user_can( 'customize' ) ) { ?>
			<a class="button button-primary customize load-customize hide-if-no-customize" href="<?php echo $theme['actions']['customize']; ?>"><?php _e( 'Customize', 'mageewp-page-layout' ); ?></a>
		<?php } ?>
	<?php } else { ?>
		<?php
		/* translators: %s: Theme name */
		$aria_label = sprintf( _x( 'Activate %s', 'theme' ), '{{ data.name }}' );
		?>
		<a class="button activate" href="<?php echo $theme['actions']['activate']; ?>" aria-label="<?php echo esc_attr( $aria_label ); ?>"><?php _e( 'Activate', 'mageewp-page-layout' ); ?></a>
		<?php if ( current_user_can( 'edit_theme_options' ) && current_user_can( 'customize' ) ) { ?>
			<a class="button button-primary load-customize hide-if-no-customize" href="<?php echo $theme['actions']['customize']; ?>"><?php _e( 'Live Preview', 'mageewp-page-layout' ); ?></a>
		<?php } ?>
	<?php } ?>

	</div>
</div>
<?php }else{
	
	$update_php = network_admin_url( 'update.php?action=install-theme' );
	$install_url = add_query_arg( array(
			'theme'    =>  $theme['id'],
			'_wpnonce' => wp_create_nonce( 'install-theme_' .  $theme['id'] )
		), $update_php );
	?>
<div class="theme" tabindex="0" aria-describedby="<?php echo $theme['id']; ?>-action <?php echo $theme['id']; ?>-name" data-slug="<?php echo $theme['id']; ?>">
  <div class="theme-screenshot"> <img src="//ts.w.org/wp-content/themes/<?php echo $theme['id']; ?>/screenshot.jpg" alt=""> </div>
  <div class="theme-author"> <?php printf( __( 'By %s', 'mageewp-page-layout' ), 'Mageewp' ); ?> </div>
  <h3 class="theme-name"><?php echo ucfirst($theme['name']); ?></h3>
  <div class="theme-actions"> <a class="button button-primary theme-install" data-name="<?php echo ucfirst($theme['name']); ?>" data-slug="<?php echo $theme['id']; ?>" href="<?php echo $install_url?>" aria-label="Install <?php echo ucfirst($theme['name']); ?>"><?php _e( 'Install', 'mageewp-page-layout' ); ?></a>
  
  </div>
</div>
<?php }?>

<?php endforeach; ?>
	</div>
</div>
<?php }?>

</div>