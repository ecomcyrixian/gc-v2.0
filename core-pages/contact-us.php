<?php get_header(); ?>
<div id="contact-us">
    <div class="container">
        <div class="form-template">
            <section>
                <div>
                    <div class="title">
                        <em>CONTACT US</em>
                        <h2>Talk to Sales</h2>
                        <p>Connect with a member of our team for a personalized demo or to learn about volume pricing and custom packages.</p>
                    </div>
                    <?php get_template_part('core-pages/forms/forms');	?>
                    <!-- <p class="fineprint">Never share sensitive information (credit card numbers, social security numbers, passwords) through this form. This site is protected by reCAPTCHA and th <a href="">Google Privacy Policy</a> and <a href="">Terms of Service</a> apply.</p> -->
                </div>
                <div>
                    <h2><i>Fast, Accurate, and Compliant</i> Background Checks — <em>Made Simple</em></h2>
                    <ul class="bullets">
                        <li>
                            <span><svg fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 1.5C6.20156 1.5 1.5 6.20156 1.5 12C1.5 17.7984 6.20156 22.5 12 22.5C17.7984 22.5 22.5 17.7984 22.5 12C22.5 6.20156 17.7984 1.5 12 1.5ZM16.5352 8.57109L11.5992 15.4148C11.5302 15.5111 11.4393 15.5896 11.3339 15.6437C11.2286 15.6978 11.1118 15.7261 10.9934 15.7261C10.8749 15.7261 10.7582 15.6978 10.6528 15.6437C10.5474 15.5896 10.4565 15.5111 10.3875 15.4148L7.46484 11.3648C7.37578 11.2406 7.46484 11.0672 7.61719 11.0672H8.71641C8.95547 11.0672 9.18281 11.182 9.32344 11.3789L10.9922 13.6945L14.6766 8.58516C14.8172 8.39062 15.0422 8.27344 15.2836 8.27344H16.3828C16.5352 8.27344 16.6242 8.44688 16.5352 8.57109V8.57109Z" fill="#5DC567"/></svg></span>
                            <p>
                                <strong>Lightning-Fast Turnaround</strong>
                                Same-day turnarounds in many regions. Industry leading 24-48 hour average turnaround across most of the US.
                            </p>
                        </li>
                            <li>
                            <span><svg fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 1.5C6.20156 1.5 1.5 6.20156 1.5 12C1.5 17.7984 6.20156 22.5 12 22.5C17.7984 22.5 22.5 17.7984 22.5 12C22.5 6.20156 17.7984 1.5 12 1.5ZM16.5352 8.57109L11.5992 15.4148C11.5302 15.5111 11.4393 15.5896 11.3339 15.6437C11.2286 15.6978 11.1118 15.7261 10.9934 15.7261C10.8749 15.7261 10.7582 15.6978 10.6528 15.6437C10.5474 15.5896 10.4565 15.5111 10.3875 15.4148L7.46484 11.3648C7.37578 11.2406 7.46484 11.0672 7.61719 11.0672H8.71641C8.95547 11.0672 9.18281 11.182 9.32344 11.3789L10.9922 13.6945L14.6766 8.58516C14.8172 8.39062 15.0422 8.27344 15.2836 8.27344H16.3828C16.5352 8.27344 16.6242 8.44688 16.5352 8.57109V8.57109Z" fill="#5DC567"/></svg></span>
                            <p>
                                <strong>AI-Powered Accuracy</strong>
                                AI-assisted human reviews provide best-in class accuracy your organization can rely on.
                            </p>
                        </li>
                        <li>
                            <span><svg fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 1.5C6.20156 1.5 1.5 6.20156 1.5 12C1.5 17.7984 6.20156 22.5 12 22.5C17.7984 22.5 22.5 17.7984 22.5 12C22.5 6.20156 17.7984 1.5 12 1.5ZM16.5352 8.57109L11.5992 15.4148C11.5302 15.5111 11.4393 15.5896 11.3339 15.6437C11.2286 15.6978 11.1118 15.7261 10.9934 15.7261C10.8749 15.7261 10.7582 15.6978 10.6528 15.6437C10.5474 15.5896 10.4565 15.5111 10.3875 15.4148L7.46484 11.3648C7.37578 11.2406 7.46484 11.0672 7.61719 11.0672H8.71641C8.95547 11.0672 9.18281 11.182 9.32344 11.3789L10.9922 13.6945L14.6766 8.58516C14.8172 8.39062 15.0422 8.27344 15.2836 8.27344H16.3828C16.5352 8.27344 16.6242 8.44688 16.5352 8.57109V8.57109Z" fill="#5DC567"/></svg></span>
                            <p>
                                <strong>Built-In FCRA Compliance</strong>
                                Our built-in FCRA compliance filters and automation make multiregional background check compliance simple.
                            </p>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
        <?php
            // ACF Configuration Widgets
            get_template_part( 'config' );
        ?>
    </div>
</div>

<?php get_footer(); ?>