<?php
    $brandname = get_sub_field('brand_name');
    $brandlink = get_sub_field('brand_link');

    
    $imagename = strtolower($brandname);
    $imageSetting = str_replace(" ", "-", $imagename);
    
?>
<div class="page-hero Center yes">
    <div class="container">

        <section class="text-only">
            <div>
                <span class="logos Center ">
                </span>
                <div class="heading">

                </div>
                <pre>CERTIFIED INTEGRATION PARTNER</pre>
                <ul class="logos">
                    <li><img loading="lazy" decoding="async" class="alignnone"
                            src="https://gcheck.com/wp-content/uploads/2023/12/logo.svg"
                            alt="GCheck Background Screening" width="136" height="32"></li>
                    <li>VS</li>
                    <li><img loading="lazy" decoding="async" class="alignnone size-full wp-image-13116"
                            src="https://gcheck.com/wp-content/themes/gc-v2.0/assets/images/<?= $imageSetting ?>-logo.png" alt=""
                            width="60" height="60"></li>
                </ul>
                <h1>Streamline Your Hiring with<br>
                    GCheck's <?= $brandname ?> Integration</h1>
                <p><span style="font-weight: 400;">Fast, compliant background screening directly within
                        <?= $brandname ?><br>
                    </span><span style="font-weight: 400;">Trusted by industry leaders for accurate results and
                        white-glove support.</span></p>
                <ul class="bullets">
                    <li>No setup fees</li>
                    <li>30-Day Trial</li>
                    <li>FCRA Compliant</li>
                </ul>

                <div class="btns">

                    <a class="button blue" href="<?= $brandlink ?>" target="_self"
                        aria-label="Schedule Integration Demo">
                        Schedule Integration Demo </a>
                    <a class="button blue" href="<?= $brandlink ?>" target="_self"
                        aria-label="Download Integration Guide">
                        Download Integration Guide </a>

                </div>

            </div>
        </section>
    </div>
</div>

<div class="cards top-icon ">
    <div class="container">

        <div class="card-cont cols2">

            <div>
                <h4>
                    <span>
                        <p>Enterprise ATS (Workday, SAP SuccessFactors, Oracle):</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p><span style="font-weight: 400;">“Enterprise-grade background screening integration for
                        <?= $brandname ?>.
                        Scalable, secure, and compliant screening that grows with your global workforce.”</span></p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Mid-Market ATS (Greenhouse, Lever, SmartRecruiters):</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p><span style="font-weight: 400;">“Accelerate your hiring with seamless <?= $brandname ?> background
                        check
                        integration. Reduce time-to-hire while maintaining compliance standards.”</span></p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>SMB ATS (BambooHR, JazzHR, Workable):</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p><span style="font-weight: 400;">“Simple, powerful background screening for <?= $brandname ?>. Get
                        enterprise-level screening capabilities without the complexity or cost.”</span></p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Staffing-Focused ATS (Bullhorn, JobDiva, Avionté):</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p><span style="font-weight: 400;">“Purpose-built for staffing agencies using <?= $brandname ?>. Fast
                        turnaround
                        times and candidate-friendly experience that protects your client relationships.”</span></p>
            </div>
        </div>


    </div>
</div>

<div class="cards image ">
    <div class="container">


        <div class="heading">
            <h2>
                <span></span>
                <pre>How GCheck Transforms Your <?= $brandname ?> Workflow</pre>
            </h2>
        </div>


        <div class="card-cont cols3">

            <div>

                <span>
                    <img src="https://gcheck.com/wp-content/uploads/2025/11/<?= $imageSetting ?>-benefits-img1.jpg">
                </span>
                <span class="desc">
                    <h3>One-Click Screening</h3>
                    <p>Order background checks directly from <?= $brandname ?> candidate profiles. No platform
                        switching, no
                        data re-entry, no delays.</p>
                </span>

            </div>
            <div>

                <span>
                    <img src="https://gcheck.com/wp-content/uploads/2025/11/<?= $imageSetting ?>-benefits-img2.jpg">
                </span>
                <span class="desc">
                    <h3>Real-Time Visibility</h3>
                    <p>Track screening progress live within ICISM. Receive instant notifications and status updates
                        throughout the process.</p>
                </span>

            </div>
            <div>

                <span>
                    <img src="https://gcheck.com/wp-content/uploads/2025/11/<?= $imageSetting ?>-benefits-img3.jpg">
                </span>
                <span class="desc">
                    <h3>Built-in Compliance</h3>
                    <p>Automated FCRA compliance, adverse action workflows, and audit trails. Stay compliant without the
                        administrative burden.</p>
                </span>

            </div>
        </div>


    </div>
