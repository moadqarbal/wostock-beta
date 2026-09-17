<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    public function index()
    {
        return view('installer.install');
    }

    public function install(Request $request)
    {
        $database = session('installer.database');
        $application = session('installer.application');
        $mail = session('installer.mail');
        $admin = session('installer.admin');

        if (!$database || !$application || !$admin) {
            return redirect()
                ->route('installer.requirements')
                ->withErrors([
                    'installer' => 'Installation data is incomplete.',
                ]);
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Mail configuration
            |--------------------------------------------------------------------------
            */

            $mailEnabled = $mail['enabled'] ?? false;

            /*
            |--------------------------------------------------------------------------
            | Update environment
            |--------------------------------------------------------------------------
            */

            $environment = [
                'APP_NAME' => $application['app_name'],
                'APP_URL' => $application['app_url'],

                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => $database['host'],
                'DB_PORT' => $database['port'],
                'DB_DATABASE' => $database['database'],
                'DB_USERNAME' => $database['username'],
                'DB_PASSWORD' => $database['password'],
            ];

            /*
            |--------------------------------------------------------------------------
            | Mail is optional
            |--------------------------------------------------------------------------
            */

            if ($mailEnabled) {
                $environment = array_merge($environment, [
                    'MAIL_MAILER' => 'smtp',
                    'MAIL_HOST' => $mail['host'],
                    'MAIL_PORT' => $mail['port'],
                    'MAIL_USERNAME' => $mail['username'] ?? '',
                    'MAIL_PASSWORD' => $mail['password'] ?? '',
                    'MAIL_ENCRYPTION' => $mail['encryption'] ?? '',
                    'MAIL_FROM_ADDRESS' => $mail['from_address'] ?? '',
                    'MAIL_FROM_NAME' => $mail['from_name'] ?? '',
                ]);
            } else {
                /*
                |--------------------------------------------------------------------------
                | No SMTP configured
                |--------------------------------------------------------------------------
                */

                $environment = array_merge($environment, [
                    'MAIL_MAILER' => 'log',
                    'MAIL_HOST' => '',
                    'MAIL_PORT' => 2525,
                    'MAIL_USERNAME' => '',
                    'MAIL_PASSWORD' => '',
                    'MAIL_ENCRYPTION' => '',
                    'MAIL_FROM_ADDRESS' => '',
                    'MAIL_FROM_NAME' => '',
                ]);
            }

            $this->updateEnvironment($environment);

            /*
            |--------------------------------------------------------------------------
            | Clear configuration cache
            |--------------------------------------------------------------------------
            */

            Artisan::call('config:clear');

            /*
            |--------------------------------------------------------------------------
            | Configure database connection
            |--------------------------------------------------------------------------
            */

            config([
                'database.connections.mysql.host' => $database['host'],
                'database.connections.mysql.port' => $database['port'],
                'database.connections.mysql.database' => $database['database'],
                'database.connections.mysql.username' => $database['username'],
                'database.connections.mysql.password' => $database['password'],
            ]);

            DB::purge('mysql');
            DB::reconnect('mysql');

            DB::connection('mysql')->getPdo();

            /*
            |--------------------------------------------------------------------------
            | Generate application key
            |--------------------------------------------------------------------------
            */

            Artisan::call('key:generate', [
                '--force' => true,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Run migrations
            |--------------------------------------------------------------------------
            */

            Artisan::call('migrate', [
                '--force' => true,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create administrator
            |--------------------------------------------------------------------------
            */

            User::updateOrCreate(
                [
                    'email' => $admin['email'],
                ],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make($admin['password']),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Lock installer
            |--------------------------------------------------------------------------
            */

            $lockPath = storage_path('framework/installed');

            File::put(
                $lockPath,
                now()->toDateTimeString()
            );

            /*
            |--------------------------------------------------------------------------
            | Clear installer session
            |--------------------------------------------------------------------------
            */

            session()->forget([
                'installer.database',
                'installer.application',
                'installer.mail',
                'installer.admin',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Installation complete
            |--------------------------------------------------------------------------
            */

            return redirect('/login')
                ->with(
                    'success',
                    'WoStock has been installed successfully.'
                );

        } catch (\Throwable $e) {

            return back()
                ->withErrors([
                    'install' => $e->getMessage(),
                ]);
        }
    }

    private function updateEnvironment(array $values): void
    {
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            $env = File::get($envPath);
        } else {
            $env = File::get(base_path('.env.example'));
        }

        foreach ($values as $key => $value) {

            $value = '"' . addslashes((string) $value) . '"';

            $pattern = "/^" . preg_quote($key, '/') . "=.*$/m";

            if (preg_match($pattern, $env)) {

                $env = preg_replace(
                    $pattern,
                    $key . '=' . $value,
                    $env
                );

            } else {

                $env .= PHP_EOL . $key . '=' . $value;
            }
        }

        File::put($envPath, $env);
    }
}