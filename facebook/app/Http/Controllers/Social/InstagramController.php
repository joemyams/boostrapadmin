<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;
use Storage;
use Image;
use Response;
use Redirect;
use Twitter;
use Session;
use App\Models\SocialAccount;
use App\Http\Requests\StoreInstagram;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use \Curl\Curl;
use Goutte\Client;

class InstagramController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        ##$this->middleware('auth');
    }

    public function index(Request $request) {
      //we gotta check if the instagram account is valid
      return view('social.instagram');
    }

    public function postCheckpoint() {
        //validate the thing and login



    }

    public function getCheckpoint() {
        //show the form
        $insta_response = Session::get('insta_response');
        dd($insta_response->challengeType);

        if($insta_response->challengeType == "VerifyEmailCodeForm") {
            $text = "To protect your account, Instagram will send you a security code to verify your identity.";
        }

        return view('social.instagram_checkpoint');
    }

    public function store(StoreInstagram $request)
    {

        $insta_username = $request->get('instagram_username');
        $insta_password = $request->get('instagram_password');

        if(!env('DEMO')) {
          $ig = new \InstagramAPI\Instagram();
          if($request->get('instagram_proxy')) {
            $ig->setProxy($request->get('instagram_proxy'));
          }
          $result = false;
          try {
             $ig->setUser($insta_username, $insta_password);
             $result = $ig->login();
          } catch (\InstagramAPI\Exception\CheckpointRequiredException $e) {
              $request->session()->flash('alert-danger', '<strong>Verification required.</strong> Please login to instagram and validate access to this account.');
              return redirect()->route("instagram.index");
              /*
              "InstagramAPI\\": "packages/mgp25/instagram-php/src"
              $checkpoint_url = $ig->lastResponse[1]->checkpoint_url;

              $curl = new Curl();
              $curl->get($checkpoint_url);
              $cookie = $curl->responseCookies;

              sleep(1);
              $curl->setCookies($cookie);
              $curl->setHeader('referer', $checkpoint_url);
              $curl->setHeader('x-csrftoken', $cookie['csrftoken']);
              $curl->setHeader('x-instagram-ajax', '1');
              $curl->setHeader('X-Requested-With', 'XMLHttpRequest');
              $curl->post($checkpoint_url, array(
                  'choice' => '1',
              ));

              Session::put('insta_response', $curl->response);
              Session::put('csrftoken',  $cookie['csrftoken']);
              Session::put('insta_username',  $insta_username);
              Session::put('insta_password',  $insta_password);
              return redirect()->route("instagram.checkpoint");
              */
          } catch (\Exception $e) {
              $request->session()->flash('alert-danger', '<strong>Oh snap!</strong> Your Instagram login details are incorrect OR your proxy is failing.<br />'.$e->getMessage());
              return redirect()->route("instagram.index");
          }
        }

        $encrypted = Crypt::encryptString($insta_password);
        #$decrypted = Crypt::decryptString($encrypted);

        $social = SocialAccount::firstOrCreate(
           ['platform' => 'instagram', 'username' => $insta_username],
           ['access_token' => ['password' => $encrypted]]
        );
        if($request->get('instagram_proxy'))
          $social->proxy = $request->get('instagram_proxy');
        $social->access_token = ['password' => $encrypted];
        $social->label = $insta_username;
        $social->needs_reauth = false;
        $social->user_id = auth()->user()->id;
        $social->save();

        $helper = new \App\Helper();
        $helper->syncAccountToClientGroup($social->id, auth()->user()->id);

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(base_path("vendor/mgp25/instagram-php/sessions/" . strtolower($insta_username))));
        foreach($iterator as $item) {
          chmod($item, 0777);
        }

        $request->session()->flash('alert-success', 'Congrats! Your Instagram account was added!');
        return redirect()->route("social-accounts.index");
    }


}
