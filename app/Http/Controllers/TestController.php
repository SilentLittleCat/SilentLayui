<?php

namespace App\Http\Controllers;

use App\Models\AdminMenu;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $role = AdminRole::first();
        dd(Auth::guard('admin')->user()->getAdminMenus());
    }
}
