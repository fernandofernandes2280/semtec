<?php

namespace App\Controller\Tutorial;

use \App\Utils\View;

class Ajax extends Page {
	
	public static function create($request):void
	{
		//$callback["data"]=$data;
		$postVars = $request->getPostVars();
		
		$id2 = ($postVars["name"]);
		//echo json_encode($id);
		echo ($id2);
	}
	
	
}