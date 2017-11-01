<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Organization on behalf of which the contact is acting or for which the contact is working.For guardians or business related contacts, the organization is relevant.

class OrganizationContact extends Model
{
    public function Organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
