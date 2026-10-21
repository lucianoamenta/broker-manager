<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientDashboardController extends Controller
{
    /**
     * Muestra el panel principal del cliente asegurado con sus pólizas y pagos.
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $party = $user->party;

        return view('client.dashboard', compact('user', 'party'));
    }
}
