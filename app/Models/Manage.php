<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manage extends Model
{
    protected $fillable = [
        'kij',
        'mobile_number',
        'first_name',
        'last_name',
        'father_name',
        'country',
        'state',
        'city_village',
        'gender',
        'marital_status',
        'date_of_birth',
        'aadhar_number',
        'pan_number',

        // Scheme details
        'scheme_name',
        'scheme_emi_amount',
        'scheme_emi_plan',
        'start_date',
        'end_date',
        'nominee_name',
        'nominee_relation',
        'user_group',
        'staff_id',
        'other_information',

        // Uploads
        'profile_image',
        'pan_card',
        'aadhar_card',
    ];
}
