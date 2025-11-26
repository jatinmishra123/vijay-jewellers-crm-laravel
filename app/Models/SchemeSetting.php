<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeSetting extends Model
{
    protected $table = 'scheme_settings';

   protected $fillable = [
 'scheme_id','scheme_name','scheme_plan','cash_metal','user_group',
 'no_of_users','no_of_emi','emi_amt','multiple_amount','start_token_no','end_token_no',
 'bonus_amount','interest_type','emi_late_fee','convert_bonus_to_gold','late_fee_days',
 'gold_bonus_percent','diamond_bonus_percent','gold_mkg_discount','diamond_mkg_discount',
 'emi_rows'
];


    protected $casts = [
        'convert_bonus_to_gold' => 'boolean',
        'emi_rows' => 'array',
        'emi_amt' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'gold_bonus_percent' => 'decimal:2',
        'diamond_bonus_percent' => 'decimal:2',
    ];
    public function scheme()
{
    return $this->belongsTo(\App\Models\Scheme::class, 'scheme_id');
}

}
