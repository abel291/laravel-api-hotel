<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    function init()
    {
        $pages = Page::get()->keyBy('type');
        if (Auth::check()) {
            $user = Auth::user()->only(['name', 'email', 'phone']);
        } else {
            $user = false;
        }
        return response()->json([
            'user' => $user,
            'pages' => $pages
        ]);
    }
}
