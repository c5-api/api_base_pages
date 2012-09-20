<?php defined('C5_EXECUTE') or die('Access Denied.');
	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper('/pages', t('Manage settings for the /pages route'));
	$ih = Loader::helper('concrete/interface');
	$valt = Loader::helper('validation/token');?>
		<div class="clearfix">

			<table class="table" border="0" cellspacing="0" cellpadding="0" width="100%">
	            <thead>
	                <tr>
	                    <th colspan="2"><?php echo t('Page Information to return.')?></th>
	                </tr>
	            </thead>
	            <tbody>
	                <tr>
	                    <td width="60%"><?php echo t('Collection ID')?></td>
	                    <td width="40%"><input type="checkbox" name="cID" value="1"/></td>
	                </tr>	
	                <tr>
	                    <td><input type="text" name="uName" autocomplete="off" value="test" style="width: 95%"></td>
	                    <td><input type="text" name="uEmail" autocomplete="off" value="test@me.com" style="width: 95%"></td>
					</tr>
	            </tbody>
			</table>
			
		</div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();