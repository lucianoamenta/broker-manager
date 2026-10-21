<?php

namespace App\Http\Controllers\Console;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ConsoleDashboardController extends Controller
{
    /**
     * Terminal Operativa de Cajero (Cobranzas, Arqueos, Recibos).
     */
    public function cashier(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $cashier = $user->cashier()->with('office.cashRegisters')->first();

        return view('console.cashier', compact('user', 'cashier'));
    }

    /**
     * Terminal de Recaudador Territorial (Rutas de Cobranza, Lotes).
     */
    public function collector(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $collector = $user->collector()->with(['organization', 'zones'])->first();

        return view('console.collector', compact('user', 'collector'));
    }

    /**
     * Panel de Representante de Oficina / Encargado de Sucursal.
     */
    public function office(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $officeRep = $user->officeRepresentative()->with('office.cashRegisters')->first();

        return view('console.office', compact('user', 'officeRep'));
    }

    /**
     * Panel de Representante / Supervisor de Zona.
     */
    public function zone(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $zoneRep = $user->zoneRepresentative()->with('zone.offices')->first();

        return view('console.zone', compact('user', 'zoneRep'));
    }

    /**
     * Panel de Representante / Directorio de Organización.
     */
    public function organization(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $orgRep = $user->organizationRepresentative()->with('organization.zones')->first();

        return view('console.organization', compact('user', 'orgRep'));
    }

    /**
     * Panel de Departamento Funcional (Tesorería, Legales, etc.).
     */
    public function department(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $deptRep = $user->departmentRepresentative()->with('department')->first();

        return view('console.department', compact('user', 'deptRep'));
    }
}
