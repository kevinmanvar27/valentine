<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use App\Models\AdminSetting;

class HomeController extends Controller
{
    public function index()
    {
        $registrationFee = AdminSetting::getRegistrationFee();
        $appLogo = AdminSetting::getAppLogo();
        $couplesCount = Couple::count();
        
        return view('welcome', compact('registrationFee', 'appLogo', 'couplesCount'));
    }

    public function couples()
    {
        $couples = Couple::with(['user1', 'user2'])
            ->where('whatsapp_shared', true)
            ->latest('coupled_at')
            ->paginate(12);

        return view('couples', compact('couples'));
    }
}
