<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use Validator;
use Auth;
use Hash;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tzlist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $data = [];
        $data['tzlist'] = array_combine($tzlist, $tzlist);
        $data['current_tz'] = config('app.timezone');
        $data['proxy'] = "";
        $data['link_shortening'] = false;

        $proxy = Setting::where('key', 'proxy')->first();
        if($proxy)
            $data['proxy'] = $proxy->value;

        $link_shortening = Setting::where('key', 'link_shortening')->first();
        if($link_shortening)
            $data['link_shortening'] = $link_shortening->value;

        $link_shortening = Setting::where('key', 'link_shortening')->first();
        if($link_shortening)
            $data['link_shortening'] = $link_shortening->value;

        return view('settings.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if($request->exists('timezone')) {          
          //change .env
          $file = DotenvEditor::setKey('TIMEZONE', $request->get('timezone'));
          $file = DotenvEditor::save();

          return redirect('settings')->with('message', 'Successfully updated!');
        }

        if($request->exists('proxy')) {
          Setting::updateOrCreate(
            ['key' => 'proxy'],
            ['value' => $request->get('proxy')]
          );
          return redirect('settings')->with('message', 'Successfully updated!');
        }

        if($request->exists('password') || $request->exists('confirm_password')) {

          if(env('DEMO')) {
            return view('errors.disabled');
          }

          $request_data = $request->all();

           $validator = $this->admin_credential_rules($request_data);
           if($validator->fails()) {
             return redirect('settings')->withErrors(['Error - Password do not match']);
          } else {
            $user_id = Auth::User()->id;
            $user = User::find(Auth::User()->id);
            $user->password = Hash::make($request->get('password'));
            $user->save();
            return redirect('settings')->with('message', 'Successfully updated!');
          }
        }
        return redirect('settings');
    }

    private function admin_credential_rules(array $data)
{
  $messages = [
    'confirm_password.required' => 'Please enter current password',
    'password.required' => 'Please enter password',
  ];

  $validator = Validator::make($data, [
    'password' => 'required|same:password',
    'confirm_password' => 'required|same:password',
  ], $messages);

  return $validator;
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
