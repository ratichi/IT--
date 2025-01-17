<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Act;
use Illuminate\Http\Request;

class ActController extends Controller
{
    public function create(Contract $contract)
    {
        return view('acts.create', compact('contract'));
    }

    public function store(Request $request, Contract $contract)
    {
        $request->validate([
            'date_of_act' => 'required|date',
            'number_of_act' => 'required|string|max:255',
            'receive_date' => 'required|date',
            'quantity' => 'required|integer',
        ]);

        $contract->acts()->create($request->all());

        return redirect()->route('contracts.index')->with('success', 'Act added successfully!');
    }
        public function index(Contract $contract)
    {

        $acts = $contract->acts; // This assumes your Contract model has a relationship defined as 'acts'
        
        return view('acts.index', compact('contract', 'acts'));
    }

    
}
