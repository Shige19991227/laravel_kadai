<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Profile;

class ProfileController extends Controller
{
    //
     public function add()
    {
        return view('admin.profile.create');
    }
    public function create(Request $request)
  {
    $this->validate($request, Profile::$rules);
    
     $profile = new Profile;
      $form = $request->all();
   unset($form['_token']);
   $profile->fill($form);
   $profile->save();
   
   return redirect('admin/profile/create');
  }
   
    public function edit()
    {
        return view('admin.profile.edit');
    }

 public function update(Request $request)
  {
     // Validationをかける
     $this->validate($request, Profile::$rules);
     // Profile Modelからデータを取得する
     $profile = Profile::find($request->id);

     // 送信されてきたフォームデータを格納する
     $profile_form = $request->all();

     unset($profile_form['remove']);
     //トークンの削除
     unset($profile_form['_token']);
     // 該当するデータを上書きして保存する
     $profile->fill($profile_form)->save();

        $profileHistory = new ProfileHistory;
        $profileHistory->profile_id = $profile->id;
        $profileHistory->edited_at = Carbon::now();
        $profileHistory->save();
        return redirect('admin/profile/edit');
    }
}