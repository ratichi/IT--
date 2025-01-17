<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;  


class Contract extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'contracts';

    // Specify the fillable columns
    protected $fillable = [
        'type',
        'contract_name',
        'secret',
        'quantity',
        'agreement_number',
        'contract_date',
        'contract_term',
        'recive_term',
        'organization',
        'purpose',
        'funding_code',
        'letter_initiator',
        'guarantee_time',
        'status',
    ];
    
        public function acts()
    {
        return $this->hasMany(Act::class);
    }

    public function getGuaranteeRemainingAttribute()
    {

        try {
            // Log the guarantee_time to verify the format
            \Log::info('guarantee_time: ' . $this->guarantee_time);
        
            // Parse the guarantee time correctly
            $guaranteeDate = Carbon::createFromFormat('Y/m', $this->guarantee_time);
            \Log::info('Parsed guarantee_date: ' . $guaranteeDate->toDateString());
        
            // Get the current date and log it
            $currentDate = Carbon::now();
            \Log::info('Current date: ' . $currentDate->toDateString());
        
            // Check if the guarantee time has passed by comparing to the start of the current month
            if ($guaranteeDate->isBefore($currentDate->startOfMonth())) {
                return 'Expired';
            }
        
            // Calculate the difference in months
            $remainingMonths = $guaranteeDate->diffInMonths($currentDate);
            $remainingMonths = round($remainingMonths);
        
            // Return the remaining months
            return "$remainingMonths month" . ($remainingMonths > 1 ? 's' : '') . " left";
        } catch (\Throwable $e) {
            \Log::error('Error in getGuaranteeRemainingAttribute: ' . $e->getMessage());
            return 'Error calculating guarantee time';
        }
        
    }

    public function usedQuantity()
    {
        return $this->acts()->sum('quantity');  // Sum the quantity from all related acts
    }

    public function quantityRatio()
{
    return $this->usedQuantity() . '/' . $this->quantity;  // Calculate ratio (received/expected)
}

    
    // In your Contract model
public function getReceivingTermRemainingAttribute()
{
    try {
        $receivingTermDate = Carbon::parse($this->receiving_term);  // Parse the receiving term
        $currentDate = Carbon::now();  // Get the current date

        // Calculate the difference in months
        $remainingMonths = $receivingTermDate->diffInMonths($currentDate);

        // Check if the receiving term has passed and handle accordingly
        if ($receivingTermDate->isPast()) {
            return 'Expired';
        }

        // Return the remaining months
        return "$remainingMonths month" . ($remainingMonths > 1 ? 's' : '') . " left";
    } catch (\Throwable $e) {
        \Log::error('Error in getReceivingTermRemainingAttribute: ' . $e->getMessage());
        return 'Error calculating receiving term';
    }
}



}


