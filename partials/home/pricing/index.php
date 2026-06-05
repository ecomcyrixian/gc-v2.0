<?php
/**
 * Home page pricing section reuses core pricing markup with home-specific styling.
 */
get_template_part(
    'core-pages/pricing/pricing',
    null,
    array(
        'pricing_context' => 'home',
    )
);
