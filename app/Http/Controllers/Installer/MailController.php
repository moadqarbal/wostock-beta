<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class MailController extends Controller
{
    public function index()
    {
        return view('installer.mail');
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'host' => ['nullable', 'string'],
            'port' => ['nullable', 'integer'],
            'username' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'encryption' => ['nullable', 'in:tls,ssl'],
            'from_address' => ['nullable', 'email'],
            'from_name' => ['nullable', 'string', 'max:255'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | SMTP is optional
        |--------------------------------------------------------------------------
        */

        if (empty($validated['host'])) {

            session([
                'installer.mail' => [
                    'enabled' => false,
                ],
            ]);

            return redirect()
                ->route('installer.admin')
                ->with('success', 'Email configuration skipped.');
        }

        /*
        |--------------------------------------------------------------------------
        | SMTP connection test
        |--------------------------------------------------------------------------
        */

        try {
            $transport = new EsmtpTransport(
                $validated['host'],
                (int) ($validated['port'] ?: 25),
            );

            /*
            |--------------------------------------------------------------------------
            | Authentication is optional
            |--------------------------------------------------------------------------
            */

            if (!empty($validated['username'])) {
                $transport->setUsername($validated['username']);
                $transport->setPassword($validated['password'] ?? '');
            }

            $transport->start();
            $transport->stop();

            session([
                'installer.mail' => [
                    'enabled' => true,
                    'host' => $validated['host'],
                    'port' => $validated['port'] ?: 25,
                    'username' => $validated['username'] ?? '',
                    'password' => $validated['password'] ?? '',
                    'encryption' => $validated['encryption'] ?? '',
                    'from_address' => $validated['from_address'] ?? '',
                    'from_name' => $validated['from_name'] ?? '',
                ],
            ]);

            return redirect()
                ->route('installer.admin')
                ->with('success', 'SMTP connection successful.');

        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->withErrors([
                    'mail' => 'Could not connect to the SMTP server. Please check your settings.',
                ]);
        }
    }
}