<?php defined('C5_EXECUTE') or die('Access Denied');

class DashboardApiSettingsPagesController extends DashboardBaseController {
	
	public function view($updated = false) {
		if($updated) {
			switch ($updated) {
				case 'saved':
					$this->set('success', t('Settings Saved'));
					break;

				case 'invalid_token':
					$this->set('error', Loader::helper('validation/token')->getErrorMessage());
					break;
			}
		}

	}


}