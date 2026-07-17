<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function redirect($provider) { return redirect('/'); }
    public function callback($provider) { return redirect('/'); }
}
