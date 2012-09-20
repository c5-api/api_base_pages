<?php defined('C5_EXECUTE') or die('Access Denied.');
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper('/pages', t('Manage settings for the /pages route'));
	$ih = Loader::helper('concrete/interface');
	$valt = Loader::helper('validation/token');

	foreach($types as $type) { ?>
		<table class="table" border="0" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<tr>
					<th colspan="2"><?php echo $type?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($list[$type] as $handle => $name) { ?>
					<tr>
	                    <td width="60%"><?php echo $name?></td>
	                    <td width="40%"><input type="checkbox" name="<?php echo $handle?>" value="1"/></td>
	                </tr>
				<?php
				}
				?>
			</tbody>

	<?php 	
	}
echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();