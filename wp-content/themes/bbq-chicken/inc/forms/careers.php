<?php
/**
 * Open application form (Careers page, section #open-application). Created by Appearance → bb.q setup;
 * edit later under Contact → Contact Forms. Markup follows the static form in html-backup/src/pages/careers.html.
 * The CV is attached to the email.
 */
defined( 'ABSPATH' ) || exit;

$arrow     = bbq_icon_svg( 'arrow' );
$countries = '"Austria" "Belgium" "Bulgaria" "Croatia" "Cyprus" "Czech Republic" "Denmark" "Estonia" "Finland" "France" "Germany" "Greece" "Hungary" "Iceland" "Ireland" "Italy" "Latvia" "Lithuania" "Luxembourg" "Malta" "Netherlands" "Norway" "Poland" "Portugal" "Romania" "Slovakia" "Slovenia" "Spain" "Sweden" "Switzerland" "United Kingdom" "Other"';

return array(
	'title'      => 'Open application (Careers page)',
	'html_class' => 'form',
	// Square brackets in texts must be written as &#91; &#93; (CF7 reads [ … ] as form-tags).
	'form'       => '<div class="form-row">
<div class="field">
<label class="field__label" for="ca-name">Full name <span aria-hidden="true">*</span></label>
[text* your-name id:ca-name class:input autocomplete:name placeholder "First and last name"]
</div>
<div class="field">
<label class="field__label" for="ca-email">Email <span aria-hidden="true">*</span></label>
[email* your-email id:ca-email class:input autocomplete:email placeholder "name@example.com"]
</div>
</div>
<div class="field">
<label class="field__label" for="ca-country">Country <span aria-hidden="true">*</span></label>
[select* country id:ca-country class:select first_as_label "Select a country" ' . $countries . ']
</div>
<fieldset class="choice">
<legend class="field__label">Area of interest <span aria-hidden="true">*</span></legend>
<div class="choice__options">[radio area use_label_element "Restaurant" "Management" "Head office"]</div>
</fieldset>
<div class="field">
<label class="field__label" for="ca-cv">CV <span aria-hidden="true">*</span></label>
<div class="dropzone" data-dropzone>
[file* cv id:ca-cv class:dropzone__input limit:5mb filetypes:pdf|application/pdf]
<span class="dropzone__icon" aria-hidden="true">↑</span>
<span class="dropzone__text">
<span class="dropzone__title"><span class="only-desktop">Drag a file here or browse</span><span class="only-mobile">Tap to upload a file</span></span>
<span class="dropzone__hint" id="ca-cv-hint">PDF, max 5 MB</span>
</span>
</div>
</div>
<div class="field">
<label class="field__label" for="ca-note">Short note</label>
[text note id:ca-note class:input placeholder "Optional"]
</div>
<div class="check">[acceptance consent]I agree that my details are kept to match me with future vacancies. <a href="' . esc_url( bbq_page_url( 'legal' ) ) . '">Privacy policy</a>[/acceptance]</div>
<div class="form-submit">
<button class="btn btn--red wpcf7-submit" type="submit">Send application <span class="btn__chip">' . $arrow . '</span></button>
<p class="form-submit__note">We reply within 5 working days.</p>
</div>',
	'mail'       => array(
		'subject'            => '[_site_title] open application: [area] – [your-name]',
		'recipient'          => 'jobs@bltglobalbrands.com', // general career enquiries (client, 23 Nov)
		'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
		'body'               => "Open application from the Careers page\n\n"
			. "Full name: [your-name]\nEmail: [your-email]\nCountry: [country]\nArea of interest: [area]\n"
			. "CV (attached): [cv]\n\nShort note:\n[note]\n\n"
			. "-- \nSent from the careers form on [_site_title] ([_site_url])",
		'attachments'        => '[cv]',
		'use_html'           => false,
	),
	// The submit button stays active (as in the design); an unticked consent box shows a message instead.
	'additional_settings' => 'acceptance_as_validation: on',
	'messages'   => array(
		'mail_sent_ok'             => "Thank you! We've received your application and will reply within 5 working days.",
		'accept_terms'             => 'Please agree to the privacy terms to send your application.',
		'upload_file_type_invalid' => 'Please upload your CV as a PDF.',
		'upload_file_too_large'    => 'This file is too large. The maximum is 5 MB.',
	),
);
