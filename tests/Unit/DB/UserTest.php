<?php

namespace Tests\Unit\DB;

use App\DB\Address;
use App\DB\ContactPoint;
use App\DB\HumanName;
use App\DB\Organization;
use App\DB\Patient;
use App\DB\Practitioner;
use App\User;
use App\UserType;
use Faker\Generator as Facker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /* Test */
    public function testaddNewUserType()
    {
        $userTypeArray = [
            'name' => 'test name',
            'description' => 'decription here'
        ];

        $this->post('/api/usertype/', $userTypeArray);

        $this->assertDatabaseHas('user_types',$userTypeArray);
    }
    
    /* Test */
    public function testaddNewUser()
    {
        $userArray = [
            'type' => factory(UserType::class)->create()->id,
            'email' => 'test@example.com',
            'password' => '1234678'
        ];

        $this->post('/user/', $userArray);

        $this->assertDatabaseHas('users',$userArray);
    }

    /* Test */
    public function testaddNewPatient()
    {
        $userTypeId  = factory(UserType::class)->create(['name'=>'patient'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;

        $patientArray = [
            'user_id' => $userId,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telecom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'gender' => \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            'deceased' => \Faker\Factory::create()->boolean(),
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'marital_status' => factory(\App\CodeableConcepts::class)->create()->id,
            'multiple_birth' => 1,
            'photo' => 'path/to/photo/here',
            'general_practitioner_type' => \Faker\Factory::create()->randomElement(['organization', 'practitioner']),
            'general_practitioner_id' => 1,
            'managing_organization' => factory(Organization::class)->create()->id
        ];

        $this->post('/api/patient/', $patientArray);

        $this->assertDatabaseHas('patients',$patientArray);
    }


    /* Test */
    public function testaddNewhumannames()
    {

        $humannamesArray = [
            'user_id' => factory(User::class)->create()->id,
            'use' => \Faker\Factory::create()->randomElement(['usual', 'official', 'temp', 'nickname', 'anonymous', 'old', 'maiden']),
            'text' => 'text_name',
            'family' => 'family_name',
            'given' => 'given_name',
            'prefix' => 'name_prefix',
            'suffix' => 'name_suffix',
            'period' => \Faker\Factory::create()->date()

        ];

        $this->post('/api/humanname/', $humannamesArray);

        $this->assertDatabaseHas('human_names',$humannamesArray);
    }


    /* Test */
    public function testaddNewContactPoint()
    {

        $ContactPointArray = [
            'user_id' => factory(User::class)->create()->id,
            'system' =>  factory(\App\CodeableConcepts::class)->create()->id,
            'value' => \Faker\Factory::create()->word,
            'use' =>  \Faker\Factory::create()->randomElement(['home', 'work', 'temp', 'old', 'mobile']),
            'rank' => \Faker\Factory::create()->number,
            'period' => \Faker\Factory::create()->date()
            
        ];

        $this->post('/api/contactpoint', $ContactPointArray);

        $this->assertDatabaseHas('contact_points',$ContactPointArray);
    }

    /* Test */
    public function testaddNewAddresses()
    {
        $AddressesArray = [
            'use' =>  \Faker\Factory::create()->randomElement(['home', 'work', 'temp', 'old']),
            'type' =>  \Faker\Factory::create()->randomElement(['postal', 'physical', 'both']),
            'text' => \Faker\Factory::create()->word,
            'line' => \Faker\Factory::create()->word,
            'city' => \Faker\Factory::create()->word,
            'district' => \Faker\Factory::create()->word,
            'state' => \Faker\Factory::create()->word,
            'postal_code' => \Faker\Factory::create()->word,
            'country' => \Faker\Factory::create()->word,
            'period' => \Faker\Factory::create()->date(),
        ];

        $this->post('/api/address', $AddressesArray);

        $this->assertDatabaseHas('addresses',$AddressesArray);
    }


    /* Test */
    public function testaddNewPatientContact()
    {
        $userId  = factory(User::class)->create()->id;
        $patientId  = factory(Patient::class)->create(['user_id'=>$userId])->id;
        $PatientContactArray = [
            'patient_id' => $patientId,
            'relationship' =>  factory(\App\CodeableConcepts::class)->create()->id,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'organization_id' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'period' => \Faker\Factory::create()->date(),
        ];

        $this->post('/api/patientcontact', $PatientContactArray);

        $this->assertDatabaseHas('patient_contacts',$PatientContactArray);
    }
    

    /* Test */
    public function testaddNewOrganization()
    {
        $userTypeId  = factory(UserType::class)->create(['name'=>'organization'])->id;
        
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        
        $organizationArray = [
            'user_id' => $userId,
            'type' =>  factory(\App\CodeableConcepts::class)->create()->id,
            'name' => \Faker\Factory::create()->word,
            'alias' => \Faker\Factory::create()->word,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'part_of' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'end_point' =>  \Faker\Factory::create()->url
        ];

        $this->post('/api/organization', $organizationArray);

        $this->assertDatabaseHas('organizations',$organizationArray);
    }
    
    /* Test */
    public function testaddNewOrganizationContact()
    {
        $userId  = factory(User::class)->create()->id;
        $OrganizationContactArray = [
            'organization_id' => factory(Organization::class)->create(['user_id'=>$userId])->id,
            'purpose' => factory(\App\CodeableConcepts::class)->create()->id,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,

        ];

        $this->post('/api/organizationcontact/', $OrganizationContactArray);

        $this->assertDatabaseHas('organization_contact',$OrganizationContactArray);
    }
    
    /* Test */
    public function testaddNewPatientCommunication()
    {
        $userId  = factory(User::class)->create()->id;
        $patientId  = factory(Patient::class)->create(['user_id'=>$userId])->id;
        $PatientCommunicationArray = [
            'patient_id' => $patientId,
            'language' =>  factory(\App\CodeableConcepts::class)->create()->id
        ];

        $this->post('/api/patientcommunication/', $PatientCommunicationArray);

        $this->assertDatabaseHas('patient_communications',$PatientCommunicationArray);
    }

    /* Test */
    public function testaddNewPractitioner()
    {
        $userTypeId  = factory(UserType::class)->create(['name'=>'practitioner'])->id;
        $userId  = factory(User::class)->create(['type'=>$userTypeId])->id;
        $PractitionerArray = [
            'user_id' => $userId,
            'name' => factory(HumanName::class)->create(['user_id'=>$userId])->id,
            'telcom' => factory(ContactPoint::class)->create(['user_id'=>$userId])->id,
            'address' => factory(Address::class)->create(['user_id'=>$userId])->id,
            'gender' =>  \Faker\Factory::create()->randomElement(['male', 'female', 'other', 'unknown']),
            'birth_date' => \Faker\Factory::create()->date(),
            'photo' =>  \Faker\Factory::create()->url

        ];

        $this->post('/api/practitioner/', $PractitionerArray);

        $this->assertDatabaseHas('practitioners',$PractitionerArray);
    }

    /* Test */
    public function testaddNewPractitionerQualification()
    {
        $userId  = factory(User::class)->create()->id;
        $practitionerId  = factory(Practitioner::class)->create(['user_id'=>$userId])->id;
        $PractitionerQualificationArray = [
            'practitioner_id' => $practitionerId,
            'name' => \Faker\Factory::create()->word,
            'period' => \Faker\Factory::create()->date(),
            'issuer' => factory(Organization::class)->create(['user_id'=>$userId])->id

        ];

        $this->post('/api/practitionerqualification/', $PractitionerQualificationArray);

        $this->assertDatabaseHas('practitioner_qualifications',$PractitionerQualificationArray);
    }

    /* Test */
    public function testaddNewPractitionerCommunication()
    {
        $practitionerId  = factory(Practitioner::class)->create()->id;
        $patientId  = factory(Patient::class)->create()->id;
        $PractitionerCommunicationArray = [
            'practitioner_id' => $practitionerId,
            'patient_id' => $patientId,
            'language' => factory(\App\CodeableConcepts::class)->create()->id,

        ];

        $this->post('/api/practitionercommunication/', $PractitionerCommunicationArray);

        $this->assertDatabaseHas('practitioner_communication',$PractitionerCommunicationArray);
    }

    /* Test */
    public function testaddNewPatientLink()
    {
        $patientId  = factory(Patient::class)->create()->id;
        $other  = factory(Patient::class)->create()->id;
        $PatientLinkArray = [
            'patient_id' => $patientId,
            'other' => $other,
            'type' => factory(\App\CodeableConcepts::class)->create()->id

            ];

        $this->post('/api/patientlink/', $PatientLinkArray);

        $this->assertDatabaseHas('patient_links',$PatientLinkArray);
    }

}
