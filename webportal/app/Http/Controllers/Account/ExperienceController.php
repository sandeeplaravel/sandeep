<?php
namespace App\Http\Controllers\Account;
use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use App\Models\Degree;
use App\Models\Qualification;
use Torann\LaravelMetaTags\Facades\MetaTag;
class ExperienceController extends AccountBaseController
{
	private $perPage = 10;
	public $pagePath = 'experience';
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
    	// Get all User's Experience
	    //	$experience = $this->experience->paginate($this->perPage);
        // Meta Tags
       $experience =  Experience::where('user_id',auth()->user()->id)->paginate($this->perPage);
        MetaTag::set('title', t('My Experience List'));
        MetaTag::set('description', t('My Experience ist - :app_name', ['app_name' => config('settings.app.app_name')]));
        return view('account.experience.index')->with('experience',$experience);
    }
	
	/**
	 * Show the form for creating a new resource.
	 */
	 
	public function create()
	{
		// Meta Tags
		MetaTag::set('title', t('Create a new company'));
		MetaTag::set('description', t('Create a new company - :app_name', ['app_name' => config('settings.app.app_name')]));
		$experience = array();
	    $experience['degree'] = Degree::all();
		$experience['qualification'] = Qualification::all();
		return view('account.experience.create',$experience);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CompanyRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function store(ExperienceRequest $request)
	{
		// Get experience Info
		$experienceInfo['designation'] = $request->input('designation');
		$experienceInfo['employer'] = $request->input('employer');
		$experienceInfo['start'] = $request->input('start');
		$experienceInfo['end'] = $request->input('end');
		$experienceInfo['is_current'] = $request->input('is_current');
		if (!isset($experienceInfo['user_id']) || empty($experienceInfo['user_id'])) 
		{
			$experienceInfo += ['user_id' => auth()->user()->id];
		}
	
		$experience = new Experience($experienceInfo);
		$experience->save();
		
		flash(t("Your experience has created successfully."))->success();
		
		// Save the Company's Logo
	
		
		// Redirection
		return redirect(config('app.locale') . '/account/experience');
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function show($id)
	{
		return redirect(config('app.locale') . '/account/experience/' . $id . '/edit');
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
		$experience = array();
		$experience = experience::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
		
		// Meta Tags
		MetaTag::set('title', t('Edit the Experience'));
		MetaTag::set('description', t('Edit the Experience - :app_name', ['app_name' => config('settings.app.app_name')]));
	
	    $degree = Degree::all();
		$qualification = Qualification::all();
		return view('account.experience.edit')->with(['experience'=> $experience,'degree'=>$degree,'qualification'=>$qualification]);
	}
	

	public function update($id,ExperienceRequest $request)
	{
		$experience = Experience::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
		
		// Get Company Info
	$experienceInfo['designation'] = $request->input('designation');
		$experienceInfo['employer'] = $request->input('employer');
		$experienceInfo['start'] = $request->input('start');
		$experienceInfo['end'] = $request->input('end');
		$experienceInfo['is_current'] = $request->input('is_current');
		if (!isset($experienceInfo['user_id']) || empty($experienceInfo['user_id'])) {
			$experienceInfo += ['user_id' => auth()->user()->id];
		}
		
		// Make an Update
		$experience->update($experienceInfo);
		
		flash(t("Your experience details has updated successfully."))->success();
		
		
		
		// Redirection
		return redirect(config('app.locale') . '/account/experience');
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
			$experience = Experience::where('id', $item)->where('user_id', auth()->user()->id)->firstOrFail();
			if (!empty($experience)) {
				// Delete Entry
				$nb = $experience->delete();
			}
		}
		
		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done. Please try again."))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully.", ['entities' => t('experience'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully.", ['entity' => t('experience')]))->success();
			}
		}
		
		return redirect(config('app.locale') . '/account/experience');
	}
}
