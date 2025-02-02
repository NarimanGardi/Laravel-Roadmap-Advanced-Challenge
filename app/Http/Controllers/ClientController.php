<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\CreateClientRequset;
use App\Http\Requests\Client\UpdateClientRequset;
use App\Models\Clients;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Clients::class, 'client');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::orderBy('id', 'desc')->paginate(10);
        return view('pages.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequset $request)
    {   
        Clients::create($request->validated());
        toast()->success('Successed','Client created successfully');
        return redirect()->route('clients.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $client)
    {
        return view('pages.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequset $request, Clients $client)
    {
        $client->update($request->validated());
        toast()->success('Successed','Client updated successfully');
        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clients  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clients $client)
    {
        try {
            $client->delete();
            toast()->success('Successed','Client deleted successfully');
        } 
        catch (\Illuminate\Database\QueryException $e) {
            toast()->error('Failed','Client can not be deleted, because it is related to a Project');
        }
        return back();
    }

}
