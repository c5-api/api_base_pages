<?php defined('C5_EXECUTE') or die('Access Denied');

class PagesApiRouteController extends ApiRouteController {

	public function run($ID = false) {
		$int = Loader::helper('validation/numbers');
		switch (API_REQUEST_METHOD) {
			case 'GET':
				if($ID && $ID != 0) {
					if($int->integer($ID)) {
						return $this->getPage($ID);
					} else {
						$this->setCode(400);
						$this->respond(array('error' => 'Bad Request'));
					}
				} else {
					return $this->getList();
				}
			
			default: //BAD REQUEST
				$this->setCode(405);
				$this->respond(array('error' => 'Method Not Allowed'));
		}
	}

	private function getPage($ID) {
		$view = PermissionKey::getByHandle('view_page'); //Get the fancy new "view_page" permission
		$page = Page::getByID($ID); //get the super complicated page object
		if(!is_object($page) || $page->isError() || $page->isSystemPage()) { //lets check if this page exists...
			$this->setCode(404); //NOPE time to 404!
			$this->respond(array('error' => 'Page Not Found'));
		}

		$view->setPermissionObject($page);
		$pa = $view->getPermissionAccessObject();
		if(!is_object($pa)) { //IDK WTF this does, so lets just 404 because i don't know what it is!
			$this->setCode(404);
			$this->respond(array('error' => 'Page Not Found'));
		}

		$guest = Group::getByID(GUEST_GROUP_ID);
		$accessEntities = array(GroupPermissionAccessEntity::getOrCreate($guest));
		if (!$pa->validateAccessEntities($accessEntities)) { //STOP TRYING TO HACK US DAMMIT YOU ARN'T ALLOWED TO SEE THIS
			$this->setCode(404);
			$this->respond(array('error' => 'Page Not Found'));
		}
		return $this->cleanPage($page);

	}

	private function getList() {

		$maxlimit = C5_API_PAGES_LIMIT;
		$limit = C5_API_PAGES_LIMIT_DEFAULT;
		$offset = 0;
		$sort = false;
		$parent = false;

		if(isset($_GET['limit']) && $_GET['limit'] > 0 && $_GET['limit'] <= $maxlimit) {
			$limit = $_GET['limit'];
		}
		if(isset($_GET['offset']) && $_GET['offset'] > 0) {
			$offset = $_GET['offset'];
		}
		if(isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		}
		if(isset($_GET['parent'])) {
			$parent = $_GET['parent'];
		}
		

		$pl = new PageList();

		if($parent !== false) { //0 evaluates to false so we do strict checking
			$pl->filterByParentID($parent);
		}

		switch (strtolower($sort)) {
			case 'relevance':
				$pl->sortByRelevance();
				break;
			case 'display_order_asc':
			case 'display_order':
				$pl->sortByDisplayOrder();
				break;
			case 'display_order_desc':
				$pl->sortByDisplayOrderDescending();
				break;
			case 'collection_id':
			case 'collection_id_asc':
				$pl->sortByCollectionIDAscending();
				break;
			case 'public_date':
			case 'public_date_asc':
				$pl->sortByPublicDate();
				break;
			case 'public_date_desc':
				$pl->sortByPublicDateDescending();
				break;
			case 'name':
			case 'name_asc':
				$pl->sortByName();
				break;
			case 'name_desc':
				$pl->sortByNameDescending();
				break;
		}
		
		$list = $pl->get($limit, $offset);
		//$list = $pl->get(2, $offset);
		$nlist = array();
		foreach($list as $page) {
			$nlist[] = $this->cleanPage($page);
		}
		//print_r($nlist);
		return $nlist;

	}

	private function cleanPage($page) {
		$active = ApiPagesRouteModel::getSelected();

		$attributes = CollectionAttributeKey::getList();
		$natt = array();
		foreach($attributes as $att) {
			if(in_array($att->getAttributeKeyHandle(), $active['attributes'])) {
				$val = $page->getAttribute($att->getAttributeKeyHandle());
				$natt[$att->getAttributeKeyHandle()] = (string) $val;
			}
		}
		$vobj = $this->filterObject($page->vObj, $active['version']);
		$pobj = $this->filterObject($page, $active['page']);
		$attr = array('attributes' => $natt);

		return $this->object_merge($vobj, $pobj, $attr);
	}

}