<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
	Demographics and other administrative information about an individual or animal receiving care or 
	other health-related services.racking patient is the center of the healthcare process.
	https://www.hl7.org/fhir/patient.html
*/

class Patient extends Model
{
	protected $table = 'patients';
    
    const MALE = 0;
	const FEMALE = 1;
	const BOTH = 2;
	const UNKNOWN = 3;

	public function Address()
     {
    	return $this->hasMany('App\Models\Address');
     }
      
      public function EpisodesOfCare()
      {
          return $this->hasMany('App\Models\EpisodesOfCare','patient_id');
      }
     public function User()
    {
     	return $this->belongsTo('App\Models\User');
     }
 
     public function Practitioner()
     {
    	return $this->hasOne('App\Models\Practitioner');
 
     }
    

     public function PatientCommunications()
     {
     	return $this->hasMany('App\Models\PatientCommunications','patient_id');
     }

     public function PatientContact()
     {
     	return $this->hasMany('App\Models\PatientContact','patient_id');
     }

     public function PatientLinks()
     {
     	return $this->hasMany('App\Models\PatientLinks');
     }
     
     public function ReferralRequest()
     {
        return $this->belongsTo('App\Models\ReferralRequest','subject');
     }


}
