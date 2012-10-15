<?php defined('C5_EXECUTE') or die('Access Denied');

class ApiPagesRouteModel extends Object {
	public static function populateList() {
		$a = array();
		$a['page']['cID'] = t('Collection ID');
		$a['page']['pkgID'] = t('Package ID');
		//$a['page']['cPointerID'] = 'cPointerID';
		//$a['page']['cPointerExternalLink'] = 'cPointerExternalLink';
		$a['page']['cIsActive'] = t('Active');
		$a['page']['cIsSystemPage'] = t('System Page');
		//$a['page']['cPointerExternalLinkNewWindow'] = 'cPointerExternalLinkNewWindow';
		$a['page']['cFilename'] = t('Singlepage Filename');
		$a['page']['cDateAdded'] = t('Date Added');
		$a['page']['cDisplayOrder'] = t('Display Order');
		$a['page']['cDateModified'] = t('Date Modified');
		$a['page']['uID'] = t('Creator User ID');
		$a['page']['cPath'] = t('Path');
		$a['page']['cParentID'] = t('Parent ID');
		$a['page']['cChildren'] = t('Number of Children');

		$a['version']['cvIsApproved'] = t('Is Approved');
		$a['version']['cvID'] = t('Collection Version ID');
		//$a['version']['cvIsNew'] = 'cvIsNew';
		$a['version']['cvHandle'] = t('Handle');
		$a['version']['cvName'] = t('Name');
		$a['version']['cvDescription'] = t('Description');
		$a['version']['cvAuthorUID'] = t('Author User ID');
		$a['version']['cvApproverUID'] = t('Approver User ID');
		$a['version']['cvComments'] = t('Comments');
		$a['version']['ptID'] = t('Page Theme ID');
		$a['version']['ctID'] = t('Collection Type ID');
		$a['version']['ctHandle'] = t('Collection Type Handle');
		$a['version']['ctName'] = t('Collection Type Name');
		$a['version']['cvIsMostRecent'] = t('Is Most Recent Version');

		$a['attributes'] = self::populateAttributes();
		return $a;
	}

	public static function populateAttributes() {
		$attributes = CollectionAttributeKey::getList();
		$a = array();
		foreach($attributes as $attr) {
			$a[$attr->getAttributeKeyHandle()] = $attr->getAttributeKeyName();
		}
		return $a;
	}

	public static function getSelected() {
		$pkg = Package::getByHandle('api_base_pages');
		$conf = $pkg->config('SELECTED');
		return unserialize($conf);
	}

	public static function saveSelected($conf) {
		if(!isset($conf['page'])) {
			$conf['page'] = array();
		}
		if(!isset($conf['version'])) {
			$conf['version'] = array();
		}
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