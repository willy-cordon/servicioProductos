<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testStore()
    {
        $this->post('accounts', ['name' => 'Name'])
            ->assertRedirect('/');
        $this->assertDatabaseHas('accounts', ['name' => 'Name']);
    }

    public function testDestroy()
    {
        $account = Account::factory()->create();
        $this->assertDatabaseHas('accounts', ['id' => $account->id,'deleted_at'=>null]);
//            $this->assertDatabaseMissing('accounts',['name'=>$account->name]);
    }
}
