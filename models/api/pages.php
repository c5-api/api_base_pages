<?php defined('C5_EXECUTE') or die('Access Denied');

class ApiPagesRouteModel extends Object {
	public static function populateList() {
		$a = array();
		$a['page'][t('Collection ID')] = 'cID';
		$a['page'][t('Package ID')] = 'pkgID';
		//$a['page'][] = 'cPointerID';
		//$a['page'][] = 'cPointerExternalLink';
		$a['page'][t('Active')] = 'cIsActive';
		$a['page'][t('System Page')] = 'cIsSystemPage';
		//$a['page'][] = 'cPointerExternalLinkNewWindow';
		$a['page'][t('Singlepage Filename')] = 'cFilename';
		$a['page'][t('Date Added')] = 'cDateAdded';
		$a['page'][t('Display Order')] = 'cDisplayOrder';
		$a['page'][t('Date Modified')] = 'cDateModified';
		$a['page'][t('Creator User ID')] = 'uID';
		$a['page'][t('Path')] = 'cPath';
		$a['page'][t('Parent ID')] = 'cParentID';
		$a['page'][t('Number of Children')] = 'cChildren';

		$a['version'][t('Is Approved')] = 'cvIsApproved';
		$a['version'][t('Collection Version ID')] = 'cvID';
		//$a['version'][] = 'cvIsNew';
		$a['version'][t('Handle')] = 'cvHandle';
		$a['version'][t('Name')] = 'cvName';
		$a['version'][t('Description')] = 'cvDescription';
		$a['version'][t('Author User ID')] = 'cvAuthorUID';
		$a['version'][t('Approver User ID')] = 'cvApproverUID';
		$a['version'][t('Comments')] = 'cvComments';
		$a['version'][t('Page Theme ID')] = 'ptID';
		$a['version'][t('Collection Type ID')] = 'ctID';
		$a['version'][t('Collection Type Handle')] = 'ctHandle';
		$a['version'][t('Collection Type Name')] = 'ctName';
		$a['version'][t('Is Most Recent Version')] = 'cvIsMostRecent';

		$a['attributes'] = self::populateAttributes();

	}

	public static function populateAttributes() {
		$attributes = CollectionAttributeKey::getList();
		$a = array();
		foreach($attributes as $attr) {
			$a[$attr->getAttributeKeyName()] = '_attribute_'.$attr->getAttributeKeyHandle();
		}
		return $a;
	}

	public static function getSelected() {
		$pkg = Package::getByHandle('api_base_pages');
		$conf = $pkg->config('SELECTED');
		return unserialize($conf);
	}

	public static function saveSelected($conf) {
		$ser = serialize($conf);
		$pkg = Package::getByHandle('api_base_pages');
		$pkg->saveConfig('SELECTED', $ser);
	}

	public static function saveType($type = 'whitelist') {
		$pkg = Package::getByHandle('api_base_pages');
		$pkg->saveConfig('TYPE', $type);
	}

	public static function getType() {
		$pkg = Package::getByHandle('api_base_pages');
		$conf = $pkg->config('TYPE');
		return $conf;
	}
}