</div>

<div class="dark-box dark">
    <div class="container">
        <div class="heading">
            <h2>
                <pre>ATS-Specific Benefit Customization:</pre>
            </h2>
        </div>
        <div class="cards no-icon">
            <div class="card-cont cols3">

                <div>
                    <h4>
                        <span>
                            For Applicant Volume-Heavy ATS (Greenhouse, Workday): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Bulk Processing” –
                                Handle high-volume screening efficiently</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Automated
                                Workflows” - Reduce manual intervention at scale</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Advanced
                                Analytics” - Track screening metrics and optimize processes</span></li>
                    </ul>
                </div>
                <div>
                    <h4>
                        <span>
                            For Compliance-Critical ATS (Healthcare/Finance focused): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Enhanced
                                Verification” - Comprehensive credential and license checking</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Audit Trail
                                Management” - Complete documentation for regulatory reviews</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Custom Compliance
                                Rules” - Tailored screening based on role requirements</span></li>
                    </ul>
                </div>
                <div>
                    <h4>
                        <span>
                            For International ATS (Workday, SAP): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Global Screening
                                Capabilities” - International background checks</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span
                                style="font-weight: 400;">“Multi-jurisdictional Compliance” - Navigate varying
                                international regulations</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">“Localized
                                Candidate Experience” - Multi-language support</span></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="cards top-icon ">
    <div class="container">


        <div class="heading">
            <h2>
                <pre><?= $brandname ?> Integration Features</pre>
            </h2>
        </div>


        <div class="card-cont cols2">

            <div>
                <h4>
                    <span>
                        <p><span style="font-weight: 400;">Seamless Data Flow</span></p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Automatic candidate data pre-population from <?= $brandname ?></li>
                    <li>Real-time screening status updates within [ATS Name] dashboard</li>
                    <li>Bi-directional data synchronization</li>
                    <li>Custom field mapping and data validation</li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p><span style="font-weight: 400;">Workflow Automation</span></p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Trigger-based screening initiation (job offer, final interview)</li>
                    <li>Automated package selection based on role/department</li>
                    <li>Conditional logic for multi-stage screening processes</li>
                    <li>Bulk screening capabilities for high-volume hiring</li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p><span style="font-weight: 400;">Compliance &amp; Security</span></p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>FCRA-compliant adverse action workflows within [ATS Name]</li>
                    <li>SOC 2 Type II certified data protection</li>
                    <li>Automated consent capture and documentation</li>
                    <li>Role-based access controls and audit logging</li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p><span style="font-weight: 400;">Candidate Experience</span></p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Mobile-optimized screening completion</li>
                    <li>Transparent status communication</li>
                    <li>Multi-language support (12+ languages)</li>
                    <li>Single sign-on (SSO) capabilities</li>
                </ul>
            </div>
        </div>


    </div>
</div>


