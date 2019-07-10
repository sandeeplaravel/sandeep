<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;
use App\Models\Experience;
use App\Models\Skills;
use App\Models\City;
use App\Models\Resume;
use App\Models\Post;
use DateTime;
use DB;
use Auth;

class ResumeController extends Controller
{

	/**
	* ResumeController Constuctor 
	**/
	public function __construct()
	{
		
	}

	/**
	* Return resume search form...  
	**/
    public function resumeSearch(){
    	$data['degree'] = Degree::all();
    	return view('resume-search.index', $data);
    }

    /**
	* Return resume search result...  
	**/
    public function resumeSearchResult(Request $request){

    	$search_by_keyword = $request->search_by_keyword;
    	$min_exp = $request->total_experience_min;
		$max_exp = $request->total_experience_max;
    	$location = $request->prefered_location;
		$min_ctc = $request->current_ctc_min;
		$max_ctc = $request->current_ctc_max;
		$skill = $request->skill;
		$education = $request->education;

		$resume = array();
		$resume1 = array();

/**For search by keyword**/
		if ($search_by_keyword) {

			$resumes1 = DB::table('users')
				->distinct()
	            ->join('skills', 'users.id', '=', 'skills.user_id')
	            ->join('education', 'users.id', '=', 'education.user_id')
	            // ->join('experience', 'users.id', '=', 'experience.user_id')
	            ->select('users.*', 'skills.skill')
	            ->where('users.user_type_id', '=', 2)
	            ->groupBy('users.id');

	            if($search_by_keyword){
	            	$resumes1 = $resumes1->where(function($query1) use ($search_by_keyword)  {
		                $query1->where('skills.skill','=', $search_by_keyword);
		                $degrees = Degree::all();
		                foreach ($degrees as $key => $value) {
		                	if(strtolower($value->name) == strtolower($search_by_keyword)){
		                		$query1->orWhere('education.degree','=', $value->id);
		                		break;
		                	}
		                }
		         	});
	            }
	            $resume1 = $resumes1->get();

	            foreach ($resume1 as $key1 => $value1) {
	            	
	            	//get candidate skills
	            	$candidate_skills1 = Skills::where('user_id', $value1->id)->get();
	            	$cand_skills1 = array();
	            	foreach ($candidate_skills1 as $candidate_skill1) {
	            		$cand_skills1[] = $candidate_skill1->skill;
	            	}

	            	$value1->skill = implode(', ', $cand_skills1);
	            	//get candidate skills

	            	//get candidate resume
	            	$resume_path1 = DB::table('resumes')->where('user_id', $value1->id)->orderBy('created_at', 'desc')->limit(1)->select('resumes.filename')->get();

					if(isset($resume_path1[0]->filename)){
						$value1->resume = $resume_path1[0]->filename;
					}else{
						$value1->resume = '';
					}
					//get candidate resume
	            }

	        }//end if

/**For search by keyword**/

		$resumes = DB::table('users')
			->distinct()
            ->join('skills', 'users.id', '=', 'skills.user_id')
            ->join('education', 'users.id', '=', 'education.user_id')
            // ->join('experience', 'users.id', '=', 'experience.user_id')
            ->select('users.*', 'skills.skill')
            ->where('users.user_type_id', '=', 2)
            ->groupBy('users.id');

             

            if($min_ctc > 0 && $max_ctc > 0){
            	$resumes = $resumes->where(function($query) use ($min_ctc, $max_ctc)  {
	                $query->whereBetween('users.current_ctc', array($min_ctc, $max_ctc));
	         	});
            }else if($min_ctc){
            	$resumes = $resumes->where(function($query) use ($min_ctc)  {
	                $query->where('users.current_ctc','>=', $min_ctc);
	         	});
            }else if($max_ctc){
				$resumes = $resumes->where(function($query) use ($max_ctc)  {
	                $query->where('users.current_ctc','<=', $max_ctc);
	         	});
            }

            if($education){
            	$resumes = $resumes->where(function($query) use ($education)  {
	                $query->where('education.degree','=', $education);
	         	});
            }

            if($skill){
            	$resumes = $resumes->where(function($query) use ($skill)  {
	                $query->where('skills.skill','=', $skill);
	         	});
            }


            if($location){
            	$resumes = $resumes->where(function($query) use ($location)  {
	                $query->where('users.prefered_location','=', $location);
	         	});
            }
           
            $exp_sum = array();
            $resume = $resumes->get();
            foreach ($resume as $key => $value) {
            	
            	//get candidate skills
            	$candidate_skills = Skills::where('user_id', $value->id)->get();
            	$cand_skills = array();
            	foreach ($candidate_skills as $candidate_skill) {
            		$cand_skills[] = $candidate_skill->skill;
            	}

            	$value->skill = implode(', ', $cand_skills);
            	//get candidate skills

            	//get candidate resume
            	$resume_path = DB::table('resumes')->where('user_id', $value->id)->orderBy('created_at', 'desc')->limit(1)->select('resumes.filename')->get();

				if(isset($resume_path[0]->filename)){
					$value->resume = $resume_path[0]->filename;
				}else{
					$value->resume = '';
				}
				//get candidate resume
            	
				//get candidate experience
            	$exp = Experience::where('user_id', $value->id)->get();

            	$exp_count = count($exp);
            	$year = 0;
            	$days = 0;
            	$i=1;
            	foreach ($exp as $e) {
            		$fdate = $e->start;
					$tdate = $e->end;
					$datetime1 = new DateTime($fdate);
					$datetime2 = new DateTime($tdate);
					$interval = $datetime1->diff($datetime2);
					$day = $interval->format('%a');
					$days += $day;
					
					if($exp_count == $i){

						$year = (int)($days / 365);

						if($min_exp && $max_exp){
							if(($year >= $min_exp) && ($year <= $max_exp)){

							}else{
								unset($resume[$key]);
							}
						}elseif ($min_exp) {
							if($year != $min_exp){
								unset($resume[$key]);	
							}
						}elseif ($max_exp) {
							if($year != $max_exp){
								unset($resume[$key]);	
							}
						}

					}
					
					$i++;
            	}
            }

        $sidebar_degrees = Degree::all();
        $sidebar_skills = Skills::groupBy('skill')->get();
        $sidebar_cities = City::all();

        if( (count($resume) > 0 ) && ( count($resume1) > 0 ) ){
        	$merged = $resume->merge($resume1);
			$uniqueItems = $merged->unique();
			$sorted = $uniqueItems->sortByDesc('last_login_at');
	        $resume_arr['users'] = $sorted;
        }elseif (count($resume) > 0) {
			$uniqueItems = $resume->unique();
			$sorted = $uniqueItems->sortByDesc('last_login_at');
	        $resume_arr['users'] = $sorted;
        }elseif (count($resume1) > 0) {
        	$uniqueItems = $resume1->unique();
			$sorted = $uniqueItems->sortByDesc('last_login_at');
	        $resume_arr['users'] = $sorted;
        }else{
        	$resume_arr['users'] = array();
        }

        $resume_arr['sidebar_degrees'] = $sidebar_degrees;
        $resume_arr['sidebar_skills'] = $sidebar_skills;
        $resume_arr['sidebar_cities'] = $sidebar_cities;
		
    	return view('resume-search.search', $resume_arr);
    }

