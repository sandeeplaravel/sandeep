<?php
namespace App\Http\Controllers\Account;
use App\Http\Requests\EducationRequest;
use App\Models\Education;
use App\Models\Degree;
use App\Models\Qualification;
use Torann\LaravelMetaTags\Facades\MetaTag;
class EducationController extends AccountBaseController
{
	private $perPage = 10;
	public $pagePath = 'education';
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
	    //	$education = $this->education->paginate($this->perPage);
        // Meta Tags
       $education =  Education::join('degrees', 'education.degree', '=', 'degrees.id')->join('qualification','qualification.id','=','education.qualification')->select('education.*','degrees.name as degree','qualification.name as qualification')->where('user_id',auth()->user()->id)->paginate($this->perPage);
        MetaTag::set('title', t('My Education List'));
        MetaTag::set('description', t('My Education ist - :app_name', ['app_name' => config('settings.app.app_name')]));
        return view('account.education.index')->with('education',$education);
    }
	
	/**
	 * Show the form for creating a new resource.
	 */
	 
	public function create()
	{
		// Meta Tags
		MetaTag::set('title', t('Create a new education'));
		MetaTag::set('description', t('Create a new education - :app_name', ['app_name' => config('settings.app.app_name')]));
		$education = array();
	    $education['degree'] = Degree::all();
		$education['qualification'] = Qualification::all();
		return view('account.education.create',$education);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CompanyRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function store(EducationRequest $request)
	{
	    
		// Get education Info
		$educationInfo['passing_year'] = $request->input('passing_year');
		$educationInfo['degree'] = $request->input('degree');
		$educationInfo['qualification'] = $request->input('qualification');
		$educationInfo['university'] = $request->input('university');
		
		if (!isset($educationInfo['user_id']) || empty($educationInfo['user_id'])) 
		{
			$educationInfo += ['user_id' => auth()->user()->id];
		}
		
	
		$education = new Education($educationInfo);
		$education->save();
		
		flash(t("Your education has created successfully."))->success();
		
		// Save the Company's Logo
	
		
		// Redirection
		return redirect(config('app.locale') . '/account/education');
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function show($id)
	{
		return redirect(config('app.locale') . '/account/education/' . $id . '/edit');
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
		$education = array();
		$education = education::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
		
		// Meta Tags
		MetaTag::set('title', t('Edit the Education'));
		MetaTag::set('description', t('Edit the Education - :app_name', ['app_name' => config('settings.app.app_name')]));
	
	    $degree = Degree::all();
		$qualification = Qualification::all();
		return view('account.education.edit')->with(['education'=> $education,'degree'=>$degree,'qualification'=>$qualification]);
	}
	

	public function update($id,EducationRequest $request)
	{
		$education = Education::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
		
		// Get Company Info
	$educationInfo['passing_year'] = $request->input('passing_year');
		$educationInfo['degree'] = $request->input('degree');
		$educationInfo['qualification'] = $request->input('qualification');
		$educationInfo['university'] = $request->input('university');
		if (!isset($educationInfo['user_id']) || empty($educationInfo['user_id'])) {
			$educationInfo += ['user_id' => auth()->user()->id];
		}
		
		// Make an Update
		$education->update($educationInfo);
		
		flash(t("Your education details has updated successfully."))->success();
		
		
		
		// Redirection
		return redirect(config('app.locale') . '/account/education');
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
			$education = Education::where('id', $item)->where('user_id', auth()->user()->id)->firstOrFail();
			if (!empty($education)) {
				// Delete Entry
				$nb = $education->delete();
			}
		}
		
		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done. Please try again."))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully.", ['entities' => t('education'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully.", ['entity' => t('education')]))->success();
			}
		}
		
		return redirect(config('app.locale') . '/account/education');
	}
}
