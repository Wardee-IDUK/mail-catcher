<?php
use MailCatcher\GeneralHelper;

// TODO: Enqueue dashicons.css
?>

<link rel="stylesheet" href="/wp-includes/css/dashicons.css">

<div id="new-message" class="modal">
	<div class="modal-content">
		<form class="form-horizontal" action="?page=<?php echo GeneralHelper::$adminPageSlug; ?>&action=new_mail" method="POST">
			<div class="modal-body">
				<div class="content-container">
					<div class="content -active">
						<div>
							<h2><?php _e('Headers', GeneralHelper::$languageDomain); ?></h2>
							<hr />

							<div class="cloneable">
								<div class="field-block">
									<a href="#" class="add-field">
										<span class="dashicons dashicons-plus-alt -icon"></span>
									</a>

									<a href="#" class="remove-field -disabled">
										<span class="dashicons dashicons-dismiss -icon"></span>
									</a>

									<select name="header_keys[]" class="field -select">
										<option value="to"><?php _e('To', GeneralHelper::$languageDomain); ?></option>
										<option value="cc"><?php _e('Cc', GeneralHelper::$languageDomain); ?></option>
										<option value="bcc"><?php _e('Bcc', GeneralHelper::$languageDomain); ?></option>
										<option value="other"><?php _e('Other', GeneralHelper::$languageDomain); ?></option>
									</select>

									<input name="header_values[]" type="text" class="field -input" />
								</div>
							</div>
						</div>
						<div>
							<h2><?php _e('Subject', GeneralHelper::$languageDomain); ?></h2>
							<hr />

							<input name="subject" type="text" class="field -input" />
						</div>
						<div>
							<h2><?php _e('Attachments', GeneralHelper::$languageDomain); ?></h2>
							<hr />

							<div class="attachments-container">
								<div class="attachment-clones">
                                    <span class="attachment-item -original">
                                        <span class="dashicons dashicons-dismiss remove"></span>
                                        <input type="hidden" name="attachment_ids[]" value="" class="attachment-input" />
                                    </span>
								</div>

								<div class="attachment-button-container">
									<a href="#" class="button-primary" id="add_attachments">
										<?php _e('Add Attachments', GeneralHelper::$languageDomain); ?>
									</a>
								</div>
							</div>
						</div>
						<div>
							<h2><?php _e('Message', GeneralHelper::$languageDomain); ?></h2>
							<hr />

							<?php wp_editor('My Message', 'message', $settings = array()); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="button-primary">
					<?php _e('Send Message', GeneralHelper::$languageDomain); ?>
				</button>
				<button type="button" class="button-secondary dismiss-modal">
					<?php _e('Close', GeneralHelper::$languageDomain); ?>
				</button>
			</div>
		</form>
	</div>
	<div class="backdrop dismiss-modal"></div>
</div>