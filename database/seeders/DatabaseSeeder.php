<?php

namespace Database\Seeders;

use App\Models\BusinessActivity;
use App\Models\City;
use App\Models\Device;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\FiscalCondition;
use App\Models\Gender;
use App\Models\InsuredRiskType;
use App\Models\MaritalStatus;
use App\Models\Notification;
use App\Models\OccupationalStatus;
use App\Models\Profession;
use App\Models\Province;
use App\Models\ResidenceType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        BusinessActivity::truncate();
        City::truncate();
        Device::truncate();
        Employee::truncate();
        EmployeeType::truncate();
        FiscalCondition::truncate();
        Gender::truncate();
        InsuredRiskType::truncate();
        MaritalStatus::truncate();
        Notification::truncate();
        OccupationalStatus::truncate();
        Profession::truncate();
        Province::truncate();
        ResidenceType::truncate();
        User::truncate();

        BusinessActivity::flushEventListeners();
        City::flushEventListeners();
        Device::flushEventListeners();
        Employee::flushEventListeners();
        EmployeeType::flushEventListeners();
        FiscalCondition::flushEventListeners();
        Gender::flushEventListeners();
        InsuredRiskType::flushEventListeners();
        MaritalStatus::flushEventListeners();
        Notification::flushEventListeners();
        OccupationalStatus::flushEventListeners();
        Profession::flushEventListeners();
        Province::flushEventListeners();
        ResidenceType::flushEventListeners();
        User::flushEventListeners();

        $this->call([
            CitiesTableSeeder::class,
            RolesTableSeeder::class,
            CatalogSeeder::class,
            InitialScenarioSeeder::class,
        ]);
    }
}
