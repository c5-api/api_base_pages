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

		$classes = array();
		$classes['ApiPagesRouteModel'] = array('model', 'api/route/pages', 'api_base_pages');

		Loader::registerAutoload($classes);
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

		$sel = array();
		$sel['page'][] = 'cID';
		$sel['page'][] = 'pkgID';
		$sel['page'][] = 'cPath';
		$sel['page'][] = 'cParentID';

		$sel['version'][] = 'cvHandle';
		$sel['version'][] = 'cvName';
		$sel['version'][] = 'cvDateCreated';
		$sel['version'][] = 'cvDatePublic';
		$sel['version'][] = 'cvAuthorID';
		$sel['version'][] = 'cvDescription';

		$sel['attributes'][] = 'meta_title';
		$sel['attributes'][] = 'meta_description';
		$sel['attributes'][] = 'meta_keywords';
		$sel['attributes'][] = 'tags';
		$sel['attributes'][] = 'exclude_nav';
		$sel['attributes'][] = 'exclude_search_index';
		$sel['attributes'][] = 'exclude_sitemapxml';
		$sel['attributes'][] = 'exclude_page_list';

		ApiPagesRouteModel::saveSelected($sel);

		ApiPagesRouteModel::saveType();//whitelist


		ApiRoute::add('pages', t('List pages and get information about different pages'), $pkg);
	}
	
	public function uninstall() {
		ApiRouteList::removeByPackage($this->pkgHandle);//remove all the apis
		parent::uninstall();
	}

}