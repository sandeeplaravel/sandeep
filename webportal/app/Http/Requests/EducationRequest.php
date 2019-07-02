<?php
namespace App\Http\Requests;

use App\Rules\BetweenRule;
use App\Rules\BlacklistDomainRule;
use App\Rules\BlacklistEmailRule;
use App\Rules\BlacklistTitleRule;
use App\Rules\BlacklistWordRule;
use App\Rules\UsernameIsAllowedRule;
use App\Rules\UsernameIsValidRule;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Config\Repository;

class EducationRequest extends Request
{

	public function rules()
	{
		$rules = [
			'university'    => ['required', new BetweenRule(2, 200)],
			'degree'        => ['required'],
			'qualification' => ['required'],
			'passing_year'  => ['required'],
			
		];
		
		 return $rules;
	}
	
	
	public function messages()
	{
		$messages = [];
		return $messages;
	}
	
}
