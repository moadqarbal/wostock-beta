<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;

class RequirementsController extends Controller
{
    public function index()
    {
        $requirements = [
            'php' => [
                'name' => 'PHP',
                'required' => '8.2',
                'current' => PHP_VERSION,
                'passed' => version_compare(PHP_VERSION, '8.2.0', '>='),
            ],

            'pdo' => [
                'name' => 'PDO',
                'required' => 'Required',
                'current' => extension_loaded('pdo') ? 'Installed' : 'Missing',
                'passed' => extension_loaded('pdo'),
            ],

            'mbstring' => [
                'name' => 'Mbstring',
                'required' => 'Required',
                'current' => extension_loaded('mbstring') ? 'Installed' : 'Missing',
                'passed' => extension_loaded('mbstring'),
            ],

            'openssl' => [
                'name' => 'OpenSSL',
                'required' => 'Required',
                'current' => extension_loaded('openssl') ? 'Installed' : 'Missing',
                'passed' => extension_loaded('openssl'),
            ],

            'tokenizer' => [
                'name' => 'Tokenizer',
                'required' => 'Required',
                'current' => extension_loaded('tokenizer') ? 'Installed' : 'Missing',
                'passed' => extension_loaded('tokenizer'),
            ],

            'xml' => [
                'name' => 'XML',
                'required' => 'Required',
                'current' => extension_loaded('xml') ? 'Installed' : 'Missing',
                'passed' => extension_loaded('xml'),
            ],

            'ctype' => [
                'name' => 'Ctype',
                'required' => 'Required',
                'current' => extension_loaded('ctype') ? 'Installed' : 'Missing',
                'passed' => extension_loaded('ctype'),
            ],

            'json' => [
                'name' => 'JSON',
                'required' => 'Required',
                'current' => extension_loaded('json') ? 'Installed' : 'Missing',
                'passed' => extension_loaded('json'),
            ],
        ];

        $permissions = [
            'storage' => [
                'name' => 'storage/',
                'path' => storage_path(),
                'passed' => is_writable(storage_path()),
            ],

            'cache' => [
                'name' => 'bootstrap/cache/',
                'path' => base_path('bootstrap/cache'),
                'passed' => is_writable(base_path('bootstrap/cache')),
            ],
        ];

        $requirementsPassed = collect($requirements)
            ->every(fn ($requirement) => $requirement['passed']);

        $permissionsPassed = collect($permissions)
            ->every(fn ($permission) => $permission['passed']);

        return view('installer.requirements', compact(
            'requirements',
            'permissions',
            'requirementsPassed',
            'permissionsPassed'
        ));
    }
}