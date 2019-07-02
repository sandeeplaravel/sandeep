<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempResumeController extends Controller
{
    //
    public function index(Request $request)
    {
        // echo "Hello Whats up !!!";
        echo $request->input('user_type_id');
        echo $request->hasFile('hasFile');
        
        return $request;

        // redirect()->intended(config('app.locale') . '/register');

        /* 
        // Add Job seekers resume
        if ($request->input('user_type_id') == 2) {
            if ($request->hasFile('hasFile')) {
                // Lucky : All the temp resumes are being saved as this user in DB
                // userId = 2
                // $dbUserId = 2;
                // Save user's resume
                $resumeInfo = [
                    'country_code' => config('country.code'),
                    'user_id'      => 2,
                    'active'       => 1
                ];
                $resume = new Resume($resumeInfo);
                $resume->save();
                
                // Upload user's resume
                $resume->filename = $request->file('filename');
                $resume->save();

                echo "hello Its Done....";
                
                echo "x :userId has been deleted successfully."; // , ['userId' => t('resumeInfo')]);
                flash(t("Your resume has created successfully."));
                // flash  "Successfully uploaded resume."))->success();
            }
        }
        */

    }

    public function store(Request $request)
    {
        // echo "File saved succesfully <br>  " ;

        // echo $request;
        // $request->file('resumeFile')->store('tempResumes', 'public');
        
        $file     = $request->file('resumeFile');

        $originalFileName = $file->getClientOriginalName();
        $tempFolderPath = 'tempResumes/' . date("Y") . '/' . date("m") . '/' . date("d") . '/';
        $fileNameToStore = pathinfo($originalFileName)['filename'] . '_' . time() .  "." . $file->guessClientExtension();

        $file->storeAs($tempFolderPath, $fileNameToStore);

        return $tempFolderPath . ' ' . $fileNameToStore;

        // return redirect('register');
    }

}
