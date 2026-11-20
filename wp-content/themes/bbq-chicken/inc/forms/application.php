<?php
/**
 * Franchise application form (Franchise page #apply, Apply page, and the "Submit your application"
 * pop-up, which fetches it from the Apply page – assets/js/apply.js).
 * Created by Appearance → bb.q setup; edit later under Contact → Contact Forms.
 * Markup follows the static form in html-backup/src/pages/apply.html (ids app-…; the Franchise page
 * prints the same form with f-… ids, see inc/parts/franchise.php).
 */
defined( 'ABSPATH' ) || exit;

$arrow     = bbq_icon_svg( 'arrow' );
$countries = array( 'Albania', 'Andorra', 'Austria', 'Belgium', 'Bosnia and Herzegovina', 'Bulgaria', 'Croatia', 'Cyprus', 'Czech Republic', 'Denmark', 'Estonia', 'Finland', 'France', 'Germany', 'Greece', 'Hungary', 'Iceland', 'Ireland', 'Italy', 'Latvia', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Malta', 'Moldova', 'Monaco', 'Montenegro', 'Netherlands', 'North Macedonia', 'Norway', 'Poland', 'Portugal', 'Romania', 'San Marino', 'Serbia', 'Slovakia', 'Slovenia', 'Spain', 'Sweden', 'Switzerland', 'United Kingdom', 'Several countries / other' );

return array(
	'title'               => 'Franchise application (Franchise + Apply pages, pop-up)',
	'html_id'             => 'application-form',
	'html_class'          => 'form app-form',
	'thank_you'           => true,
	'form'                => '<div class="form-row">
<div class="field">
<label class="field__label" for="app-name">Full name *</label>
[text* your-name id:app-name class:input autocomplete:name placeholder "First and last name"]
</div>
<div class="field">
<label class="field__label" for="app-email">Email *</label>
[email* your-email id:app-email class:input autocomplete:email placeholder "name@company.com"]
</div>
</div>
<div class="field">
<label class="field__label" for="app-role">Current role &amp; Company *</label>
[text* role-company id:app-role class:input autocomplete:organization-title placeholder "e.g. Managing Director, Example Foods Ltd"]
</div>
<div class="field">
<label class="field__label" for="app-country">Country or city you\'re targeting *</label>
[select* country id:app-country class:select first_as_label "Select a country" "' . implode( '" "', $countries ) . '"]
</div>
<fieldset class="app-options">
<legend class="field__label">How many restaurants do you plan to open? *</legend>
[radio restaurants class:app-options__list use_label_element "1 to 4" "5 to 9" "10 to 24" "25 or more"]
</fieldset>
<div class="field app-upload" data-upload>
<label class="field__label" for="app-docs">Relevant documents (optional)</label>
<div class="app-upload__zone">
<div class="app-upload__drop">
[file documents id:app-docs class:app-upload__input limit:10mb filetypes:pdf|application/pdf]
<span class="app-upload__icon" aria-hidden="true">↑</span>
<span class="app-upload__title" aria-hidden="true" data-upload-title><span class="only-desktop">Drag a file here or browse</span><span class="only-mobile">Tap to upload a file</span></span>
</div>
<p class="app-upload__hint" id="app-docs-hint">CV, LinkedIn profile, company presentation or a short note on why bb.q suits you. PDF, max 10 MB.</p>
</div>
</div>
<div class="check app-consent">[acceptance consent]I agree that BLT Global Brands processes my details to handle this application. <a href="' . esc_url( bbq_page_url( 'legal' ) ) . '">Privacy policy</a>[/acceptance]</div>
<div class="form-submit">
<button class="btn btn--red wpcf7-submit" type="submit">Submit your application <span class="btn__chip">' . $arrow . '</span></button>
<p class="form-submit__note">No obligation. We never share your details with third parties.</p>
</div>',
	// Notification to the site admin, with every answer and the uploaded PDF.
	'mail'                => array(
		'subject'            => '[_site_title] franchise application: [your-name] – [country]',
		'recipient'          => '[_site_admin_email]',
		'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
		'body'               => "New franchise application\n\n"
			. "Full name: [your-name]\n"
			. "Email: [your-email]\n"
			. "Current role & company: [role-company]\n"
			. "Country or city targeted: [country]\n"
			. "Restaurants planned: [restaurants]\n"
			. "Relevant documents: [documents]\n"
			. "Privacy: [consent]\n\n"
			. "-- \nSent from [_url] on [_site_title] ([_site_url]), [_date] [_time]",
		'attachments'        => '[documents]',
		'use_html'           => false,
		'exclude_blank'      => false,
	),
	// Confirmation to the applicant (Figma "Confirmation email", Apply – Thank you 142-1118).
	'mail_2'              => array(
		'active'             => true,
		'subject'            => 'Thanks for your interest in bb.q Chicken',
		'recipient'          => '[your-email]',
		'additional_headers' => 'Reply-To: [_site_admin_email]',
		'body'               => "Hi [your-name],\n\n"
			. "Thanks for applying for a bb.q territory in [country]. We've received your details and our team will be in touch within 5 working days.\n\n"
			. 'In the meantime, the franchise FAQ answers the questions most operators ask first: ' . bbq_page_url( 'franchise', 'faq' ) . "\n\n"
			. "Speak soon,\nThe bb.q Europe team",
		'attachments'        => '',
		'use_html'           => false,
		'exclude_blank'      => false,
	),
	'messages'            => array(
		'mail_sent_ok'             => 'Thank you for your interest. Our team will be in touch within 5 working days.',
		'accept_terms'             => 'Please agree to the processing of your details.',
		'upload_file_type_invalid' => 'Please choose a PDF file.',
		'upload_file_too_large'    => 'Please choose a PDF of 10 MB or less.',
	),
	// The consent box is validated like the other fields (CF7 would otherwise disable the submit
	// button until it is ticked, which the design doesn't show).
	'additional_settings' => 'acceptance_as_validation: on',
);
