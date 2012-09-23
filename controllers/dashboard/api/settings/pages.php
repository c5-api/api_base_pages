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

		$list = ApiPagesRouteModel::populateList();
		$selected = ApiPagesRouteModel::getSelected();

		$this->set('types', array_keys($list));
		$this->set('list', $list);
		$this->set('selected', $selected);

	}

	public function save() {
		ApiPagesRouteModel::saveSelected($this->post());
		$this->redirect('/dashboard/api/settings/pages', 'saved');
	}

}