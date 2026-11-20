<?php
/**
 * Premises offer form (Real estate page, section #offer). Created by Appearance → bb.q setup; edit later
 * under Contact → Contact Forms. Markup follows the static form in html-backup/src/pages/real-estate.html.
 * Uploaded plans/photos are attached to the email.
 */
defined( 'ABSPATH' ) || exit;

$arrow     = bbq_icon_svg( 'arrow' );
$countries = '"Austria" "Belgium" "Bulgaria" "Croatia" "Cyprus" "Czech Republic" "Denmark" "Estonia" "Finland" "France" "Germany" "Greece" "Hungary" "Iceland" "Ireland" "Italy" "Latvia" "Lithuania" "Luxembourg" "Malta" "Netherlands" "Norway" "Poland" "Portugal" "Romania" "Slovakia" "Slovenia" "Spain" "Sweden" "Switzerland" "United Kingdom" "Other"';

return array(
	'title'      => 'Premises offer (Real estate page)',
	'html_class' => 'form',
	'form'       => '<div class="form-row">
<div class="field">
<label class="field__label" for="re-name">Full name <span aria-hidden="true">*</span></label>
[text* your-name id:re-name class:input autocomplete:name placeholder "First and last name"]
</div>
<div class="field">
<label class="field__label" for="re-email">Email <span aria-hidden="true">*</span></label>
[email* your-email id:re-email class:input autocomplete:email placeholder "name@company.com"]
</div>
</div>
<div class="field">
<label class="field__label" for="re-company">Company <span aria-hidden="true">*</span></label>
[text* company id:re-company class:input autocomplete:organization placeholder "Company name"]
</div>
<div class="field">
<label class="field__label" for="re-phone">Phone</label>
[tel phone id:re-phone class:input autocomplete:tel placeholder "+44 …"]
</div>
<fieldset class="choice">
<legend class="field__label">You are <span aria-hidden="true">*</span></legend>
<div class="choice__options">[radio role use_label_element "Landlord" "Agent" "Developer" "Other"]</div>
</fieldset>
<div class="field">
<label class="field__label" for="re-address">Address or city <span aria-hidden="true">*</span></label>
[text* address id:re-address class:input placeholder "Street, city"]
</div>
<div class="field">
<label class="field__label" for="re-country">Country <span aria-hidden="true">*</span></label>
[select* country id:re-country class:select first_as_label "Select a country" ' . $countries . ']
</div>
<div class="field">
<label class="field__label" for="re-size">Size in m² <span aria-hidden="true">*</span></label>
[number* size id:re-size class:input min:1 placeholder "e.g. 90"]
</div>
<div class="field">
<label class="field__label" for="re-rent">Rent or price indication</label>
[text rent id:re-rent class:input placeholder "Optional"]
</div>
<div class="field">
<label class="field__label" for="re-files">Plans or photos</label>
<div class="dropzone" data-dropzone>
[file files id:re-files class:dropzone__input limit:10mb filetypes:pdf|jpg|jpeg|png|application/pdf|image/jpeg|image/png]
<span class="dropzone__icon" aria-hidden="true">↑</span>
<span class="dropzone__text">
<span class="dropzone__title"><span class="only-desktop">Drag a file here or browse</span><span class="only-mobile">Tap to upload a file</span></span>
<span class="dropzone__hint" id="re-files-hint">PDF, JPG or PNG, max 10 MB</span>
</span>
</div>
</div>
<div class="field">
<label class="field__label" for="re-notes">Anything else we should know?</label>
[text notes id:re-notes class:input placeholder "Optional"]
</div>
<div class="check">[acceptance consent]I agree that BLT Global Brands processes my details to handle this enquiry. <a href="' . esc_url( bbq_page_url( 'legal' ) ) . '">Privacy policy</a>[/acceptance]</div>
<div class="form-submit">
<button class="btn btn--red wpcf7-submit" type="submit">Offer your premises <span class="btn__chip">' . $arrow . '</span></button>
<p class="form-submit__note">No obligation. We never share your details with third parties.</p>
</div>',
	'mail'       => array(
		'subject'            => '[_site_title] premises offer: [address], [country] – [company]',
		'recipient'          => '[_site_admin_email]',
		'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
		'body'               => "Premises offer from the Real estate page\n\n"
			. "Full name: [your-name]\nEmail: [your-email]\nCompany: [company]\nPhone: [phone]\nYou are: [role]\n\n"
			. "Address or city: [address]\nCountry: [country]\nSize in m²: [size]\nRent or price indication: [rent]\n"
			. "Plans or photos (attached): [files]\n\nAnything else we should know?\n[notes]\n\n"
			. "-- \nSent from the real estate form on [_site_title] ([_site_url])",
		'attachments'        => '[files]',
		'use_html'           => false,
	),
	// The submit button stays active (as in the design); an unticked consent box shows a message instead.
	'additional_settings' => 'acceptance_as_validation: on',
	'messages'   => array(
		'mail_sent_ok'             => 'Thank you! Our real estate team will get back to you within 5 working days.',
		'accept_terms'             => 'Please agree to the privacy terms to send the form.',
		'upload_file_type_invalid' => 'Please upload a PDF, JPG or PNG file.',
		'upload_file_too_large'    => 'This file is too large. The maximum is 10 MB.',
	),
);
