<?php
/**
 * Contact form success state — mirrors /thanks-for-reaching-out/ content
 * without navigating away (GTM / dataLayer can finish on the same page).
 */
$book_demo_url = home_url( '/book-a-demo/' );
$blog_url      = home_url( '/blog/' );
?>

<div class="gcheck-contact-success" id="gcheck-contact-success" role="status" aria-live="polite">

	<div class="page-hero Center no">
		<div class="container">
			<section class="text-only">
				<div>
					<span class="logos Center"></span>
					<div class="heading"></div>
					<div class="thankyou-contact-hero">
						<div class="thankyou-contact-hero__inner">
							<h4 class="thankyou-contact-hero__title">Thank You for Contacting GCheck.</h4>
							<p class="thankyou-contact-hero__message">We've received your message and our team will be in touch shortly.</p>
						</div>
						<div class="thankyou-contact-hero__divider"></div>
						<div class="thankyou-contact-hero__content">
							<p class="thankyou-contact-hero__prompt">Need answers sooner?</p>
							<p class="thankyou-contact-hero__subtext">Book a 30-minute call with a compliance expert.</p>
							<p><a class="button blue" href="<?php echo esc_url( $book_demo_url ); ?>">Book a Call Now</a></p>
							<p class="thankyou-contact-hero__note">No commitment. Just clarity.</p>
						</div>
					</div>
					<div class="btns"></div>
				</div>
			</section>
		</div>
	</div>

	<div class="cards top-icon">
		<div class="container">
			<div class="heading">
				<h2><span></span><pre></pre></h2>
				<div class="thankyou-contact-card">
					<div class="thankyou-contact-card_title">What you'll get in a 30-minute call</div>
					<div class="thankyou-contact-card_subtext">Skip the wait. In 30 minutes, our compliance experts will show you how to:</div>
				</div>
			</div>
			<div class="card-cont cols3">
				<div class="card-item">
					<h4>
						<span></span>
						<span>
							<p>
								<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<rect width="64" height="64" rx="4" fill="#F2F3FF"/>
									<path d="M48.125 27.0625C47.2465 24.9832 45.973 23.0942 44.375 21.5C42.7808 19.902 40.8918 18.6285 38.8125 17.75C36.6523 16.8359 34.3633 16.375 32 16.375C29.6367 16.375 27.3477 16.8359 25.1875 17.75C23.1082 18.6285 21.2192 19.902 19.625 21.5C18.027 23.0942 16.7535 24.9832 15.875 27.0625C14.9609 29.2227 14.5 31.5117 14.5 33.875C14.5 39.0586 16.7773 43.9414 20.7461 47.2773L20.8125 47.332C21.0391 47.5195 21.3242 47.625 21.6172 47.625H42.3867C42.6797 47.625 42.9648 47.5195 43.1914 47.332L43.2578 47.2773C47.2227 43.9414 49.5 39.0586 49.5 33.875C49.5 31.5117 49.0352 29.2227 48.125 27.0625ZM41.7422 44.6563H22.2578C20.7484 43.2953 19.5421 41.6322 18.717 39.7748C17.892 37.9174 17.4667 35.9074 17.4688 33.875C17.4688 29.9922 18.9805 26.3438 21.7266 23.6016C24.4727 20.8555 28.1211 19.3438 32 19.3438C35.8828 19.3438 39.5312 20.8555 42.2734 23.6016C45.0195 26.3477 46.5312 29.9961 46.5312 33.875C46.5312 38 44.793 41.9023 41.7422 44.6563ZM36.3555 28.4648C36.2967 28.4067 36.2174 28.3741 36.1348 28.3741C36.0521 28.3741 35.9728 28.4067 35.9141 28.4648L32.6133 31.7656C31.8828 31.5703 31.0742 31.7578 30.5 32.332C30.2966 32.535 30.1353 32.7761 30.0252 33.0416C29.9151 33.307 29.8584 33.5915 29.8584 33.8789C29.8584 34.1663 29.9151 34.4508 30.0252 34.7162C30.1353 34.9817 30.2966 35.2228 30.5 35.4258C30.703 35.6292 30.9441 35.7905 31.2095 35.9006C31.475 36.0107 31.7595 36.0674 32.0469 36.0674C32.3342 36.0674 32.6188 36.0107 32.8842 35.9006C33.1496 35.7905 33.3907 35.6292 33.5938 35.4258C33.8658 35.1546 34.0614 34.8163 34.1609 34.4452C34.2603 34.0742 34.2601 33.6834 34.1602 33.3125L37.4609 30.0117C37.582 29.8906 37.582 29.6914 37.4609 29.5703L36.3555 28.4648ZM31.1406 24.5H32.8594C33.0312 24.5 33.1719 24.3594 33.1719 24.1875V21.0625C33.1719 20.8906 33.0312 20.75 32.8594 20.75H31.1406C30.9688 20.75 30.8281 20.8906 30.8281 21.0625V24.1875C30.8281 24.3594 30.9688 24.5 31.1406 24.5ZM41.2969 33.0156V34.7344C41.2969 34.9063 41.4375 35.0469 41.6094 35.0469H44.7344C44.9062 35.0469 45.0469 34.9063 45.0469 34.7344V33.0156C45.0469 32.8438 44.9062 32.7031 44.7344 32.7031H41.6094C41.4375 32.7031 41.2969 32.8438 41.2969 33.0156ZM41.793 25.3125L40.5781 24.0977C40.5194 24.0395 40.4401 24.0069 40.3574 24.0069C40.2748 24.0069 40.1955 24.0395 40.1367 24.0977L37.9258 26.3086C37.8676 26.3673 37.835 26.4466 37.835 26.5293C37.835 26.612 37.8676 26.6913 37.9258 26.75L39.1406 27.9648C39.2617 28.0859 39.4609 28.0859 39.582 27.9648L41.793 25.7539C41.9141 25.6328 41.9141 25.4336 41.793 25.3125ZM23.8789 24.0977C23.8202 24.0395 23.7409 24.0069 23.6582 24.0069C23.5755 24.0069 23.4962 24.0395 23.4375 24.0977L22.2227 25.3125C22.1645 25.3712 22.1319 25.4505 22.1319 25.5332C22.1319 25.6159 22.1645 25.6952 22.2227 25.7539L24.4336 27.9648C24.5547 28.0859 24.7539 28.0859 24.875 27.9648L26.0898 26.75C26.2109 26.6289 26.2109 26.4297 26.0898 26.3086L23.8789 24.0977ZM22.2344 32.7031H19.1094C18.9375 32.7031 18.7969 32.8438 18.7969 33.0156V34.7344C18.7969 34.9063 18.9375 35.0469 19.1094 35.0469H22.2344C22.4062 35.0469 22.5469 34.9063 22.5469 34.7344V33.0156C22.5469 32.8438 22.4062 32.7031 22.2344 32.7031Z" fill="#4F51FD"/>
								</svg>
							</p>
						</span>
					</h4>
					<div class="card-item__divider" aria-hidden="true"></div>
					<p><strong>Run faster, more reliable background checks</strong></p>
				</div>
				<div class="card-item">
					<h4>
						<span></span>
						<span>
							<p>
								<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<rect width="64" height="64" rx="4" fill="#F2F3FF"/>
									<path d="M23.5625 21.7656C23.3906 21.7656 23.25 21.9062 23.25 22.0781V23.9531C23.25 24.125 23.3906 24.2656 23.5625 24.2656H38.5625C38.7344 24.2656 38.875 24.125 38.875 23.9531V22.0781C38.875 21.9062 38.7344 21.7656 38.5625 21.7656H23.5625ZM30.75 27.3906H23.5625C23.3906 27.3906 23.25 27.5312 23.25 27.7031V29.5781C23.25 29.75 23.3906 29.8906 23.5625 29.8906H30.75C30.9219 29.8906 31.0625 29.75 31.0625 29.5781V27.7031C31.0625 27.5312 30.9219 27.3906 30.75 27.3906ZM28.875 45.2812H20.125V17.7812H42V30.2812C42 30.4531 42.1406 30.5938 42.3125 30.5938H44.5C44.6719 30.5938 44.8125 30.4531 44.8125 30.2812V16.2188C44.8125 15.5273 44.2539 14.9688 43.5625 14.9688H18.5625C17.8711 14.9688 17.3125 15.5273 17.3125 16.2188V46.8438C17.3125 47.5352 17.8711 48.0938 18.5625 48.0938H28.875C29.0469 48.0938 29.1875 47.9531 29.1875 47.7812V45.5938C29.1875 45.4219 29.0469 45.2812 28.875 45.2812ZM46.0625 41.8438H40.4375V40.4141C42.2461 39.875 43.5625 38.2031 43.5625 36.2188C43.5625 33.8008 41.6055 31.8438 39.1875 31.8438C36.7695 31.8438 34.8125 33.8008 34.8125 36.2188C34.8125 38.1992 36.1289 39.875 37.9375 40.4141V41.8438H32.3125C31.9688 41.8438 31.6875 42.125 31.6875 42.4688V48.4062C31.6875 48.75 31.9688 49.0312 32.3125 49.0312H46.0625C46.4063 49.0312 46.6875 48.75 46.6875 48.4062V42.4688C46.6875 42.125 46.4063 41.8438 46.0625 41.8438ZM37.2344 36.2188C37.2344 35.1406 38.1094 34.2656 39.1875 34.2656C40.2656 34.2656 41.1406 35.1406 41.1406 36.2188C41.1406 37.2969 40.2656 38.1719 39.1875 38.1719C38.1094 38.1719 37.2344 37.2969 37.2344 36.2188ZM44.2656 46.6094H34.1094V44.2656H44.2656V46.6094Z" fill="#4F51FD"/>
								</svg>
							</p>
						</span>
					</h4>
					<div class="card-item__divider" aria-hidden="true"></div>
					<p><strong>Stay compliant with FCRA and state regulations</strong></p>
				</div>
				<div class="card-item">
					<h4>
						<span></span>
						<span>
							<p>
								<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<rect width="64" height="64" rx="4" fill="#F2F3FF"/>
									<path d="M48.1689 43.4062L47.2314 35.625C47.2002 35.3671 46.8837 35.2578 46.7002 35.4414L44.3837 37.7617L33.7861 27.1679C33.54 26.9257 33.1455 26.9257 32.9033 27.1679L28.9267 31.1406L18.1181 20.332C18.0594 20.2738 17.9801 20.2412 17.8974 20.2412C17.8148 20.2412 17.7355 20.2738 17.6767 20.332L15.9189 22.0976C15.8607 22.1564 15.8281 22.2357 15.8281 22.3183C15.8281 22.401 15.8607 22.4803 15.9189 22.539L28.4853 35.1132C28.7275 35.3593 29.1259 35.3593 29.3681 35.1132L33.3447 31.1406L42.1767 39.9687L39.8603 42.2851C39.819 42.3266 39.7902 42.3789 39.7771 42.436C39.764 42.4931 39.7672 42.5527 39.7864 42.608C39.8055 42.6634 39.8398 42.7122 39.8853 42.7491C39.9308 42.7859 39.9858 42.8092 40.0439 42.8164L47.8252 43.7539C48.0244 43.7812 48.1963 43.6093 48.1689 43.4062Z" fill="#4F51FD"/>
								</svg>
							</p>
						</span>
					</h4>
					<div class="card-item__divider" aria-hidden="true"></div>
					<p><strong>Avoid costly hiring mistakes before they happen</strong></p>
				</div>
			</div>
		</div>
	</div>

	<div class="page-hero Center no">
		<div class="container">
			<section class="text-only">
				<div>
					<span class="logos Center"></span>
					<div class="heading"></div>
					<div class="thankyou-contact-hero dark">
						<div class="thankyou-contact-hero__inner">
							<h4 class="thankyou-contact-hero__title">Slots for this week are almost full!</h4>
							<p class="thankyou-contact-hero__message">Secure a time that works best for you before they are gone.</p>
						</div>
						<div class="thankyou-contact-hero__content">
							<a class="button blue" href="<?php echo esc_url( $book_demo_url ); ?>">Book a Call Now</a>
							<p class="thankyou-contact-hero__note">No commitment. Just clarity.</p>
						</div>
					</div>
					<div class="btns"></div>
				</div>
			</section>
		</div>
	</div>

	<div class="cards left-icon">
		<div class="container">
			<div class="heading">
				<h2><span></span><pre></pre></h2>
				<div class="thankyou-contact-card">
					<div class="thankyou-contact-card_title">While you wait…</div>
					<div class="thankyou-contact-card_subtext">Stay sharp on screening. Here's where HR leaders go to stay informed.</div>
				</div>
			</div>
			<div class="card-cont cols2">
				<div class="card-item">
					<div class="card-item__header">
						<div class="card-item__copy">
							<h4><span><p>Check out our blog</p></span></h4>
							<p>For guides, compliance checklists, and regulation updates. All free.</p>
						</div>
						<div class="card-item__icon">
							<p>
								<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<rect width="64" height="64" rx="4" fill="#F2F3FF"/>
									<path d="M48.25 18.2891H39.3125C37.3945 18.2891 35.5195 18.8398 33.9062 19.8789L32 21.1016L30.0938 19.8789C28.4821 18.84 26.605 18.288 24.6875 18.2891H15.75C15.0586 18.2891 14.5 18.8477 14.5 19.5391V41.7266C14.5 42.418 15.0586 42.9766 15.75 42.9766H24.6875C26.6055 42.9766 28.4805 43.5273 30.0938 44.5664L31.8281 45.6836C31.8789 45.7148 31.9375 45.7344 31.9961 45.7344C32.0547 45.7344 32.1133 45.7188 32.1641 45.6836L33.8984 44.5664C35.5156 43.5273 37.3945 42.9766 39.3125 42.9766H48.25C48.9414 42.9766 49.5 42.418 49.5 41.7266V19.5391C49.5 18.8477 48.9414 18.2891 48.25 18.2891ZM24.6875 40.1641H17.3125V21.1016H24.6875C26.0703 21.1016 27.4141 21.4961 28.5742 22.2422L30.4805 23.4648L30.75 23.6406V41.6875C28.8906 40.6875 26.8125 40.1641 24.6875 40.1641ZM46.6875 40.1641H39.3125C37.1875 40.1641 35.1094 40.6875 33.25 41.6875V23.6406L33.5195 23.4648L35.4258 22.2422C36.5859 21.4961 37.9297 21.1016 39.3125 21.1016H46.6875V40.1641ZM27.5039 26.1016H20.2461C20.0938 26.1016 19.9688 26.2344 19.9688 26.3945V28.1523C19.9688 28.3125 20.0938 28.4453 20.2461 28.4453H27.5C27.6523 28.4453 27.7773 28.3125 27.7773 28.1523V26.3945C27.7812 26.2344 27.6562 26.1016 27.5039 26.1016ZM36.2188 26.3945V28.1523C36.2188 28.3125 36.3437 28.4453 36.4961 28.4453H43.75C43.9023 28.4453 44.0273 28.3125 44.0273 28.1523V26.3945C44.0273 26.2344 43.9023 26.1016 43.75 26.1016H36.4961C36.3437 26.1016 36.2188 26.2344 36.2188 26.3945ZM27.5039 31.5703H20.2461C20.0938 31.5703 19.9688 31.7031 19.9688 31.8633V33.6211C19.9688 33.7813 20.0938 33.9141 20.2461 33.9141H27.5C27.6523 33.9141 27.7773 33.7813 27.7773 33.6211V31.8633C27.7812 31.7031 27.6562 31.5703 27.5039 31.5703ZM43.7539 31.5703H36.4961C36.3437 31.5703 36.2188 31.7031 36.2188 31.8633V33.6211C36.2188 33.7813 36.3437 33.9141 36.4961 33.9141H43.75C43.9023 33.9141 44.0273 33.7813 44.0273 33.6211V31.8633C44.0313 31.7031 43.9063 31.5703 43.7539 31.5703Z" fill="#4F51FD"/>
								</svg>
							</p>
						</div>
					</div>
					<a href="<?php echo esc_url( $blog_url ); ?>" target="_self" class="button outline card-item__button" aria-label="Explore Our Blog">Explore Our Blog</a>
				</div>
				<div class="card-item">
					<div class="card-item__header">
						<div class="card-item__copy">
							<h4><span><p>Connect with us on LinkedIn</p></span></h4>
							<p>Get timely compliance updates and screening tips delivered straight to your feed.</p>
						</div>
						<div class="card-item__icon">
							<p>
								<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<rect width="64" height="64" rx="4" fill="#F2F3FF"/>
									<path d="M46.375 16.375H17.625C16.9336 16.375 16.375 16.9336 16.375 17.625V46.375C16.375 47.0664 16.9336 47.625 17.625 47.625H46.375C47.0664 47.625 47.625 47.0664 47.625 46.375V17.625C47.625 16.9336 47.0664 16.375 46.375 16.375ZM25.6445 43.0039H21.0078V28.0898H25.6445V43.0039ZM23.3281 26.0508C22.7966 26.0508 22.277 25.8932 21.835 25.5979C21.3931 25.3026 21.0486 24.8828 20.8452 24.3917C20.6418 23.9007 20.5886 23.3603 20.6923 22.839C20.796 22.3177 21.0519 21.8388 21.4278 21.4629C21.8036 21.0871 22.2825 20.8311 22.8038 20.7274C23.3251 20.6237 23.8655 20.6769 24.3566 20.8804C24.8477 21.0838 25.2674 21.4282 25.5627 21.8702C25.858 22.3121 26.0156 22.8317 26.0156 23.3633C26.0117 24.8477 24.8086 26.0508 23.3281 26.0508ZM43.0039 43.0039H38.3711V35.75C38.3711 34.0195 38.3398 31.7969 35.9609 31.7969C33.5508 31.7969 33.1797 33.6797 33.1797 35.625V43.0039H28.5508V28.0898H32.9961V30.1289H33.0586C33.6758 28.957 35.1875 27.7188 37.4453 27.7188C42.1406 27.7188 43.0039 30.8086 43.0039 34.8242V43.0039Z" fill="#4F51FD"/>
								</svg>
							</p>
						</div>
					</div>
					<a href="https://www.linkedin.com/company/gcheck/" target="_self" class="button outline card-item__button" aria-label="Follow GCheck on LinkedIn">Follow GCheck on LinkedIn</a>
				</div>
			</div>
		</div>
	</div>

</div>
