<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class PatientReport extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function typeReport()
    {
        return $this->belongsTo(TypeReport::class, 'type_report_id');
    }
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_created_id');
    }
}
