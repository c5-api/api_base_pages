<?php defined('C5_EXECUTE') or die('Access Denied.');
	echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper('/pages', t('Manage settings for the /pages route'));
	$ih = Loader::helper('concrete/interface');
	$valt = Loader::helper('validation/token');?>
		<div class="clearfix">
			
		</div>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();