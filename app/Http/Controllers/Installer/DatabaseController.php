<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class DatabaseController extends Controller
{
    public function index()
    {
        return view('installer.database');
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'host' => ['required', 'string'],
            'port' => ['required', 'integer'],
            'database' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['nullable', 'string'],
        ]);

        try {
            $pdo = new \PDO(
                "mysql:host={$validated['host']};port={$validated['port']};dbname={$validated['database']}",
                $validated['username'],
                $validated['password']
            );

            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            session([
                'installer.database' => $validated,
            ]);

            return redirect()
                ->route('installer.application')
                ->with('success', 'Database connection successful.');
        } catch (PDOException $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'database' => 'Could not connect to the database. Please check your credentials.',
                ]);
        }
    }
}