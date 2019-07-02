<?php
namespace App\Http\Controllers\Account;
use App\Http\Requests\SkillsRequest;
use App\Models\Skills;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SkillsController extends AccountBaseController
{
	private $perPage = 10;
	public $pagePath = 'skills';
	public function __construct()
	{
		parent::__construct();
		
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
		
		view()->share('pagePath', $this->pagePath);
	}

    /**
	 * Display a listing of the resource.
	 *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
     
    public function index()
    {
    	// Get all User's Companies
	    //	$skills = $this->skills->paginate($this->perPage);
        // Meta Tags
       $skills =  Skills::where('user_id', auth()->user()->id)->paginate($this->perPage);
       
        MetaTag::set('title', t('My Skills List'));
        MetaTag::set('description', t('My Skills - :app_name', ['app_name' => config('settings.app.app_name')]));
        return view('account.skills.index')->with('skills',$skills);
    }
	
	/**
	 * Show the form for creating a new resource.
	 */
	 
	public function create()
	{
		// Meta Tags
		MetaTag::set('title', t('Create a new skills'));
		MetaTag::set('description', t('Create a new skills - :app_name', ['app_name' => config('settings.app.app_name')]));
		$skills = array();
	    $skills['proficiency'] = array('Beginner','Medium','Expert');
		return view('account.skills.create',$skills);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CompanyRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function store(SkillsRequest $request)
	{
	    
		// Get skills Info
		$skillsInfo['proficiency'] = $request->input('proficiency');
		$skillsInfo['skill'] = $request->input('skill');
		
		if (!isset($skillsInfo['user_id']) || empty($skillsInfo['user_id'])) 
		{
			$skillsInfo += ['user_id' => auth()->user()->id];
		}
		
	
		$skills = new Skills($skillsInfo);
		$skills->save();
		
		flash(t("Your skills has created successfully."))->success();
		
		
		// Redirection
		return redirect(config('app.locale') . '/account/skills');
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function show($id)
	{
		return redirect(config('app.locale') . '/account/skills/' . $id . '/edit');
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		// Get the Company
		$skills = array();
		$skills = skills::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
		
		// Meta Tags
		MetaTag::set('title', t('Edit the Skills'));
		MetaTag::set('description', t('Edit the Skills - :app_name', ['app_name' => config('settings.app.app_name')]));
	    $proficiency = array('Beginner','Medium','Expert');
	   
		return view('account.skills.edit')->with(['skills'=> $skills,'proficiency'=>$proficiency]);
	}
	

	public function update($id,SkillsRequest $request)
	{
		$skills = Skills::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
		
		// Get Company Info
	$skillsInfo['proficiency'] = $request->input('proficiency');
		$skillsInfo['skills'] = $request->input('skills');
		if (!isset($skillsInfo['user_id']) || empty($skillsInfo['user_id'])) {
			$skillsInfo += ['user_id' => auth()->user()->id];
		}
		
		// Make an Update
		$skills->update($skillsInfo);
		flash(t("Your skills details has updated successfully."))->success();
		// Redirection
		return redirect(config('app.locale') . '/account/skills');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param null $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy($id = null)
	{
		// Get Entries ID
		$ids = [];
		if (request()->filled('entries')) {
			$ids = request()->input('entries');
		} else {
			if (!is_numeric($id) && $id <= 0) {
				$ids = [];
			} else {
				$ids[] = $id;
			}
		}
		
		// Delete
		$nb = 0;
		foreach ($ids as $item) {
			$skills = Skills::where('id', $item)->where('user_id', auth()->user()->id)->firstOrFail();
			if (!empty($skills)) {
				// Delete Entry
				$nb = $skills->delete();
			}
		}
		
		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done. Please try again."))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully.", ['entities' => t('skills'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully.", ['entity' => t('skills')]))->success();
			}
		}
		
		return redirect(config('app.locale') . '/account/skills');
	}
}
