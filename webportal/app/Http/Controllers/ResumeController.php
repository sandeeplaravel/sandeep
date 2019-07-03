<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResumeController extends Controller
{

	/**
	* ResumeController Constuctor 
	**/
	public function __construct()
	{
		
	}

    public function resumeSearch(){
  //   	$data = [];
		
		// $data['countries'] = array();
		// $data['genders'] = array();
		// $data['userTypes'] = array();
		// $data['userPhoto'] = array();
		
		// // Mini Stats
		// $data['countPostsVisits'] = array();
		// $data['countPosts'] = array();
		// $data['countFavoritePosts'] = array();

    	return view('resume-search.index');
    }
}
