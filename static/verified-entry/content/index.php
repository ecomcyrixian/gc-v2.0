<?php
/**
 * Verified Entry page content.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/static/verified-entry/content.php';
require_once get_template_directory() . '/static/shared/content.php';

$ve         = gc_static_verified_entry_content();
$ve_img_uri = gc_static_verified_entry_images_uri();

$ve_icon = function ( $name, $modifier = '' ) {
	$class = 've-icon' . ( $modifier ? ' ve-icon--' . $modifier : '' );
	return '<svg class="' . esc_attr( $class ) . '" aria-hidden="true"><use href="#ve-icon-' . esc_attr( $name ) . '"></use></svg>';
};

$ve_steps = function ( $set, $variant, $lazy = true ) use ( $ve, $ve_img_uri ) {
	?>
	<ol class="ve-steps ve-steps--<?php echo esc_attr( $variant ); ?>">
		<?php foreach ( $ve['phones'][ $set ]['items'] as $index => $phone ) : ?>
			<li class="ve-step">
				<img src="<?php echo esc_url( $ve_img_uri . $phone['img'] . '.webp' ); ?>" alt="<?php echo esc_attr( $phone['title'] ); ?>" width="560" height="1218"<?php echo $lazy ? ' loading="lazy"' : ''; ?> decoding="async">
				<div class="ve-step__cap">
					<span class="ve-num"><?php echo esc_html( $index + 1 ); ?></span>
					<div>
						<strong><?php echo esc_html( $phone['title'] ); ?></strong>
						<span><?php echo esc_html( $phone['text'] ); ?></span>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
	<?php
};

?>
<svg class="ve-sprite" aria-hidden="true" focusable="false">
	<symbol id="ve-icon-check-circle-filled" viewBox="0 0 21 21"><path d="M 10.5 0 C 4.702 0 0 4.702 0 10.5 C 0 16.298 4.702 21 10.5 21 C 16.298 21 21 16.298 21 10.5 C 21 4.702 16.298 0 10.5 0 Z M 15.035 7.071 L 10.099 13.915 C 10.03 14.011 9.939 14.09 9.834 14.144 C 9.729 14.198 9.612 14.226 9.493 14.226 C 9.375 14.226 9.258 14.198 9.153 14.144 C 9.047 14.09 8.956 14.011 8.888 13.915 L 5.965 9.865 C 5.876 9.741 5.965 9.567 6.117 9.567 L 7.216 9.567 C 7.455 9.567 7.683 9.682 7.823 9.879 L 9.492 12.195 L 13.177 7.085 C 13.317 6.891 13.542 6.773 13.784 6.773 L 14.883 6.773 C 15.035 6.773 15.124 6.947 15.035 7.071 L 15.035 7.071 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-user" viewBox="0 0 17.625 18.656"><path d="M 16.934 15.225 C 16.492 14.178 15.85 13.226 15.045 12.424 C 14.242 11.62 13.291 10.978 12.244 10.535 C 12.234 10.53 12.225 10.528 12.216 10.523 C 13.676 9.469 14.625 7.751 14.625 5.813 C 14.625 2.602 12.023 0 8.813 0 C 5.602 0 3 2.602 3 5.813 C 3 7.751 3.949 9.469 5.409 10.526 C 5.4 10.53 5.391 10.533 5.381 10.537 C 4.331 10.98 3.389 11.616 2.581 12.427 C 1.776 13.229 1.134 14.181 0.691 15.227 C 0.256 16.252 0.022 17.351 0 18.464 C -0.001 18.489 0.004 18.514 0.013 18.537 C 0.022 18.561 0.036 18.582 0.053 18.6 C 0.071 18.618 0.092 18.632 0.115 18.642 C 0.138 18.651 0.163 18.656 0.188 18.656 L 1.594 18.656 C 1.697 18.656 1.779 18.574 1.781 18.473 C 1.828 16.664 2.555 14.97 3.839 13.685 C 5.168 12.356 6.933 11.625 8.813 11.625 C 10.692 11.625 12.457 12.356 13.786 13.685 C 15.07 14.97 15.797 16.664 15.844 18.473 C 15.846 18.577 15.928 18.656 16.031 18.656 L 17.438 18.656 C 17.463 18.656 17.487 18.651 17.51 18.642 C 17.533 18.632 17.554 18.618 17.572 18.6 C 17.589 18.582 17.603 18.561 17.612 18.537 C 17.621 18.514 17.626 18.489 17.625 18.464 C 17.602 17.344 17.37 16.254 16.934 15.225 L 16.934 15.225 Z M 8.813 9.844 C 7.737 9.844 6.724 9.424 5.963 8.663 C 5.201 7.901 4.781 6.888 4.781 5.813 C 4.781 4.737 5.201 3.724 5.963 2.962 C 6.724 2.201 7.737 1.781 8.813 1.781 C 9.888 1.781 10.901 2.201 11.663 2.962 C 12.424 3.724 12.844 4.737 12.844 5.813 C 12.844 6.888 12.424 7.901 11.663 8.663 C 10.901 9.424 9.888 9.844 8.813 9.844 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-file-search" viewBox="0 0 17.626 20.438"><path d="M 12.938 5.531 L 12.938 4.406 C 12.938 4.303 12.853 4.219 12.75 4.219 L 3.75 4.219 C 3.647 4.219 3.563 4.303 3.563 4.406 L 3.563 5.531 C 3.563 5.634 3.647 5.719 3.75 5.719 L 12.75 5.719 C 12.853 5.719 12.938 5.634 12.938 5.531 Z M 3.75 7.594 C 3.647 7.594 3.563 7.678 3.563 7.781 L 3.563 8.906 C 3.563 9.009 3.647 9.094 3.75 9.094 L 8.063 9.094 C 8.166 9.094 8.25 9.009 8.25 8.906 L 8.25 7.781 C 8.25 7.678 8.166 7.594 8.063 7.594 L 3.75 7.594 Z M 7.125 18.188 L 1.688 18.188 L 1.688 1.688 L 14.813 1.688 L 14.813 9.75 C 14.813 9.853 14.897 9.938 15 9.938 L 16.313 9.938 C 16.416 9.938 16.5 9.853 16.5 9.75 L 16.5 0.75 C 16.5 0.335 16.165 0 15.75 0 L 0.75 0 C 0.335 0 0 0.335 0 0.75 L 0 19.125 C 0 19.54 0.335 19.875 0.75 19.875 L 7.125 19.875 C 7.228 19.875 7.313 19.791 7.313 19.688 L 7.313 18.375 C 7.313 18.272 7.228 18.188 7.125 18.188 Z M 17.571 19.395 L 15.384 17.208 C 15.907 16.516 16.219 15.654 16.219 14.719 C 16.219 12.441 14.372 10.594 12.094 10.594 C 9.816 10.594 7.969 12.441 7.969 14.719 C 7.969 16.997 9.816 18.844 12.094 18.844 C 12.933 18.844 13.711 18.593 14.362 18.164 L 16.582 20.384 C 16.62 20.421 16.666 20.438 16.713 20.438 C 16.76 20.438 16.809 20.419 16.845 20.384 L 17.571 19.657 C 17.588 19.64 17.602 19.619 17.611 19.597 C 17.621 19.574 17.626 19.55 17.626 19.526 C 17.626 19.501 17.621 19.477 17.611 19.455 C 17.602 19.432 17.588 19.412 17.571 19.395 L 17.571 19.395 Z M 12.094 17.344 C 10.643 17.344 9.469 16.17 9.469 14.719 C 9.469 13.268 10.643 12.094 12.094 12.094 C 13.545 12.094 14.719 13.268 14.719 14.719 C 14.719 16.17 13.545 17.344 12.094 17.344 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-check" viewBox="0 0 24 24"><path d="M21.563 4.453 H 19.926 c-0.23 0-0.448 0.105-0.589 0.286 L 9.674 16.98 5.04 11.109 c-0.07-0.089-0.159-0.161-0.261-0.21 a 0.625 0.625 0 0 0-0.327-0.076 H 2.814 c-0.157 0-0.244 0.181-0.148 0.303 l 6.42 8.132 c 0.3 0.38 0.876 0.38 1.179 0 L 21.711 4.753 c 0.096-0.12 0.009-0.3-0.148-0.3 z"></path></symbol>
	<symbol id="ve-icon-dashboard" viewBox="0 0 21 18.750"><path d="M 20.175 6.413 C 19.648 5.165 18.884 4.031 17.925 3.075 C 16.969 2.116 15.835 1.352 14.588 0.825 C 13.291 0.277 11.918 0 10.5 0 C 9.082 0 7.709 0.277 6.413 0.825 C 5.165 1.352 4.031 2.116 3.075 3.075 C 2.116 4.031 1.352 5.165 0.825 6.413 C 0.277 7.709 0 9.082 0 10.5 C 0 13.61 1.366 16.54 3.748 18.541 L 3.788 18.574 C 3.923 18.687 4.095 18.75 4.27 18.75 L 16.732 18.75 C 16.908 18.75 17.079 18.687 17.215 18.574 L 17.255 18.541 C 19.634 16.54 21 13.61 21 10.5 C 21 9.082 20.721 7.709 20.175 6.413 Z M 16.345 16.969 L 4.655 16.969 C 3.749 16.152 3.025 15.154 2.53 14.04 C 2.035 12.925 1.78 11.719 1.781 10.5 C 1.781 8.17 2.688 5.981 4.336 4.336 C 5.984 2.688 8.173 1.781 10.5 1.781 C 12.83 1.781 15.019 2.688 16.664 4.336 C 18.312 5.984 19.219 8.173 19.219 10.5 C 19.219 12.975 18.176 15.316 16.345 16.969 Z M 13.113 7.254 C 13.078 7.219 13.03 7.199 12.981 7.199 C 12.931 7.199 12.884 7.219 12.848 7.254 L 10.868 9.234 C 10.43 9.117 9.945 9.23 9.6 9.574 C 9.478 9.696 9.381 9.841 9.315 10 C 9.249 10.159 9.215 10.33 9.215 10.502 C 9.215 10.675 9.249 10.845 9.315 11.005 C 9.381 11.164 9.478 11.309 9.6 11.43 C 9.722 11.552 9.866 11.649 10.026 11.715 C 10.185 11.781 10.356 11.815 10.528 11.815 C 10.701 11.815 10.871 11.781 11.031 11.715 C 11.19 11.649 11.334 11.552 11.456 11.43 C 11.619 11.268 11.737 11.065 11.797 10.842 C 11.856 10.62 11.856 10.385 11.796 10.162 L 13.777 8.182 C 13.849 8.109 13.849 7.99 13.777 7.917 L 13.113 7.254 L 13.113 7.254 Z M 9.984 4.875 L 11.016 4.875 C 11.119 4.875 11.203 4.791 11.203 4.688 L 11.203 2.813 C 11.203 2.709 11.119 2.625 11.016 2.625 L 9.984 2.625 C 9.881 2.625 9.797 2.709 9.797 2.813 L 9.797 4.688 C 9.797 4.791 9.881 4.875 9.984 4.875 Z M 16.078 9.984 L 16.078 11.016 C 16.078 11.119 16.163 11.203 16.266 11.203 L 18.141 11.203 C 18.244 11.203 18.328 11.119 18.328 11.016 L 18.328 9.984 C 18.328 9.881 18.244 9.797 18.141 9.797 L 16.266 9.797 C 16.163 9.797 16.078 9.881 16.078 9.984 Z M 16.376 5.362 L 15.647 4.634 C 15.612 4.599 15.564 4.579 15.514 4.579 C 15.465 4.579 15.417 4.599 15.382 4.634 L 14.055 5.96 C 14.021 5.995 14.001 6.043 14.001 6.093 C 14.001 6.142 14.021 6.19 14.055 6.225 L 14.784 6.954 C 14.857 7.027 14.977 7.027 15.049 6.954 L 16.376 5.627 C 16.448 5.555 16.448 5.435 16.376 5.362 Z M 5.627 4.634 C 5.592 4.599 5.545 4.579 5.495 4.579 C 5.445 4.579 5.398 4.599 5.362 4.634 L 4.634 5.362 C 4.599 5.398 4.579 5.445 4.579 5.495 C 4.579 5.545 4.599 5.592 4.634 5.627 L 5.96 6.954 C 6.033 7.027 6.152 7.027 6.225 6.954 L 6.954 6.225 C 7.027 6.152 7.027 6.033 6.954 5.96 L 5.627 4.634 Z M 4.641 9.797 L 2.766 9.797 C 2.662 9.797 2.578 9.881 2.578 9.984 L 2.578 11.016 C 2.578 11.119 2.662 11.203 2.766 11.203 L 4.641 11.203 C 4.744 11.203 4.828 11.119 4.828 11.016 L 4.828 9.984 C 4.828 9.881 4.744 9.797 4.641 9.797 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-lock" viewBox="0 0 16.500 18.750"><path d="M 15.75 8.25 L 14.156 8.25 L 14.156 3 C 14.156 1.343 12.813 0 11.156 0 L 5.344 0 C 3.687 0 2.344 1.343 2.344 3 L 2.344 8.25 L 0.75 8.25 C 0.335 8.25 0 8.585 0 9 L 0 18 C 0 18.415 0.335 18.75 0.75 18.75 L 15.75 18.75 C 16.165 18.75 16.5 18.415 16.5 18 L 16.5 9 C 16.5 8.585 16.165 8.25 15.75 8.25 Z M 4.031 3 C 4.031 2.276 4.62 1.688 5.344 1.688 L 11.156 1.688 C 11.88 1.688 12.469 2.276 12.469 3 L 12.469 8.25 L 4.031 8.25 L 4.031 3 Z M 14.813 17.063 L 1.688 17.063 L 1.688 9.938 L 14.813 9.938 L 14.813 17.063 Z M 7.594 13.805 L 7.594 15.047 C 7.594 15.15 7.678 15.234 7.781 15.234 L 8.719 15.234 C 8.822 15.234 8.906 15.15 8.906 15.047 L 8.906 13.805 C 9.1 13.666 9.244 13.469 9.319 13.243 C 9.393 13.017 9.394 12.773 9.321 12.546 C 9.248 12.319 9.105 12.122 8.913 11.981 C 8.72 11.841 8.488 11.765 8.25 11.765 C 8.012 11.765 7.78 11.841 7.587 11.981 C 7.395 12.122 7.252 12.319 7.179 12.546 C 7.106 12.773 7.107 13.017 7.181 13.243 C 7.256 13.469 7.4 13.666 7.594 13.805 L 7.594 13.805 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-file" viewBox="0 0 16.500 21"><path d="M 16.28 5.264 L 11.236 0.22 C 11.095 0.08 10.905 0 10.706 0 L 0.75 0 C 0.335 0 0 0.335 0 0.75 L 0 20.25 C 0 20.665 0.335 21 0.75 21 L 15.75 21 C 16.165 21 16.5 20.665 16.5 20.25 L 16.5 5.796 C 16.5 5.597 16.42 5.405 16.28 5.264 Z M 14.77 6.141 L 10.359 6.141 L 10.359 1.73 L 14.77 6.141 Z M 14.813 19.313 L 1.688 19.313 L 1.688 1.688 L 8.766 1.688 L 8.766 6.75 C 8.766 7.011 8.869 7.261 9.054 7.446 C 9.239 7.631 9.489 7.734 9.75 7.734 L 14.813 7.734 L 14.813 19.313 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-team" viewBox="0 0 18.750 18.751"><path d="M 16.692 13.779 C 16.106 13.192 15.42 12.713 14.667 12.364 C 15.729 11.504 16.406 10.191 16.406 8.719 C 16.406 6.122 14.241 3.992 11.644 4.032 C 9.087 4.072 7.027 6.155 7.027 8.719 C 7.027 10.191 7.706 11.504 8.766 12.364 C 8.013 12.713 7.327 13.192 6.741 13.779 C 5.461 15.061 4.734 16.754 4.688 18.558 C 4.687 18.583 4.691 18.608 4.7 18.632 C 4.71 18.655 4.723 18.676 4.741 18.694 C 4.758 18.712 4.779 18.726 4.802 18.736 C 4.825 18.746 4.85 18.751 4.875 18.751 L 6.188 18.751 C 6.288 18.751 6.373 18.671 6.375 18.57 C 6.42 17.211 6.97 15.938 7.938 14.972 C 8.434 14.474 9.023 14.08 9.672 13.811 C 10.321 13.542 11.016 13.405 11.719 13.407 C 13.146 13.407 14.489 13.962 15.499 14.972 C 16.465 15.938 17.016 17.211 17.063 18.57 C 17.065 18.671 17.149 18.751 17.25 18.751 L 18.563 18.751 C 18.588 18.751 18.612 18.746 18.635 18.736 C 18.658 18.726 18.679 18.712 18.697 18.694 C 18.714 18.676 18.728 18.655 18.737 18.632 C 18.746 18.608 18.751 18.583 18.75 18.558 C 18.703 16.754 17.977 15.061 16.692 13.779 Z M 11.719 11.719 C 10.917 11.719 10.163 11.408 9.598 10.84 C 9.314 10.559 9.09 10.224 8.939 9.854 C 8.788 9.484 8.713 9.088 8.719 8.689 C 8.726 7.92 9.033 7.177 9.57 6.626 C 10.132 6.05 10.884 5.729 11.688 5.719 C 12.483 5.712 13.254 6.022 13.821 6.577 C 14.402 7.147 14.721 7.908 14.721 8.719 C 14.721 9.521 14.409 10.273 13.842 10.84 C 13.564 11.12 13.233 11.342 12.869 11.492 C 12.504 11.643 12.113 11.72 11.719 11.719 Z M 5.848 9.338 C 5.827 9.134 5.815 8.928 5.815 8.719 C 5.815 8.347 5.85 7.983 5.916 7.629 C 5.932 7.545 5.888 7.458 5.81 7.423 C 5.491 7.28 5.198 7.083 4.945 6.835 C 4.647 6.546 4.412 6.198 4.256 5.813 C 4.1 5.428 4.026 5.014 4.038 4.599 C 4.059 3.847 4.362 3.132 4.889 2.593 C 5.468 2 6.246 1.676 7.073 1.686 C 7.821 1.693 8.543 1.981 9.089 2.492 C 9.274 2.665 9.434 2.858 9.567 3.064 C 9.614 3.136 9.706 3.167 9.785 3.139 C 10.198 2.996 10.634 2.895 11.081 2.848 C 11.213 2.834 11.288 2.694 11.229 2.576 C 10.467 1.069 8.911 0.029 7.111 0.001 C 4.512 -0.039 2.346 2.091 2.346 4.686 C 2.346 6.158 3.023 7.47 4.085 8.33 C 3.34 8.675 2.653 9.151 2.058 9.746 C 0.773 11.028 0.047 12.72 0 14.527 C -0.001 14.552 0.004 14.577 0.013 14.6 C 0.022 14.624 0.036 14.645 0.053 14.663 C 0.071 14.681 0.092 14.695 0.115 14.705 C 0.138 14.714 0.163 14.719 0.188 14.719 L 1.502 14.719 C 1.603 14.719 1.688 14.64 1.69 14.539 C 1.734 13.179 2.285 11.907 3.253 10.941 C 3.942 10.252 4.786 9.774 5.707 9.542 C 5.798 9.519 5.859 9.432 5.848 9.338 L 5.848 9.338 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-home" viewBox="0 0 21.249 20.068"><path d="M 20.808 9.873 L 11.752 0.822 L 11.145 0.215 C 11.006 0.077 10.819 0 10.624 0 C 10.429 0 10.242 0.077 10.104 0.215 L 0.441 9.873 C 0.299 10.014 0.187 10.182 0.111 10.368 C 0.036 10.553 -0.002 10.751 0 10.951 C 0.009 11.776 0.696 12.435 1.521 12.435 L 2.517 12.435 L 2.517 20.068 L 18.731 20.068 L 18.731 12.435 L 19.749 12.435 C 20.149 12.435 20.527 12.278 20.81 11.994 C 20.95 11.855 21.061 11.689 21.136 11.507 C 21.211 11.325 21.249 11.13 21.249 10.932 C 21.249 10.534 21.092 10.157 20.808 9.873 L 20.808 9.873 Z M 11.937 18.381 L 9.312 18.381 L 9.312 13.6 L 11.937 13.6 L 11.937 18.381 Z M 17.044 10.747 L 17.044 18.381 L 13.437 18.381 L 13.437 13.037 C 13.437 12.519 13.017 12.1 12.499 12.1 L 8.749 12.1 C 8.231 12.1 7.812 12.519 7.812 13.037 L 7.812 18.381 L 4.205 18.381 L 4.205 10.747 L 1.955 10.747 L 10.627 2.082 L 11.168 2.624 L 19.296 10.747 L 17.044 10.747 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
	<symbol id="ve-icon-calendar" viewBox="0 0 18.750 18.750"><path d="M 18 1.688 L 14.063 1.688 L 14.063 0.188 C 14.063 0.084 13.978 0 13.875 0 L 12.563 0 C 12.459 0 12.375 0.084 12.375 0.188 L 12.375 1.688 L 6.375 1.688 L 6.375 0.188 C 6.375 0.084 6.291 0 6.188 0 L 4.875 0 C 4.772 0 4.688 0.084 4.688 0.188 L 4.688 1.688 L 0.75 1.688 C 0.335 1.688 0 2.023 0 2.438 L 0 18 C 0 18.415 0.335 18.75 0.75 18.75 L 18 18.75 C 18.415 18.75 18.75 18.415 18.75 18 L 18.75 2.438 C 18.75 2.023 18.415 1.688 18 1.688 Z M 17.063 17.063 L 1.688 17.063 L 1.688 8.156 L 17.063 8.156 L 17.063 17.063 Z M 1.688 6.563 L 1.688 3.375 L 4.688 3.375 L 4.688 4.5 C 4.688 4.603 4.772 4.688 4.875 4.688 L 6.188 4.688 C 6.291 4.688 6.375 4.603 6.375 4.5 L 6.375 3.375 L 12.375 3.375 L 12.375 4.5 C 12.375 4.603 12.459 4.688 12.563 4.688 L 13.875 4.688 C 13.978 4.688 14.063 4.603 14.063 4.5 L 14.063 3.375 L 17.063 3.375 L 17.063 6.563 L 1.688 6.563 Z" fill="currentColor" fill-rule="nonzero"></path></symbol>
</svg>

<section class="ve-hero" aria-labelledby="ve-hero-title">
	<div class="container ve-hero__inner">
		<p class="ve-wordmark" aria-label="Verified Entry">Verified <span class="ve-wordmark__accent">Entry</span><span class="ve-tm">®</span></p>
		<h1 id="ve-hero-title" class="ve-hero__title"><?php echo esc_html( $ve['headline'] ); ?></h1>

		<div class="ve-pills" role="tablist" aria-label="Verified Entry flow">
			<?php foreach ( $ve['phones'] as $set => $group ) : ?>
				<?php $ve_active = 'before' === $set; ?>
				<button type="button" class="ve-pill" role="tab" id="ve-tab-<?php echo esc_attr( $set ); ?>" aria-controls="ve-panel-<?php echo esc_attr( $set ); ?>" aria-selected="<?php echo $ve_active ? 'true' : 'false'; ?>"<?php echo $ve_active ? '' : ' tabindex="-1"'; ?>>
					<?php echo esc_html( $group['label'] ); ?> <span><?php echo esc_html( $group['count'] ); ?></span>
				</button>
			<?php endforeach; ?>
		</div>

		<?php foreach ( $ve['phones'] as $set => $group ) : ?>
			<div id="ve-panel-<?php echo esc_attr( $set ); ?>" class="ve-panel" role="tabpanel" aria-labelledby="ve-tab-<?php echo esc_attr( $set ); ?>"<?php echo 'before' === $set ? '' : ' hidden'; ?>>
				<?php $ve_steps( $set, 'hero', 'before' !== $set ); ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php
gc_static_render_proof(
	array(
		'badges'    => $ve['badges'],
		'chips'     => $ve['compliance'],
		'chip_icon' => $ve_icon( 'lock' ),
	)
);
?>

<section class="ve-section" aria-labelledby="ve-halflife">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="ve-halflife"><span>The Verification Half-Life™</span>A background check’s confidence starts to fade after hire</h2>
			<p>A check confirms who someone is once. Nothing reconfirms that the person screened is the person who shows up next week. We call that erosion the Verification Half-Life™, and Verified Entry® resets the clock.</p>
		</div>

		<?php
		gc_static_render_stats(
			array(
				'items'  => $ve['stats'],
				'source' => $ve['stats_source'],
			)
		);
		?>
	</div>
</section>

<section class="ve-section ve-section--tint" aria-labelledby="ve-halves">
	<div class="container ve-stack ve-stack--lg">
		<div class="heading center">
			<h2 id="ve-halves"><span>One identity, two moments</span>Confirmed before the check. Proven after it.</h2>
		</div>

		<?php foreach ( $ve['moments'] as $moment ) : ?>
			<div class="ve-half">
				<div class="ve-half__copy">
					<span class="ve-tag"><?php echo esc_html( $moment['pill'] ); ?></span>
					<h3 class="ve-h3"><?php echo esc_html( $moment['title'] ); ?></h3>
					<p><?php echo esc_html( $moment['text'] ); ?></p>
					<ul class="bullets ve-checks">
						<?php foreach ( $moment['points'] as $point ) : ?>
							<li><?php echo esc_html( $point ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="ve-flow">
					<div class="ve-flow__dark">
						<?php $ve_steps( $moment['phones'], 'flow' ); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="ve-section" aria-labelledby="ve-why">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="ve-why"><span>Why it’s better</span>Better data in, better results out</h2>
		</div>

		<ul class="ve-cards">
			<?php foreach ( $ve['benefits'] as $benefit ) : ?>
				<li class="ve-card">
					<span class="ve-icon-box"><?php echo $ve_icon( $benefit['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<strong><?php echo esc_html( $benefit['title'] ); ?></strong>
					<span><?php echo esc_html( $benefit['text'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="ve-section ve-section--dark" aria-labelledby="ve-how">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="ve-how"><span>How it works</span>About two minutes for the candidate</h2>
		</div>

		<ol class="ve-how">
			<?php foreach ( array_values( $ve['steps'] ) as $index => $step ) : ?>
				<li>
					<span class="ve-how__num"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
					<strong><?php echo esc_html( $step['title'] ); ?></strong>
					<span><?php echo esc_html( $step['text'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="ve-section" aria-labelledby="ve-uses">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="ve-uses"><span>Who it’s for</span>Anywhere someone needs to know who just walked in</h2>
			<p>The person checking doesn’t need an app or a login. They point a phone camera at the code and see that their identity is verified.</p>
		</div>

		<div class="ve-uses">
			<?php foreach ( $ve['uses'] as $group ) : ?>
				<div class="ve-use">
					<h3 class="ve-use__title">
						<span class="ve-icon-box"><?php echo $ve_icon( $group['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<?php echo esc_html( $group['title'] ); ?>
					</h3>
					<ul>
						<?php foreach ( $group['items'] as $item ) : ?>
							<li>
								<strong><?php echo esc_html( $item['title'] ); ?></strong>
								<span><?php echo esc_html( $item['text'] ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ve-section ve-section--tint" aria-labelledby="ve-persona">
	<div class="container ve-persona">
		<div class="heading ve-heading--xl ve-persona__copy">
			<h2 id="ve-persona"><span>One person, many doors</span>This is Daniel.</h2>
			<p>Weekdays, he runs a forklift at a distribution center. Saturdays, he coaches youth soccer. Sundays, he helps in his church nursery.</p>
			<p class="ve-lede--strong">He verified once. The same credential on his phone gets him through all three doors.</p>
		</div>

		<div class="ve-persona__phone">
			<img src="<?php echo esc_url( $ve_img_uri . 'phone-credential-wallet-wallet.webp' ); ?>" alt="Daniel’s Verified Entry wallet" width="560" height="1218" loading="lazy" decoding="async">
		</div>

		<ul class="ve-moments">
			<?php foreach ( $ve['persona'] as $moment ) : ?>
				<li>
					<span class="ve-moment__icon"><?php echo $ve_icon( 'check-circle-filled', 'ok' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<div>
						<span class="ve-moment__when"><?php echo esc_html( $moment['when'] ); ?></span>
						<strong><?php echo esc_html( $moment['title'] ); ?></strong>
						<span><?php echo esc_html( $moment['text'] ); ?></span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<section class="ve-section" aria-labelledby="ve-replaces">
	<div class="container ve-stack">
		<div class="heading">
			<h2 id="ve-replaces"><span>What it replaces</span>A badge can be borrowed. A verified identity can’t.</h2>
		</div>

		<table class="ve-table">
			<thead>
				<tr>
					<th scope="col">Today</th>
					<th scope="col">Where it breaks</th>
					<th scope="col">With Verified Entry<span class="ve-tm">®</span></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $ve['replaces'] as $row ) : ?>
					<tr>
						<th scope="row"><?php echo esc_html( $row['today'] ); ?></th>
						<td data-label="Where it breaks"><?php echo esc_html( $row['breaks'] ); ?></td>
						<td data-label="With Verified Entry®" class="ve-table__win"><?php echo $ve_icon( 'check-circle-filled', 'ok' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $row['with'] ); ?></span></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>

<?php
gc_static_render_faq(
	array(
		'heading_id'   => 've-faq',
		'title_html'   => 'Verified Entry<span class="ve-tm ve-tm--mid">®</span>, answered',
		'items'        => $ve['faqs'],
		'panel_prefix' => 've-faq-panel',
		'format'       => 'gc_static_verified_entry_tm',
	)
);
?>

<section class="ve-section ve-section--tint" aria-labelledby="ve-blog">
	<div class="container ve-stack">
		<div class="heading ve-heading--row">
			<h2 id="ve-blog"><span>From the blog</span>Explore the GCheck content hub</h2>
			<a class="ve-link" href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">View all articles</a>
		</div>

		<?php
		$ve_posts = new WP_Query(
			array(
				'posts_per_page'      => 3,
				'post_type'           => 'post',
				'orderby'             => 'date',
				'order'               => 'DESC',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
		?>
		<?php if ( $ve_posts->have_posts() ) : ?>
			<ul class="ve-posts">
				<?php while ( $ve_posts->have_posts() ) : $ve_posts->the_post(); ?>
					<?php
					$ve_categories   = get_the_category();
					$ve_reading_time = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
					?>
					<li class="ve-post">
						<a href="<?php the_permalink(); ?>">
							<span class="ve-post__img">
								<?php the_post_thumbnail( 'large', array( 'alt' => '', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
							</span>
							<span class="ve-post__body">
								<?php if ( ! empty( $ve_categories ) ) : ?>
									<span class="ve-post__cat"><?php echo esc_html( $ve_categories[0]->name ); ?></span>
								<?php endif; ?>
								<strong><?php the_title(); ?></strong>
								<span class="ve-post__meta"><?php echo esc_html( get_the_date( 'j M, Y' ) ); ?> · <?php echo esc_html( $ve_reading_time ); ?> min read</span>
							</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</section>

<?php
gc_static_render_banner(
	array(
		'heading_id' => 've-cta',
		'title_html' => 'Reset the <span class="ve-nowrap">Verification Half-Life<span class="ve-tm ve-tm--mid">™</span></span> on every shift',
		'text'       => 'See Verified Entry® with your own hiring flow in a 20-minute demo.',
		'buttons'    => array(
			array(
				'class' => 'white',
				'href'  => home_url( '/book-a-demo/' ),
				'label' => 'Book a demo',
			),
			array(
				'class' => 'ghost',
				'href'  => home_url( '/contact-us/' ),
				'label' => 'Talk to sales',
			),
		),
	)
);
?>
