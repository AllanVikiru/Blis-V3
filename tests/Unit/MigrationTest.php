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
			"batch"=>'1,'

        );
    	$this->updatedmigrationData=array(
        
			"migration"=>'Sample updated String',
			"batch"=>1,

        );
	}

	public function testStoreMigration()
	{
		$response=$this->json('POST', '/api/migration',$this->migrationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("migration",$response->original);
	}

	public function testListMigration()
	{
		$response=$this->json('GET', '/api/migration');
		$response->assertStatus(200);
		
	}

	public function testShowMigration()
	{
		$this->json('POST', '/api/migration',$this->migrationData);
		$response=$this->json('GET', '/api/migration/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("migration",$response->original);
	}

	public function testUpdateMigration()
	{
		$this->json('POST', '/api/migration',$this->migrationData);
		$response=$this->json('PUT', '/api/migration/1',$this->updatedmigrationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("migration",$response->original);
	}

	public function testDeleteMigration()
	{
		$this->json('POST', '/api/migration',$this->migrationData);
		$response=$this->delete('/api/migration/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/migration/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteMigrationFail()
	{
		$response=$this->delete('/api/migration/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}