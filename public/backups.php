<?php
require_once(dirname(__FILE__).'/boot.php');
require_once(SG_BACKUP_PATH.'SGBackup.php');
require_once(SG_PUBLIC_INCLUDE_PATH.'header.php');
require_once(SG_PUBLIC_INCLUDE_PATH.'sidebar.php');
$backups = SGBackup::getAllBackups();
$pluginCapabilities = backupGuardGetCapabilities();
$downloadUrl = admin_url('admin-post.php?action=backup_guard_downloadBackup&');

$pluginCapabilities = backupGuardGetCapabilities();
?>
<?php if(SGConfig::get('SG_REVIEW_POPUP_STATE') == SG_SHOW_REVIEW_POPUP): ?>
	<!--  Review Box  -->
	<script type="text/javascript">sgShowReview = 1;</script>
<?php endif; ?>
<?php if(!SGConfig::get('SG_HIDE_VERIFICATION_POPUP_STATE') &&  ($pluginCapabilities == BACKUP_GUARD_CAPABILITIES_FREE)): ?>
<div id="bg-verify-user-info-container" class="bg-verify-user-info-container">
	<div class="bg-verify-user-info-overlay"></div>
	<div class="bg-verify-user-info-popup-tbl">
		<div class="bg-verify-user-info-popup-cel">
			<div class="bg-verify-user-info-popup-content">
				<a href="javascript:void(0)" class="bg-verify-user-info-cancel"><img src="<?php echo SG_IMAGE_URL.'close.png' ?>" class="wp_fm_loader" /></a>
				<div class="bg-verify-user-info-popup-inner-content">
					<h3><?php _backupGuardT('Let us be more helpful!'); ?></h3>
					<p class="bg-verify-user-info-desc">
						<?php _backupGuardT('Tell us about your primary needs and be aware of our news and updates.'); ?>
					</p>
					<form>
						<div class="bg-verify-user-info-form-group">
							<div class="bg-verify-user-info-form-twocol">
								<input name="bg-verify-user-info-name" id="bg-verify-user-info-name" class="regular-text" type="text" value="" placeholder="First Name" />
								<span id="bg-verify-user-info-name-error" class="bg-verify-user-info-error-message"><?php _backupGuardT('Please Enter First Name.'); ?></span>
							</div>
							<div class="bg-verify-user-info-form-twocol">
								<input name="bg-verify-user-info-last-name" id="bg-verify-user-info-last-name" class="regular-text" type="text" value="" placeholder="Last Name" />
								<span id="bg-verify-user-info-last-name-error" class="bg-verify-user-info-error-message"><?php _backupGuardT('Please Enter Last Name.'); ?></span>
							</div>
						</div>
						<div class="bg-verify-user-info-form-group">
							<div class="bg-verify-user-info-form-onecol">
								<input name="bg-verify-user-info-email" id="bg-verify-user-info-email" class="regular-text" type="text" value="" placeholder="Email Address" />
								<span id="bg-verify-user-info-email-error" class="bg-verify-user-info-error-message"><?php _backupGuardT('Please Enter Valid Email Address.'); ?></span>
							</div>
						</div>
						<div class="bg-verify-user-info-form-group">
							<div class="bg-verify-user-info-form-onecol">
								<select name="bg-verify-user-prioraty" id="bg-verify-user-prioraty">
									<option value=""><?php _backupGuardT('Please Select Your Priority') ?></option>
									<option value="local backup"><?php _backupGuardT('Local Backup') ?></option>
									<option value="cloud backup"><?php _backupGuardT('Cloud Backup') ?></option>
									<option value="scheduling"><?php _backupGuardT('Scheduling') ?></option>
									<option value="migration"><?php _backupGuardT('Migration') ?></option>
									<option value="other"><?php _backupGuardT('Other') ?></option>
								</select>
								<span id="bg-verify-user-info-priority-error" class="bg-verify-user-info-error-message"><?php _backupGuardT('Please Select Your Priority.'); ?></span>
							</div>
						</div>
						<div class="bg-verify-user-info-form-group">
							<div class="bg-verify-user-info-form-onecol">
								<input name="bg-verify-user-priorati-custom" id="bg-verify-user-priorati-custom" class="regular-text" type="text" placeholder="<?php _backupGuardT('Please select your priority.') ?>" hidden>
								<span id="bg-verify-user-info-priority-custom-error" class="bg-verify-user-info-error-message"><?php _backupGuardT('Please Enter Your Priority.'); ?></span>
							</div>
						</div>
						<div class="bg-verify-user-info-control-buttons-container">
							<button class="bg-verify-user-info-verify-email button button-primary"><?php _backupGuardT("Subscribe") ?></button>
						</div>
					</form>
				</div>
				<div class="bg-privacy-links-container">
					<a href="<?php echo BACKUP_GUARD_TERMS_OF_SERVICE_URL ?>" target="_blank"><?php _backupGuardT('Terms of Service'); ?></a>
					<a href="<?php echo BACKUP_GUARD_PRIVACY_POLICY_URL ?>" target="_blank"><?php _backupGuardT('Privacy Policy'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
<div class="sg-top-info"><?php echo backupGuardLoggedMessage(); ?></div>
<div id="sg-content-wrapper">
	<div class="container-fluid">
		<fieldset>
			<div><h1 class="sg-backup-page-title"><?php _backupGuardT('Backups')?></h1></div>

			<a href="javascript:void(0)" id="sg-manual-backup" class="pull-left btn btn-success sg-backup-action-buttons" data-toggle="modal" data-modal-name="manual-backup" data-remote="modalManualBackup" sg-data-backup-type="<?php echo SG_BACKUP_METHOD_STANDARD ?>">
                <span class="sg-backup-start sg-backup-buttons-content"></span>
                <span class="sg-backup-buttons-content sg-backup-buttons-text"><?php _backupGuardT('Backup')?></span>
            </a>

			<a href="javascript:void(0)" id="sg-backup-with-migration" class="pull-left btn btn-primary sg-backup-action-buttons" data-toggle="modal" data-modal-name="manual-backup" data-remote="modalManualBackup" sg-data-backup-type="<?php echo SG_BACKUP_METHOD_MIGRATE ?>"<?php echo SGBoot::isFeatureAvailable('BACKUP_WITH_MIGRATION')?'':'disabled' ?>>
				<span class="sg-backup-migrate sg-backup-buttons-content"></span>
				<span class="sg-backup-buttons-text sg-backup-buttons-content"><?php _backupGuardT('Migrate')?></span>
			</a>
			<a href="javascript:void(0)" id="sg-import" class="btn btn-primary sg-margin-left-12 pull-left  sg-backup-action-buttons" data-toggle="modal" data-modal-name="import"  data-remote="modalImport">
                <span class="sg-backup-import sg-backup-buttons-content"></span>
                <span class="sg-backup-buttons-text sg-backup-buttons-content"><?php _backupGuardT('Import')?><span>
            </a>
			<?php if ($pluginCapabilities == BACKUP_GUARD_CAPABILITIES_FREE): ?>
			<a href="<?php echo BACKUP_GUARD_WORDPRESS_SUPPORT_URL; ?>" target="_blank">
				<button type="button" id="sg-report-problem-button" class="btn btn btn-primary sg-margin-left-12 pull-right sg-backup-action-buttons sg-button-red pull-right">
					<span class="sg-backup-report"></span>

                    <span class="sg-backup-buttons-text sg-backup-buttons-content"><?php _backupGuardT('Report issue')?></span>
				</button>
			</a>
			<?php endif; ?>
            <a id="sg-delete-multi-backups" class="pull-right btn btn-danger sg-margin-left-12 sg-backup-action-buttons">
                <span class="sg-backup-delete sg-backup-buttons-content"></span>
                <span class="sg-backup-buttons-text sg-backup-buttons-content"><?php _backupGuardT('Delete')?></span>
            </a>
			<div class="clearfix"></div><br/>
			<table class="table table-striped paginated sg-backup-table">
				<thead>
				<tr>
					<th><input type="checkbox" id="sg-checkbox-select-all" autocomplete="off"></th>
					<th><?php _backupGuardT('Filename')?></th>
					<th><?php _backupGuardT('Size')?></th>
					<th><?php _backupGuardT('Date')?></th>
					<th><?php _backupGuardT('Status')?></th>
					<th><?php _backupGuardT('Actions')?></th>
				</tr>
				</thead>
				<tbody>
				<?php if(empty($backups)):?>
					<tr>
						<td colspan="6"><?php _backupGuardT('No backups found.')?></td>
					</tr>
				<?php endif;?>
				<?php foreach($backups as $backup): ?>
					<tr>
						<td><input type="checkbox" autocomplete="off" value="<?php echo $backup['name']?>" <?php echo $backup['active']?'disabled':''?>></td>
						<td><?php echo $backup['name'] ?></td>
						<td><?php echo !$backup['active']?$backup['size']:'' ?></td>
						<td><?php echo backupGuardConvertDateTimezone($backup['date']) ?></td>
						<td id="sg-status-tabe-data-<?php echo $backup['id']?>" <?php echo $backup['active']?'data-toggle="tooltip" data-placement="top" data-original-title="" data-container="#sg-wrapper"':''?>>
							<?php if($backup['active']):
									$filteredStatuses = backupGuardFilterStatusesByActionType($backup, $backup['options']);
							?>
									<input type="hidden" class="sg-active-action-id" value="<?php echo $backup['id'];?>"/>
									<?php foreach ($filteredStatuses as $statusCode): ?>
										<span class="btn-xs sg-status-icon sg-status-<?php echo $statusCode; ?>">&nbsp;</span>
									<?php endforeach; ?>
									<div class="sg-progress progress">
										<div class="progress-bar"></div>
									</div>
							<?php else: ?>
									<?php if ($backup['status'] == SG_ACTION_STATUS_FINISHED_WARNINGS): ?>
										<span class="btn-xs text-warning" data-toggle="tooltip" data-placement="top" data-original-title="<?php if($backup['type']==SG_ACTION_TYPE_BACKUP): echo _backupGuardT('Warnings found during backup',true); elseif($backup['type']==SG_ACTION_TYPE_RESTORE): echo _backupGuardT('Warnings found during restore',true); else: echo _backupGuardT('Warnings found during upload',true); endif; ?>" data-container="#sg-wrapper"><?php _backupGuardT('Warning')?></span>
									<?php elseif ($backup['status'] == SG_ACTION_STATUS_ERROR): ?>
										<span class="btn-xs text-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php if($backup['type']==SG_ACTION_TYPE_BACKUP): echo _backupGuardT('Errors found during backup',true); elseif($backup['type']==SG_ACTION_TYPE_RESTORE): echo _backupGuardT('Errors found during restore',true); else: echo _backupGuardT('Errors found during upload',true);
										endif; ?>" data-container="#sg-wrapper"><?php _backupGuardT('Faild')?></span>
									<?php else: ?>
										<span class="btn-xs sg-text-success"><?php _backupGuardT('Success')?></span>
									<?php endif;?>
							<?php endif; ?>
						</td>
						<td class="sg-backup-actions-td">
							<?php if($backup['active']): ?>
								<?php if($backup['type'] != SG_ACTION_TYPE_RESTORE): ?>
								<a class="btn-xs sg-cancel-backup" sg-data-backup-id="<?php echo $backup['id']?>" href="javascript:void(0)" title="<?php _backupGuardT('Stop')?>">&nbsp;&nbsp;</a>
								<?php endif; ?>
							<?php else: ?>
								<a href="javascript:void(0)" data-sgbackup-name="<?php echo htmlspecialchars($backup['name']);?>" data-remote="deleteBackup" class="sg-remove-backup btn-xs" title="<?php _backupGuardT('Delete')?>">&nbsp;&nbsp;</a>
								<div class="btn-group">
									<a href="javascript:void(0)" class="sg-bg-download-button btn-xs" data-toggle="dropdown1" aria-expanded="false" title="<?php _backupGuardT('Download')?>">
										
									</a>
									<ul class="dropdown-menu">
										<?php if($backup['files']):?>
											<li>
												<a href="<?php echo $downloadUrl.'backupName='.htmlspecialchars(@$backup['name']).'&downloadType='.SG_BACKUP_DOWNLOAD_TYPE_SGBP ?>">
													<i class="glyphicon glyphicon-hdd" aria-hidden="true"></i> <?php _backupGuardT('Backup')?>
												</a>
											</li>
										<?php endif;?>
										<?php if($backup['backup_log']):?>
											<li>
												<a href="<?php echo $downloadUrl.'backupName='.htmlspecialchars(@$backup['name']).'&downloadType='.SG_BACKUP_DOWNLOAD_TYPE_BACKUP_LOG ?>">
													<i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i> <?php _backupGuardT('Backup log')?>
												</a>
											</li>
										<?php endif;?>
										<?php if($backup['restore_log']):?>
											<li>
												<a href="<?php echo $downloadUrl.'backupName='.@$backup['name'].'&downloadType='.SG_BACKUP_DOWNLOAD_TYPE_RESTORE_LOG ?>">
													<i class="glyphicon glyphicon-th-list" aria-hidden="true"></i> <?php _backupGuardT('Restore log')?>
												</a>
											</li>
										<?php endif;?>
									</ul>
								</div>
								<?php if(file_exists(SG_BACKUP_DIRECTORY.$backup['name'].'/'.$backup['name'].'.sgbp')):?>
									<a href="javascript:void(0)" title="<?php _backupGuardT('Restore')?>" class="sg-restore-button btn-xs" data-toggle="modal" data-modal-name="manual-restore" data-remote="modalManualRestore" data-sgbp-params="<?php echo htmlspecialchars($backup['name']) ?>">
										
									</a>
								<?php endif;?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-right">
				<ul class="pagination"></ul>
			</div>
		</fieldset>
	</div>
	<?php
		require_once(SG_PUBLIC_INCLUDE_PATH.'/footer.php');
	?>
</div>
<div class="clearfix"></div>