<div class="dark-box dark">
    <div class="container">
        <div class="heading">
            <h2>
                <pre>ATS-Specific Technical Highlights:</pre>
            </h2>
        </div>
        <div class="cards no-icon">
            <div class="card-cont cols3">

                <div>
                    <h4>
                        <span>
                            API-Rich ATS (Greenhouse, Lever, SmartRecruiters): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">REST API
                                integration with webhook support</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Custom field
                                creation and management</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Advanced reporting
                                and analytics API</span></li>
                    </ul>
                </div>
                <div>
                    <h4>
                        <span>
                            Legacy ATS (Taleo, BrassRing): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Certified
                                integration through established protocols</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Backward
                                compatibility with older system versions</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Dedicated migration
                                support for system upgrades</span></li>
                    </ul>
                </div>
                <div>
                    <h4>
                        <span>
                            Cloud-First ATS (Workday, SAP SuccessFactors): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Native
                                cloud-to-cloud connectivity</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Elastic scaling for
                                varying screening volumes</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Real-time data
                                synchronization</span></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="cards top-icon ">
    <div class="container">


        <div class="heading">
            <h2>
                <span></span>
                <pre>Comprehensive Screening Services for <?= $brandname ?> Users</pre>
            </h2>
            <p>&nbsp;</p>
            <h3><span style="font-weight: 400;">Background Screening</span></h3>
        </div>


        <div class="card-cont cols2">

            <div>
                <h4>
                    <span>
                        <p><span style="font-weight: 400;">Criminal History</span></p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>County, State, Federal criminal searches</li>
                    <li>National criminal database searches</li>
                    <li>Sex offender registry checks</li>
                    <li>International criminal history (190+ countries)</li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p><span style="font-weight: 400;">Employment &amp; Education Verification</span></p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Previous employment verification</li>
                    <li>Education degree and credential verification</li>
                    <li>Professional license verification</li>
                    <li>Reference checks and employment gap analysis</li>
                </ul>
            </div>
        </div>


    </div>
</div>


<div class="dark-box dark">
    <div class="container">
        <div class="heading">
            <h2>
                <pre>Why Industry Leaders Choose
GCheck for <?= $brandname ?> Integration</pre>
            </h2>
        </div>
        <div class="cards no-icon">
            <div class="card-cont cols3">

                <div>
                    <h4>
                        <span>
                            Faster Time-to-Hire </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <p><strong class="stat">67% faster</strong></p>
                    <p>Average reduction in screening completion time through automated workflows and streamlined
                        processes within <?= $brandname ?>.</p>
                </div>
                <div>
                    <h4>
                        <span>
                            Compliance Confidence </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <p><strong class="stat">100% FCRA</strong></p>
                    <p>Built-in compliance automation ensures every screening meets federal<br>
                        and state requirements. PBSA accreditation pending.</p>
                </div>
                <div>
                    <h4>
                        <span>
                            Cost Effectiveness </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <p><strong class="stat">30% savings</strong></p>
                    <p>Competitive pricing with transparent cost structure. No hidden fees, setup costs, or long-term
                        contracts required.</p>
                </div>
                <div>
                    <h4>
                        <span>
                            White-Glove Support </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <p><strong class="stat">24/7 support</strong></p>
                    <p>Dedicated customer success team with direct access to technical specialists. Live chat, phone,
                        and email support.</p>
                </div>
                <div>
                    <h4>
                        <span>
                            Enterprise Security </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <p><strong class="stat">SOC 2 certified</strong></p>
                    <p>Bank-level security with SOC 2 Type II certification. Encrypted data transmission and secure API
                        connections.</p>
                </div>
                <div>
                    <h4>
                        <span>
                            Proven at Scale </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <p><strong class="stat">Trusted by</strong></p>
                    <p>Used by industry leaders including LinkedIn, OpenAI, T-Mobile, Palantir, and HubSpot for critical
                        hiring decisions.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="cards top-icon ">
    <div class="container">


        <div class="heading">
            <h2>
                <span></span>
                <pre>Industry-Specific Value Props:</pre>
            </h2>
        </div>


        <div class="card-cont cols3">

            <div>
                <h4>
                    <span>
                        <p>Technology Companies (using Greenhouse, Lever):</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Fast scaling
                            capabilities for rapid growth</span></li>
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Technical integration
                            support and API documentation</span></li>
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Advanced analytics for
                            hiring optimization</span></li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Healthcare Organizations (using Workday, Cornerstone):</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Specialized healthcare
                            credentialing</span></li>
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Joint Commission
                            compliance support</span></li>
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">License verification
                            and monitoring</span></li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Financial Services (using Workday, SAP SuccessFactors):</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li style="font-weight: 400; text-align: left;" aria-level="1"><span
                            style="font-weight: 400;">Enhanced due diligence capabilities</span></li>
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">FINRA and regulatory
                            compliance</span></li>
                    <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Credit history and
                            financial background checks</span></li>
                </ul>
            </div>
        </div>


    </div>
