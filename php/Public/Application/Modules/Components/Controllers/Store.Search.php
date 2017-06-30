<?php
Core::requireDataClass('Games');
class SearchController extends Control
{
	public function __construct($params = null)
	{
		parent::loadParamMap(array( 'query' => true, 'json' => false, 'offset' => true), $params);
		if(strlen(parent::getParam('query')) >= 1 && parent::getParam('json')) {

			header('Content-type: application/json');
			
			printf(GamesData::searchForGames(parent::getParam('query'), intval(parent::getParam('offset'))));
		}
		else {
			$this->Tpl = new Template('Search');
			//$this->Tpl->SetLabel('PageTitle', '/ Home');
			$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.Guest');
			$this->Tpl->SetLabel('PageTitle', 'Buscar -');
			//$this->Tpl->SetLabelWithPart('TopBar', 'TopBar.User');
			$this->Tpl->WriteOutput();
		}
		exit;
	}
}
