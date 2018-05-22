<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Workarounds\Utilities;

class AjaxController extends Controller {
   public function index(){
        //echo Auth::user()->tuser->IdUser;
        $utilities = new Utilities;
        echo $utilities->getDateInfo('2018-03-21','ym');
   }
}