    /**
    *
    * Use in view to count candidate experience...
    *
    **/
    public static function countExp($user_id){
    	$exp = Experience::where('user_id', $user_id)->get();

    	$exp_count = count($exp);
    	$year = 0;
    	$days = 0;
    	$i=1;
    	foreach ($exp as $e) {
    		$fdate = $e->start;
			$tdate = $e->end;
			$datetime1 = new DateTime($fdate);
			$datetime2 = new DateTime($tdate);
			$interval = $datetime1->diff($datetime2);
			$day = $interval->format('%a');
			$days += $day;
			
			if($exp_count == $i){
				$year = (int)($days / 365);
			}
			
			$i++;
    	}

    	return $year;
    }

    /**
    *
    * To get Employer job...
    *
    **/
    public static function getJobs($user_id){
    	$posts = Post::where('user_id', $user_id)->get();
    	return $posts;
    }

    /**
	* Return resume search result...  
	**/
    public function resumeSearchFilter(Request $request){

    	

    	$experience = $request->experience;
    	$location = $request->location;
		$skill = $request->skill;
		$education = $request->education;

		$resume = array();

		$resumes = DB::table('users')
			->distinct()
            ->join('skills', 'users.id', '=', 'skills.user_id')
            ->join('education', 'users.id', '=', 'education.user_id')
            ->select('users.*', 'skills.skill')
            ->where('users.user_type_id', '=', 2)
            ->groupBy('users.id');

             

            
            if(is_array($education) && count($education) > 0){
            	$resumes = $resumes->where(function($query) use ($education)  {
            		foreach ($education as $edu) {
            			$query->orWhere('education.degree','=', $edu);
            		}
	         	});
            }

            if(is_array($skill ) &&  count($skill) > 0){
            	$resumes = $resumes->where(function($query) use ($skill)  {
            		foreach ($skill as $sk) {
            			$query->orWhere('skills.skill','=', $sk);
            		}
	         	});
            }

            if(is_array($location) &&  count($location) > 0){
            	$resumes = $resumes->where(function($query) use ($location)  {
            		foreach ($location as $loc) {
            			$query->orWhere('users.prefered_location','=', $loc);
            		}
	         	});
            }

            $exp_sum = array();
            $resume = $resumes->get();
            foreach ($resume as $key => $value) {
            	
            	//get candidate skills
            	$candidate_skills = Skills::where('user_id', $value->id)->get();
            	$cand_skills = array();
            	foreach ($candidate_skills as $candidate_skill) {
            		$cand_skills[] = $candidate_skill->skill;
            	}

            	$value->skill = implode(', ', $cand_skills);
            	//get candidate skills

            	//get candidate resume
            	$resume_path = DB::table('resumes')->where('user_id', $value->id)->orderBy('created_at', 'desc')->limit(1)->select('resumes.filename')->get();

				if(isset($resume_path[0]->filename)){
					$value->resume = $resume_path[0]->filename;
				}else{
					$value->resume = '';
				}
				//get candidate resume
            	
	            	if(is_array($experience)){
					//get candidate experience
		            	$exp = Experience::where('user_id', $value->id)->get();

		            	$exp_count = count($exp);
		            	$year = 0;
		            	$days = 0;
		            	$i=1;
		            	foreach ($exp as $e) {
		            		$fdate = $e->start;
							$tdate = $e->end;
							$datetime1 = new DateTime($fdate);
							$datetime2 = new DateTime($tdate);
							$interval = $datetime1->diff($datetime2);
							$day = $interval->format('%a');
							$days += $day;
							
							if($exp_count == $i){
								$year = (int)($days / 365);
								if (!in_array($year, $experience)) {
									unset($resume[$key]);
								}
							}
							$i++;
		            	}
	            }
            }

        if (count($resume) > 0) {
			$uniqueItems = $resume->unique();
			$sorted = $uniqueItems->sortByDesc('last_login_at');
	        $users = $sorted;
        }else{
        	$users = array();
        }

        $html = '


        <div id="accordion" class="panel-group">
        	<div class="spinner">';
							
							$i=0;$count = count($users);
							if($count > 0){
							foreach($users as $user){
							$html.= '
							<div class="card card-default">';
								if($i==0){
								$html.= '	
								<div class="card-header">
									<h4 class="card-title"><a href="" data-toggle="collapse" data-parent="#accordion">'.t('Candidate Search Results'). '('.$count.')</a></h4>
								</div>';
								}//endif
								$html.= '
								<div class="panel-collapse collapse show" id="userPanel">
									<div class="card-body">
										<p>'.$user->name.'</p>

										<p>Last position:'; 
											$position = Experience::where('user_id', $user->id)->latest()->get()->pluck('designation');
								            	if (count($position) > 0) {
								            		$html.= ' '.$position[0];
								            	}
						            	$html.= '
						            	</p>
										<p>Skill: '.$user->skill.'</p>
										<p>Experience: '.$this->countExp($user->id).' years.</p>
										<p>Current CTC: '.$user->current_ctc.' LPA</p>
										 <select class="btn btn-default" style="border-radius:0;height: 38px;">
										     <option selected>Shortlist Candidate for</option>';
										     if (Auth::check()){
										     	$employer_id = Auth::user()->id;
										     }else{
										     	$employer_id = 0;
										     }//endif
										     $jobs = $this->getJobs($employer_id);
										     		$job_count = count($jobs);
										     
										     if($job_count > 0){
										     foreach($jobs as $job){
										     	$html.= '
										     	<option value="'.$job->id.'">'.$job->title.'</option>';
										     }//endforeach
										     }else{
										     	$html.= '
										     	<option value="0">'.t('No jobs.').'</option>';
										     }//endif
										     $html.= '
										   </select>
										  <button type="button" class="btn btn-default" style="border-radius:0">Mark As Favorite</button>';
										  if (Auth::check() && Auth::user()->user_type_id == 1){
										  	$html.= '
										  <a href="'.url('/storage/'.$user->resume).'" type="button" class="btn btn-default" style="border-radius:0" download>Download Resume</a>';
										  }else{
										  	$html.= '
										  <a href="javascript:void();" type="button" class="btn btn-default" style="border-radius:0">Download Resume</a>';
										  }//endif
										  $html.= '
									</div>
								</div>
							</div>';
							$i++;
							}//endforeach
							}else{
								$html.= '
								<div class="card card-default">
								<div class="card-header">
									<h4 class="card-title"><a href="" data-toggle="collapse" data-parent="#accordion">'.t('Candidate Search Results').' ('.$count.')'.' </a></h4>
								</div>
								<div class="panel-collapse collapse show" id="userPanel">
									<div class="card-body">
										<p>'.t('No result. Refine your search using other criteria.').'</p>

									</div>
								</div>
							</div>';
							}//endif
							$html.= '
						</div>
						</div>';

						echo $html; die;

    }
}
