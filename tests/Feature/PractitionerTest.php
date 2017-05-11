<?php

namespace Tests\Feature;


use App\DB\Practitioner;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PractitionerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
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
}
