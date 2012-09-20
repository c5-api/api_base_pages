<?php defined('C5_EXECUTE') or die("Access Denied.");

class ApiBasePagesPackage extends Package {

	protected $pkgHandle = 'api_base_pages';
	protected $appVersionRequired = '5.6.0';
	protected $pkgVersion = '0.9';

	public function getPackageName() {
		return t("Api:Base:Pages");
	}

	public function getPackageDescription() {
		return t("Get information about specific pages");
	}

	public function on_start() {
		Config::getAndDefine('C5_API_PAGES_LIMIT', 50);
		Config::getAndDefine('C5_API_PAGES_LIMIT_DEFAULT', 10);
	}

	public function install() {
		$installed = Package::getByHandle('api');
		if(!is_object($installed)) {
			throw new Exception(t('Please install the "API" package before installing %s', $this->getPackageName()));
		}

		parent::install();

		$pkg = Package::getByHandle($this->pkgHandle);
		$p = SinglePage::add('/dashboard/api/settings/pages',$pkg);
		$p->update(array('cName'=> '/pages'));
		ApiRoute::add('pages', t('List pages and get information about different pages'), $pkg);
	}
	
	public function uninstall() {
		ApiRouteList::removeByPackage($this->pkgHandle);//remove all the apis
		parent::uninstall();
	}

}