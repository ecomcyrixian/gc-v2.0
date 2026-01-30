<?php
/**
 * Template Part: Blog V2 About The Creator (inline at end of content)
 * Renders after the_content() in the main column.
 */
$creator_avatar = get_template_directory_uri() . '/assets/images/pat-hat.png';
?>
<div class="wp-block-group _article-about-creator">
    <div class="blog-v2-about-creator__header">
        <div class="blog-v2-about-creator__avatar">
            <img src="<?php echo esc_url( $creator_avatar ); ?>" alt="Pat Hartonian">
        </div>
        <div class="blog-v2-about-creator__info">
            <div class="blog-v2-about-creator__label">ABOUT THE CREATOR</div>
            <div class="blog-v2-about-creator__name-wrapper">
                <h3 class="blog-v2-about-creator__name">Pat Hartonian</h3>
            </div>
            <p class="blog-v2-about-creator__job">VP of Operations at GCheck</p>
        </div>
    </div>
    <div class="blog-v2-about-creator__bio">
        <p>Pat Hartonian is VP of Operations at GCheck with over 15 years of experience in background screening, specializing in FCRA compliance, operational excellence, and scaling high-volume screening programs. <br><br>A certified expert in FCRA and Generative AI, he leads operations, dev-ops, and cross-functional collaboration to build ethical, human-centered, and secure screening solutions. He is also the author of Decoding Humans, exploring ethics, persuasion, and AI, and is recognized as a thought leader in responsible screening, operational innovation, and AI ethics.</p>
    </div>
</div>
