<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Owner;
 
class OwnerDashboardController extends Controller
{
    public function index()
    {
        $owners = Owner::all();
 
        return view('owner.dashboard', ['owners' => $owners,]);
    }
}