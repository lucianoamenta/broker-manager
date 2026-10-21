<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Insurer;
use App\Models\Organization;
use App\Models\PasRegistration;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Muestra la consola central ejecutiva con métricas maestras y registros de auditoría.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $stats = [
            'organizations_count' => Organization::count(),
            'zones_count' => Zone::count(),
            'insurers_count' => Insurer::count(),
            'pas_count' => PasRegistration::count(),
            'users_count' => User::count(),
        ];

        $recentAudits = Audit::latest()->take(8)->get();
        $organizations = Organization::with(['zones.offices'])->take(5)->get();

        return view('admin.dashboard', compact('user', 'stats', 'recentAudits', 'organizations'));
    }
}
