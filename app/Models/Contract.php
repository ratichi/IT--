<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;  


class Contract extends Model
{
    use HasFactory;


    protected $table = 'contracts';


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

        

            $guaranteeDate = Carbon::createFromFormat('Y/m', $this->guarantee_time);
        

            $currentDate = Carbon::now();
        

            if ($guaranteeDate->isBefore($currentDate->startOfMonth())) {
                return 'Expired';
            }
        

            $remainingMonths = $guaranteeDate->diffInMonths($currentDate);
            $remainingMonths = round($remainingMonths);
        

            return "$remainingMonths month" . ($remainingMonths > 1 ? 's' : '') . " left";
        } catch (\Throwable $e) {
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

    

public function getReceivingTermRemainingAttribute()
{
    try {
        $receivingTermDate = Carbon::parse($this->receiving_term);  // Parse the receiving term
        $currentDate = Carbon::now();  // Get the current date


        $remainingMonths = $receivingTermDate->diffInMonths($currentDate);


        if ($receivingTermDate->isPast()) {
            return 'Expired';
        }


        return "$remainingMonths month" . ($remainingMonths > 1 ? 's' : '') . " left";
    } catch (\Throwable $e) {
        return 'Error calculating receiving term';
    }
}



}


