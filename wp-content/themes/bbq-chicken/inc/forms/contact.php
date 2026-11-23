<?php
/**
 * Contact form (Contact page). Created by Appearance → bb.q setup; edit later under Contact → Contact Forms.
 * Markup follows the static form in html-backup/src/pages/contact.html.
 */
defined( 'ABSPATH' ) || exit;

$arrow = bbq_icon_svg( 'arrow' );

return array(
	'title'      => 'Contact (Contact page)',
	'html_class' => 'form',
	'form'       => '<div class="form-row">
<div class="field">
<label class="field__label" for="ct-name">Full name <span aria-hidden="true">*</span></label>
[text* your-name id:ct-name class:input autocomplete:name placeholder "First and last name"]
</div>
<div class="field">
<label class="field__label" for="ct-email">Email <span aria-hidden="true">*</span></label>
[email* your-email id:ct-email class:input autocomplete:email placeholder "name@example.com"]
</div>
</div>
<div class="field">
<label class="field__label" for="ct-topic">Department / Purpose <span aria-hidden="true">*</span></label>
[select* topic id:ct-topic class:select first_as_label "Choose the team your message is for" "Franchise" "Real estate" "Press & media" "Careers" "Customer question" "Other"]
</div>
<p class="topic-hint topic-hint--franchise">Want to open bb.q restaurants? <a href="' . esc_url( bbq_page_url( 'apply' ) ) . '" data-apply>Submit your application →</a></p>
<p class="topic-hint topic-hint--real-estate">Have a site that could suit bb.q? <a href="' . esc_url( bbq_page_url( 'real-estate', 'offer' ) ) . '">Offer your premises →</a></p>
<div class="field">
<label class="field__label" for="ct-message">Message <span aria-hidden="true">*</span></label>
[textarea* your-message id:ct-message class:textarea x5 placeholder "Your message"]
</div>
<div class="check">[acceptance consent]I agree that BLT Global Brands processes my details to answer my question. <a href="' . esc_url( bbq_page_url( 'legal' ) ) . '">Privacy policy</a>[/acceptance]</div>
<div class="form-submit">
<button class="btn btn--red wpcf7-submit" type="submit">Send message <span class="btn__chip">' . $arrow . '</span></button>
<p class="form-submit__note">Choosing Franchise or Real estate shows a link to the dedicated form above the message field.</p>
</div>',
	'mail'       => array(
		'subject'            => '[_site_title] contact: [topic] – [your-name]',
		'recipient'          => '[_site_admin_email]',
		'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
		'body'               => "From: [your-name] <[your-email]>\nDepartment / purpose: [topic]\n\n[your-message]\n\n-- \nSent from the contact form on [_site_title] ([_site_url])",
		'use_html'           => false,
	),
	'messages'   => array(
		'mail_sent_ok'        => 'Thank you! Your message has been received. We reply within 5 working days.',
		'accept_terms'        => 'Please tick the box to agree to how we use your details.',
	),
	// Keep the submit button active (as in the design); an unticked consent box shows a message instead.
	'additional_settings' => 'acceptance_as_validation: on',
	// Department / Purpose choices that go to their own team instead of the form's To address (see inc/forms.php).
	'routing'             => array(
		'topic' => array(
			'Careers' => 'jobs@bltglobalbrands.com',
		),
	),
);
