<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MigrationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->migrationData=array(
        
			"migration"=>'Sample String',

        );
    	$this->updatedmigrationData=array(
        
			"migration"=>'Sample updated String',

        );
	}

	public function testStoreMigration()
	{
		$response=$this->json('POST', '/api/migration',$this->migrationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListMigration()
	{
		$response=$this->json('GET', '/api/migration');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowMigration()
	{
		$this->json('POST', '/api/migration',$this->migrationData);
		$response=$this->json('GET', '/api/migration/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateMigration()
	{
		$this->json('POST', '/api/migration',$this->updatedmigrationData);
		$response=$this->json('PUT', '/api/migration');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteMigration()
	{
		$this->json('POST', '/api/migration',$this->migrationData);
		$response=$this->delete('/api/migration/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}