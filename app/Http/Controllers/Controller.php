<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Exception;
use Illuminate\Support\Facades\Request as RequestFacade;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/*
	 * Returns simple page with single box
	 */
	protected function simpleBox($title, $body, $style = 'primary') 
	{
		$data['box_title'] = $title;
		$data['box_body'] = $body;
		$data['box_style'] = $style;
		return view('pages.box.simple_data_box', $data);
	}
	
	/*
	 * Returns simple json
	 */
	protected function simpleJson($success, $message = '') 
	{
		$data = [];
		$data['status'] = $success ? 'success' : 'fail';
		
		if(!$success && $message == '') {
			throw new Exception("Please provide message");
		}

		if($message != '') {
			$data['message'] = $message;
		}
		return $data;
	}

	/*
	 * Returns simple response - page or json
	 */
	protected function simpleAnswer($success, $title, $message = '') 
	{
		if(RequestFacade::ajax()){
			return $this->simpleJson($success, $message ?: $title);
		} else {
			return $this->simpleBox($title, $message, $success ? 'primary' : 'danger');
		}
	}
	
	protected function simpleSuccessAnswer($title, $message = '') 
	{
		return $this->simpleAnswer(true, $title, $message);
	}

}
