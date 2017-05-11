<?php

namespace Tests\Feature;


use App\DB\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */#

    public function setVariables()
    {
    	$this->userData = array
    	(
    		'type' => factory(UserType::class)->create()->id,
            'email' => 'test@example.com',
            'password' => '1234678'
    		);
    	$this->userDataUpdate = array 
    	(
    		'email' => 'testUser@example.com',
            'password' => '87654321'
    		
    		);
    }
    public function testUserStore()
    {
        

        $this->post('/user/', $this->userData);

        $this->assertDatabaseHas('users',$this->userData);
    }
    public function testUserUpdate()
    {
        $user = factory(user::class,3)->make();
        $this->post('api/user',$user);

        $userSaved = User::orderBy('id','desc')->take(1)->get()->toArray();#
        $userUpdated = $this->update(
        	$this->userDataUpdate,$userSaved[0]['id']);
        
        $this->put('api/user',$userUpdated);

    }

    public function testUserDelete()
    {
    	factory(User::class,3)->make();
    	$user = User::orderBy('id','desc')->take(1)->get()->toArray();
    	$userDeleted = $user->delete('api/user',$user[0]['id']);

    }

    public function testShowUser()
    {
    	$users = factory (User::class,3)->make();

    	$user = $this->json('GET','api/user',$users);
    	
    	$array = json_decode($user);
    	
    	$result = false;
    	
    	if($array[0]->id == 1)
    	{
    		$result =true;
    	}
    	$this->assertEquals(true, $result);
    }
}
