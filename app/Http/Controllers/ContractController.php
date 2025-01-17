<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Carbon\Carbon;


class ContractController extends Controller
{
    // Show the form
    
    public function create()
    {
        return view('contracts.create');
    }

    

    // Handle the form submission
    public function index(Request $request)
    {
        // Initialize the query
        $query = Contract::query();
    
        // Apply filters if search fields are provided
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
    
        // Retrieve the filtered contracts
        $contracts = $query->get();
    
        // Process each contract
        foreach ($contracts as $contract) {
            try {
                // Add used quantity and ratio
                $contract->used_quantity = $contract->usedQuantity();
                $contract->quantity_ratio = $contract->used_quantity . '/' . $contract->quantity; 
                
                \Log::info('receiving_term: ' . $contract->recive_term);
    
                // Trim spaces to avoid parsing issues
                $contract->recive_term = trim($contract->recive_term);
    
                if (!empty($contract->guarantee_time)) {
                    $guaranteeDate = \Carbon\Carbon::createFromFormat('Y/m', $contract->guarantee_time);
    
                    if (!empty($contract->recive_term)) {
    
                        // Parse the receiving_term with yyyy-mm-dd format
                        $receivingTerm = \Carbon\Carbon::createFromFormat('Y-m-d', $contract->recive_term);
                        \Log::info('Parsed receivingTerm: ' . $receivingTerm);
    
                        $currentDate = \Carbon\Carbon::now();
                
                        if ($receivingTerm->isBefore($currentDate)) {
                            $contract->remaining_receiving_term = 'Expired';
                        } else {
                            // Calculate the difference in months
                            $remainingMonths = $currentDate->diffInMonths($receivingTerm);
    
                            // If the remaining months are 0, check the days difference
                            if ($remainingMonths == 0) {
                                $daysRemaining = $currentDate->diffInDays($receivingTerm);
                                if ($daysRemaining >= 20) { // Adjust the threshold if needed
                                    $remainingMonths = 1;
                                }
                            }
    
                            // Round up the remaining months (if necessary)
                            $remainingMonths = ceil($remainingMonths);
    
                            // Append "month(s)"
                            $contract->remaining_receiving_term = $remainingMonths . ' თვე' ;
                        }
                    } else {
                        $contract->remaining_receiving_term = 'Invalid or Missing receiving term';
                    }
    
                    // Guarantee time calculations
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
                \Log::error('Error in parsing receiving_term or guarantee_time: ' . $e->getMessage());
                $contract->remaining_time = 'Error calculating time';
            }
        }
    
        // Pass the filtered contracts to the view
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
    
        return redirect()->route('contracts.index')->with('success', 'Contract status updated successfully!');
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

        // Create a new contract
        $contract = Contract::create($validatedData);
    
        // Redirect or return a response
        return redirect()->route('contracts.index');
    }
}
