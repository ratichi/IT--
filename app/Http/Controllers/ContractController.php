<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Carbon\Carbon;


class ContractController extends Controller
{

    
    public function create()
    {
        return view('contracts.create');
    }

    


    public function index(Request $request)
    {

        $query = Contract::query();
    

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('secret')) {
            $query->where('secret', $request->secret);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('agreement_number')) {
            $query->where('agreement_number', 'like', '%' . $request->agreement_number . '%');
        }
        if ($request->filled('contract_date')) {
            $query->whereDate('contract_date', $request->contract_date);
        }
        if ($request->filled('funding_code')) {
            $query->where('funding_code', 'like', '%' . $request->funding_code . '%');
        }
    

        $contracts = $query->get();
    

        foreach ($contracts as $contract) {
            try {

                $contract->used_quantity = $contract->usedQuantity();
                $contract->quantity_ratio = $contract->used_quantity . '/' . $contract->quantity; 
                
    

                $contract->recive_term = trim($contract->recive_term);
    
                if (!empty($contract->guarantee_time)) {
                    $guaranteeDate = \Carbon\Carbon::createFromFormat('Y/m', $contract->guarantee_time);
    
                    if (!empty($contract->recive_term)) {
    

                        $receivingTerm = \Carbon\Carbon::createFromFormat('Y-m-d', $contract->recive_term);
    
                        $currentDate = \Carbon\Carbon::now();
                
                        if ($receivingTerm->isBefore($currentDate)) {
                            $contract->remaining_receiving_term = 'Expired';
                        } else {

                            $remainingMonths = $currentDate->diffInMonths($receivingTerm);
    

                            if ($remainingMonths == 0) {
                                $daysRemaining = $currentDate->diffInDays($receivingTerm);
                                if ($daysRemaining >= 20) { // Adjust the threshold if needed
                                    $remainingMonths = 1;
                                }
                            }
    

                            $remainingMonths = ceil($remainingMonths);
    

                            $contract->remaining_receiving_term = $remainingMonths . ' თვე' ;
                        }
                    } else {
                        $contract->remaining_receiving_term = 'Invalid or Missing receiving term';
                    }
    

                    if ($guaranteeDate->isPast()) {
                        $contract->remaining_time = 'Expired';
                    } else {
                        $remainingMonths = $currentDate->diffInMonths($guaranteeDate);
                        $remainingMonths = ceil($remainingMonths);
                        $contract->remaining_time = $remainingMonths . ' თვე' ;
                    }
                } else {
                    $contract->remaining_time = 'Invalid or Missing guarantee time';
                }
            } catch (\Exception $e) {
                $contract->remaining_time = 'Error calculating time';
            }
        }
    

        return view('contracts.index', compact('contracts'));
    }
    
    
    

    
    
    


        public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        return view('contracts.edit', compact('contract'));
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
    
        $contract->update([
            'status' => $request->input('status'),
        ]);
    
        return redirect()->route('contracts.index')->with('success', 'ხელშეკრულების სტატუსი შეიცვალა');
    }
    
    
    
    
    

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'contract_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'organization' => 'required|string|max:255',
            'type' => 'required|string',
            'secret' => 'nullable|boolean',
            'agreement_number' => 'required|string|max:10',
            'contract_date' => 'required|date',
            'contract_term' => 'required|date',
            'recive_term' => 'required|date',
            'purpose' => 'required|string',
            'funding_code' => 'required|string',
            'letter_initiator' => 'required|string',
            'guarantee_time' => 'required|regex:/^\d{4}\/\d{2}$/',
        ]);


        $contract = Contract::create($validatedData);
    

        return redirect()->route('contracts.index');
    }
}
