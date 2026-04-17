    <?php
    $theme_img = static function ( string $file ): string {
        return esc_url( get_template_directory_uri() . '/core-pages/banner/images/' . $file );
    };
    ?>
    <section class="banner option8" aria-labelledby="option8-heading">
            <div class="option8__header-inner">
                <div class="option8__header-copy">
                    <p class="option8__eyebrow">How it works</p>
                    <h2 id="option8-heading" class="option8__title">Compliance That <span class="option8__title-accent">Works in Real Time</span></h2>
                </div>
                <div class="option8__lead-container">
                    <p class="option8__lead">From start to finish, compliance is handled, so you can <span>focus on hiring.</span></p>
                </div>
            </div>

            <div class="option8__panels" role="list">
                <article class="option8__panel option8__panel--1" role="listitem">
                    <div class="option8__panel-bg" style="background-image: url('<?php echo $theme_img( 'option-8-img-1.webp' ); ?>')" aria-hidden="true"></div>
                    <div class="option8__panel-body">
                        <span class="option8__step-badge" aria-hidden="true">1</span>
                        <h3 class="option8__panel-title">Initial Screening</h3>
                        <p class="option8__panel-text">Seamless workflows and ATS integrations remove manual work.</p>
                    </div>
                </article>
                <article class="option8__panel option8__panel--2" role="listitem">
                    <div class="option8__panel-bg" style="background-image: url('<?php echo $theme_img( 'option-8-img-2.webp' ); ?>')" aria-hidden="true"></div>
                    <div class="option8__panel-body">
                        <span class="option8__step-badge" aria-hidden="true">2</span>
                        <h3 class="option8__panel-title">Compliance</h3>
                        <p class="option8__panel-text">Built-in FCRA workflows ensure every step meets legal standards.</p>
                    </div>
                </article>
                <article class="option8__panel option8__panel--3" role="listitem">
                    <div class="option8__panel-bg" style="background-image: url('<?php echo $theme_img( 'option-8-img-3.webp' ); ?>')" aria-hidden="true"></div>
                    <div class="option8__panel-body">
                        <span class="option8__step-badge" aria-hidden="true">3</span>
                        <h3 class="option8__panel-title">Real-time Visibility</h3>
                        <p class="option8__panel-text">Status updates keep your team and candidates informed at every step.</p>
                    </div>
                </article>
                <article class="option8__panel option8__panel--4" role="listitem">
                    <div class="option8__panel-bg" style="background-image: url('<?php echo $theme_img( 'option-8-img-4.webp' ); ?>')" aria-hidden="true"></div>
                    <div class="option8__panel-body">
                        <span class="option8__step-badge" aria-hidden="true">4</span>
                        <h3 class="option8__panel-title">Actionable Results</h3>
                        <p class="option8__panel-text">Mobile-friendly, easy-to-review reports for faster decisions.</p>
                    </div>
                </article>
            </div>
    </section>
