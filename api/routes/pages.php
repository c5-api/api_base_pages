<?php defined('C5_EXECUTE') or die('Access Denied');

class PagesApiRouteController extends ApiRouteController {

	public function run($ID = false) {
		switch (API_REQUEST_METHOD) {
			case 'GET':
				if($ID && $ID > 0) {

				} else {
					return $this->getList();
				}
			
			default: //BAD REQUEST
				$this->setCode(400);
				$this->respond(array('error' => 'Bad Request'));
		}
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
			$vobj = $this->filterObject($page->vObj, array('cvHandle', 'cvName', 'cvDateCreated', 'cvDatePublic', 'cvAuthorUID', 'cvDescription'));
			$pobj = $this->filterObject($page, array('cID', 'pkgID', 'cPath', 'cParentID'));
			$nlist[] = $this->object_merge($vobj, $pobj);
		}
		//print_r($nlist);
		return $nlist;

	}

}