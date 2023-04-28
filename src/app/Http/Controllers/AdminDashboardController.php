<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Admin;
 
class AdminDashboardController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
 
        return view('admin.dashboard', ['admins' => $admins,]);
    }
}