</div>


<div class="cards right-icon ">
    <div class="container">


        <div class="heading">
            <h2>
                <span></span>
                <pre><?= $brandname ?> Integration Implementation</pre>
            </h2>
        </div>


        <div class="card-cont cols2">

            <div>
                <h4>
                    <span>
                        <p>Discovery &amp; Planning (Week 1)</p>
                    </span>
                    <span>
                        <p><img loading="lazy" decoding="async" class="alignnone wp-image-14327"
                                src="https://gcheck.com/wp-content/uploads/2025/12/1.png" alt="" width="56" height="56"
                                srcset="https://gcheck.com/wp-content/uploads/2025/12/1.png 180w, https://gcheck.com/wp-content/uploads/2025/12/1-150x150.png 150w"
                                sizes="(max-width: 56px) 100vw, 56px"></p>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Technical requirements assessment</li>
                    <li>[ATS Name] configuration review</li>
                    <li>Custom workflow mapping</li>
                    <li>Security and compliance verification</li>
                </ul>
                <p><strong class="step-duration">3-5 business days</strong></p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Integration Setup (Week 2)</p>
                    </span>
                    <span>
                        <p><img loading="lazy" decoding="async"
                                src="https://gcheck.com/wp-content/uploads/2025/12/2.png" alt="" width="56" height="56"
                                class="alignnone size-full wp-image-14335"
                                srcset="https://gcheck.com/wp-content/uploads/2025/12/2.png 180w, https://gcheck.com/wp-content/uploads/2025/12/2-150x150.png 150w"
                                sizes="(max-width: 56px) 100vw, 56px"></p>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>API connection and authentication</li>
                    <li>Data field mapping and validation</li>
                    <li>Screening package configuration</li>
                    <li>Workflow automation setup</li>
                </ul>
                <p><strong class="step-duration">5-7 business days</strong></p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Testing &amp; Validation (Week 3)</p>
                    </span>
                    <span>
                        <p><img loading="lazy" decoding="async"
                                src="https://gcheck.com/wp-content/uploads/2025/12/3.png" alt="" width="56" height="56"
                                class="alignnone size-full wp-image-14338"
                                srcset="https://gcheck.com/wp-content/uploads/2025/12/3.png 180w, https://gcheck.com/wp-content/uploads/2025/12/3-150x150.png 150w"
                                sizes="(max-width: 56px) 100vw, 56px"></p>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>End-to-end integration testing</li>
                    <li>User acceptance testing (UAT)</li>
                    <li>Compliance workflow verification</li>
                    <li>Performance and security testing</li>
                </ul>
                <p><strong class="step-duration">3-5 business days</strong></p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Training &amp; Go-Live (Week 4)</p>
                    </span>
                    <span>
                        <p><img loading="lazy" decoding="async" class="alignnone size-full wp-image-14339"
                                src="https://gcheck.com/wp-content/uploads/2025/12/4.png" alt="" width="56" height="56"
                                srcset="https://gcheck.com/wp-content/uploads/2025/12/4.png 180w, https://gcheck.com/wp-content/uploads/2025/12/4-150x150.png 150w"
                                sizes="(max-width: 56px) 100vw, 56px"></p>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Administrator training sessions</li>
                    <li>End-user training and documentation</li>
                    <li>Soft launch with limited users</li>
                    <li>Full production deployment</li>
                </ul>
                <p><strong class="step-duration">2-3 business days</strong></p>
            </div>
        </div>


    </div>
</div>


<div class="cards top-icon ">
    <div class="container">


        <div class="heading">
            <h2>
                <span></span>
                <pre></pre>
            </h2>
            <h3>What You Get During Implementation</h3>
        </div>


        <div class="card-cont cols2">

            <div>
                <h4>
                    <span>
                        <p>Dedicated Project Manager</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p>Single point of contact throughout the implementation process</p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Technical Integration Specialist</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p>Expert support for [ATS Name] configuration and customization</p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Compliance Consultation</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p>Ensure your workflows meet all regulatory requirements</p>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Custom Training Materials</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <p>Tailored documentation and training specific to your [ATS Name] setup</p>
            </div>
        </div>


    </div>
