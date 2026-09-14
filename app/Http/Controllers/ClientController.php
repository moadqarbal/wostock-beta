<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Client::withCount('orders');

        // Search
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $clients = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255|unique:clients,phone',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'address' => 'nullable|string',
        ]);

        Client::create($validated);

        return to_route('clients.index')->with('success', 'Le client a été ajouté à votre liste de clients.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load('orders');

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255|unique:clients,phone,' . $client->id,
            'email' => 'nullable|email|max:255|unique:clients,email,' . $client->id,
            'address' => 'nullable|string',
        ]);

        $client->update($validated);

        return to_route('clients.show', $client)->with('success', 'Les informations du client ont été mises à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        if ($client->orders()->exists()) {
            return to_route('clients.index')
                ->with('error', 'Impossible de supprimer ce client car il possède des commandes.');
        }

        $client->delete();

        return to_route('clients.index')
            ->with('success', 'Le client a été supprimé avec succès.');
    }
}
