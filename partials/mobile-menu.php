<?php
/**
 * Mobile drawer nav. Sections come straight from the same menus the desktop
 * header uses; category descriptions are mobile-only.
 */

$m_nav_icon_chevron = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M20.8712 17.7023L12.6072 6.30938C12.3072 5.89688 11.6931 5.89688 11.3954 6.30938L3.12903 17.7023C3.10869 17.7304 3.0965 17.7635 3.09382 17.798C3.09114 17.8325 3.09808 17.8671 3.11385 17.8979C3.12963 17.9288 3.15363 17.9546 3.1832 17.9726C3.21277 17.9906 3.24675 18.0001 3.28138 18H5.03919C5.15872 18 5.27122 17.9414 5.34153 17.8453L12.0001 8.66719L18.6587 17.8453C18.729 17.9414 18.8415 18 18.9611 18H20.7189C20.8712 18 20.9603 17.8266 20.8712 17.7023V17.7023Z" fill="#4F51FD"/>
</svg>
'; 
$m_nav_icon_plus    = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 5V19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5 12H19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
'; 
$m_nav_icon_minus   = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5 12H19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';

$m_nav_icons = array(
	'icon_chevron' => $m_nav_icon_chevron,
	'icon_plus'    => $m_nav_icon_plus,
	'icon_minus'   => $m_nav_icon_minus,
);

$m_nav_sections = array(
	array( 'menu' => 'GCv2.0 : Services' ),
	array(
		'menu'           => 'GCv2.0 : Industries',
		'view_all_label' => __( 'View All Industries', 'gc-v2' ),
		'view_all_url'   => home_url( '/industries/' ),
	),
	array( 'menu' => 'GCv2.0 : Integrations' ),
	array( 'menu' => 'GCv2.0 : Pricing' ),
	array( 'menu' => 'GCv2.0 : Company' ),
	array( 'menu' => 'GCv2.0 : Contact Us' ),
);
?>
<nav>
	<div id="mobile-nav">
		<div class="m-nav__sections">
			<?php
			foreach ( $m_nav_sections as $m_nav_section ) {
				wp_nav_menu(
					array_merge(
						$m_nav_icons,
						$m_nav_section,
						array(
							'walker'     => new Mobile_Nav_Walker(),
							'menu_class' => 'm-nav__section-list',
							'container'  => false,
						)
					)
				);
			}
			?>
		</div>

		<div id="buttons">
			<a href="<?php echo esc_url( home_url( '/book-a-demo/' ) ); ?>" target="_parent" class="button blue full">
				<?php esc_html_e( 'Book a Demo', 'gc-v2' ); ?>
			</a>
			<a href="https://app.gcheck.com/sdocs/secure_home.html" target="_parent" class="button white full">
				<?php esc_html_e( 'Login', 'gc-v2' ); ?>
			</a>
		</div>
	</div>
</nav>
