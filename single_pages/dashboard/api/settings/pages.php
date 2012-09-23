<?php defined('C5_EXECUTE') or die('Access Denied.');
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper('/pages', t('Manage settings for the /pages route'));
	$ih = Loader::helper('concrete/interface');
	$valt = Loader::helper('validation/token');
	$txt = Loader::helper('text');
	echo '<form method="post" action="'.$this->action('save').'">';
	foreach($types as $type) { ?>
		<table class="table" border="0" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<tr>
					<th colspan="2"><h3><?php echo $txt->unHandle($type)?></h3></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($list[$type] as $handle => $name) { 
					if(in_array($handle, $selected[$type])) {
						$checked = ' checked';
					} else {
						$checked = '';
					}
					?>
					<tr>
	                    <td width="60%"><?php echo $name?></td>
	                    <td width="40%"><input type="checkbox" name="<?php echo $type?>[]" value="<?php echo $handle?>"<?php echo $checked?>/></td>
	                </tr>
				<?php
				}
				?>
			</tbody>
		</table>

	<?php 	
	}
	echo '<input type="submit" value="'.t('Save').'" class="btn primary"/>';
	echo '</form>';
echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();