</div>

<div class="cards top-icon ">
    <div class="container">


        <div class="heading">
            <h2>
                <span></span>
                <pre></pre>
            </h2>
            <h3><?= $brandname ?> Integration Requirements
                <!--more-->
                <p></p>
            </h3>
        </div>


        <div class="card-cont cols3">

            <div>
                <h4>
                    <span>
                        <p>System Requirements</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li><?= $brandname ?> administrator access with API permissions</li>
                    <li>Current [ATS Name] subscription with integration capabilities</li>
                    <li>SSL certificate for secure data transmission</li>
                    <li>Whitelist GCheck API endpoints (provided during setup)</li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Compliance Requirements</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Valid business license for background screening services</li>
                    <li>FCRA compliance training for HR team members</li>
                    <li>Adverse action process documentation</li>
                    <li>Data retention and privacy policies</li>
                </ul>
            </div>
            <div>
                <h4>
                    <span>
                        <p>Organizational Readiness</p>
                    </span>
                    <span>
                    </span>
                </h4>
                <ul class="bullets">
                    <li>Defined screening policies and procedures</li>
                    <li>Designated system administrators and users</li>
                    <li>Budget approval for screening services</li>
                    <li>Change management communication plan</li>
                </ul>
            </div>
        </div>


    </div>
</div>


<div class="dark-box dark">
    <div class="container">
        <div class="heading">
            <h2>
                <pre>ATS-Specific Implementation Notes:</pre>
            </h2>
        </div>
        <div class="cards no-icon">
            <div class="card-cont cols3">

                <div>
                    <h4>
                        <span>
                            Quick Setup ATS (BambooHR, JazzHR, Workable): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Average
                                implementation: 1-2 weeks</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Pre-built
                                configuration templates</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Self-service setup
                                options available</span></li>
                    </ul>
                </div>
                <div>
                    <h4>
                        <span>
                            Enterprise ATS (Workday, SAP SuccessFactors): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Extended
                                implementation: 4-6 weeks</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Custom enterprise
                                security reviews</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Multi-environment
                                deployment (dev/test/prod)</span></li>
                    </ul>
                </div>
                <div>
                    <h4>
                        <span>
                            Legacy ATS (Taleo, BrassRing): </span>
                        <span>
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="4" fill="#F2F3FF"></rect>
                                <path
                                    d="M35.3043 21.7891H33.4722C33.0738 21.7891 32.6949 21.9805 32.4605 22.3086L26.3199 30.8242L23.5386 26.9648C23.3042 26.6406 22.9292 26.4453 22.5269 26.4453H20.6948C20.4409 26.4453 20.2925 26.7344 20.4409 26.9414L25.3081 33.6914C25.4231 33.8519 25.5747 33.9827 25.7503 34.0729C25.9259 34.1631 26.1205 34.2101 26.3179 34.2101C26.5153 34.2101 26.7099 34.1631 26.8855 34.0729C27.0611 33.9827 27.2127 33.8519 27.3277 33.6914L35.5543 22.2852C35.7066 22.0781 35.5582 21.7891 35.3043 21.7891Z"
                                    fill="#4F51FD"></path>
                                <path
                                    d="M28 10.5C18.3359 10.5 10.5 18.3359 10.5 28C10.5 37.6641 18.3359 45.5 28 45.5C37.6641 45.5 45.5 37.6641 45.5 28C45.5 18.3359 37.6641 10.5 28 10.5ZM28 42.5312C19.9766 42.5312 13.4688 36.0234 13.4688 28C13.4688 19.9766 19.9766 13.4688 28 13.4688C36.0234 13.4688 42.5312 19.9766 42.5312 28C42.5312 36.0234 36.0234 42.5312 28 42.5312Z"
                                    fill="#4F51FD"></path>
                            </svg>
                        </span>
                    </h4>
                    <ul class="bullets">
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Specialized
                                implementation: 3-4 weeks</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Legacy system
                                compatibility testing</span></li>
                        <li style="font-weight: 400;" aria-level="1"><span style="font-weight: 400;">Potential data
                                migration assistance</span></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>