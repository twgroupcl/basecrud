<?php

namespace Twgroupcl\BaseCrud\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

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

        $settingsOutput = new BufferedOutput;

        Artisan::call('vendor:publish', [
            '--provider' => 'Backpack\Settings\SettingsServiceProvider',
        ], $settingsOutput);

        Artisan::call('migrate"', array(), $settingsOutput);

        echo($settingsOutput->fetch());
    }
}