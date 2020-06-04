<?php

namespace Twgroupcl\BaseCrud\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class InstallBaseCrud extends Command
{
    protected $progressBar;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twgroup:install
                                {--timeout=300} : How many seconds to allow each process to run.
                                {--debug} : Show process output or not. Useful for debugging.';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Backpack base command and TWGroup dependencies.';

    /**
     * Execute the console command.
     *
     * @return mixed Command-line output
     */
    public function handle()
    {
        $backpackOutput = new BufferedOutput;

        Artisan::call('backpack:install', array(), $backpackOutput);

        echo($backpackOutput->fetch());

        /* Init - Install Permission Manager */
        $permissionOutput = new BufferedOutput;

        Artisan::call('vendor:publish', [
            '--provider' => 'Spatie\Permission\PermissionServiceProvider',
            '--tag' => 'migrations',
        ], $permissionOutput);

        Artisan::call('migrate"', array(), $permissionOutput);

        Artisan::call('vendor:publish', [
            '--provider' => 'Spatie\Permission\PermissionServiceProvider',
            '--tag' => 'config',
        ], $permissionOutput);

        Artisan::call('vendor:publish', [
            '--provider' => 'Backpack\PermissionManager\PermissionManagerServiceProvider',
        ], $permissionOutput);

        echo($permissionOutput->fetch());

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/app/User.php', 'app/User.php']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        Artisan::call('backpack:add-sidebar-content', [
            'code' => '<li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-group"></i> Autenticación</a>
            <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url(\'user\') }}"><i class="nav-icon fa fa-user"></i> <span>Usuarios</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url(\'role\') }}"><i class="nav-icon fa fa-group"></i> <span>Roles</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ backpack_url(\'permission\') }}"><i class="nav-icon fa fa-key"></i> <span>Permisos</span></a></li>
            </ul>
            </li>',
        ], $backpackOutput);

        $this->info('Permission Manager installed.' . "\n\n");
        /* End - Install Permission Manager */

        /* Init - Install Settings */
        $settingsOutput = new BufferedOutput;

        Artisan::call('vendor:publish', [
            '--provider' => 'Backpack\Settings\SettingsServiceProvider',
        ], $settingsOutput);

        Artisan::call('migrate"', array(), $settingsOutput);

        echo($settingsOutput->fetch());

        Artisan::call('backpack:add-sidebar-content', [
            'code' => '<li class="nav-item"><a class="nav-link" href="{{ backpack_url(\'settings\') }}"><i class="nav-icon la la-question"></i> Parámetros</a></li>',
        ], $backpackOutput);

        $this->info('Settings installed.' . "\n\n");
        /* End - Install Settings */

        /* Init - Install Customer/Module */
        $install = $this->confirm('Do you like install Customer Module?');

        if (!$install) {
            return;
        }

        $process = new Process(['mkdir', '-p', 'app/Cruds/Customers']);
        $process->run();
        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Cruds/Customers/CustomerCrudFields.php', 'app/Cruds/Customers/CustomerCrudFields.php']);
        $process->run();

        $process = new Process(['mkdir', '-p', 'app/Http/Controllers/Admin']);
        $process->run();
        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Http/Controllers/Admin/CustomerCrudController.php', 'app/Http/Controllers/Admin/CustomerCrudController.php']);
        $process->run();

        $process = new Process(['mkdir', '-p', 'app/Http/Requests']);
        $process->run();
        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Http/Requests/CustomerRequest.php', 'app/Http/Requests/CustomerRequest.php']);
        $process->run();

        $process = new Process(['mkdir', '-p', 'app/Models']);
        $process->run();
        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Models/Customer.php', 'app/Models/Customer.php']);
        $process->run();

        Artisan::call('backpack:add-sidebar-content', [
            'code' => '<li class="nav-item"><a class="nav-link" href="{{ backpack_url(\'customers\') }}"><i class="nav-icon la la-question"></i> Clientes</a></li>',
        ], $backpackOutput);

        Artisan::call('backpack:add-custom-route', [
            'code' => 'Route::crud(\'customers\', \'CustomerCrudController\');',
        ], $backpackOutput);

        // Publish migrations and seeds
        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/database/migrations/2020_06_03_224718_create_customers_table.php', 'database/migrations']);
        
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/database/migrations/src/database/migrations/2019_10_16_175309_create_sii_activities_table.php', 'database/migrations']);
        
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/database/migrations/src/database/seeds/ChileanSiiTableSeeder.php', 'database/seeds']);
        
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Models/SiiActivity.php', 'app/Models/SiiActivity.php']);
        $process->run();

        // Regions
        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/database/migrations/src/database/migrations/2019_10_16_175736_create_regions_table.php', 'database/migrations']);
        
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/database/migrations/src/database/migrations/2019_10_16_175742_create_provinces_table.php', 'database/migrations']);
        
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/database/migrations/src/database/migrations/2019_10_16_175749_create_communes_table.php', 'database/migrations']);
        
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/database/migrations/src/database/seeds/RegionsTableSeeder.php', 'database/seeds']);
        
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Models/Region.php', 'app/Models/Region.php']);
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Models/Province.php', 'app/Models/Province.php']);
        $process->run();

        $process = new Process(['cp', '-rf', 'vendor/twgroupcl/basecrud/src/templates/Customer/app/Models/Commune.php', 'app/Models/Commune.php']);
        $process->run();

        $this->info('Customer Module.' . "\n\n");
        /* End - Install Customer/Module */

        $this->info("\n" . 'No time for losers \'Cause we are the champions of the world!' . "\n");
    }
}