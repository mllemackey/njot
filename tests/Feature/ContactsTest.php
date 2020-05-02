<?php

namespace Tests\Feature;

use App\Contact;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**  @test  */
    public function a_list_of_contacts_can_be_fetched_for_the_authenticated_user()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $contact = factory(Contact::class)->create([
            'user_id' => $user->id
        ]);
        factory(Contact::class)->create([
            'user_id' => $anotherUser->id
        ]);

        $response = $this->get('/api/contacts?api_token=' . $user->api_token);
        $response->assertJsonCount(1)
                ->assertJson([ 'data' => [
                    [ 'contact_id' => $contact->id ]
                ]
                ]);

    }

    /**  @test  */
    public function an_unauthenticated_user_should_redirect_to_login()
    {
        $data2 = [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '10/27/1990',
            'company' => 'ABC String',
            'api_token' => ''
        ];

        $response = $this->post('/api/contacts', $data2);

        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

   /**  @test  */
    public function an_authenticated_user_can_add_a_contact()
    {
        $this->post('/api/contacts', $this->data());

        $contact = Contact::first();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('10/27/1990', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);

    }
    /**  @test  */
    public function fields_are_required()
    {
        collect(['name', 'email', 'birthday', 'company'])
            ->each(function ($field){
                $response = $this->post('/api/contacts',
                    array_merge($this->data(), [ $field => '']));

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Contact::all());
            });
    }

    /**  @test  */
    public function email_must_be_a_valid_email()
    {
        $response = $this->post('/api/contacts',
            array_merge($this->data(), [ 'email' => 'Torima']));

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /**  @test  */
    public function birthdays_are_properly_stored()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/contacts', $this->data());

        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('10/27/1990', Contact::first()->birthday->format('m/d/Y'));

    }


    /**  @test  */
    public function a_contact_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'company' => $contact->company,
                'updated_at' => $contact->updated_at->diffForHumans()
            ]
        ]);
    }

    /**  @test  */
    public function only_the_users_contacts_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $anotherUser = factory(User::class)->create();

        $response = $this->get('/api/contacts/' . $contact->id . '?api_token=' . $anotherUser->api_token);

        $response->assertStatus(403);
    }

    /**  @test  */
    public function a_contact_can_be_patched()
    {
        $contact = factory(Contact::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->put('/api/contacts/' . $contact->id, $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('10/27/1990', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);

    }

    /**  @test  */
    public function only_the_owner_of_the_contact_can_patch_the_contact()
    {
        $contact = factory(Contact::class)->create();
        $anotherUser = factory(User::class)->create();

        $response = $this->put('/api/contacts/' . $contact->id,
            array_merge($this->data()), ['api_token' => $anotherUser->api_token]);

        $response->assertStatus(403);
    }

    /**  @test  */
    public function a_contact_can_be_deleted()
    {
        $contact = factory(Contact::class)->create([
            'user_id'=> $this->user->id
        ]);

        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $this->user->api_token]);

        $this->assertCount(0, Contact::all());
    }

    /**  @test  */
    public function only_owner_can_delete_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/contacts/' . $contact->id, ['api_token' => $this->user->api_token]);

        $response->assertStatus(403);
    }

    private function data()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '10/27/1990',
            'company' => 'ABC String',
            'api_token' => $this->user->api_token
        ];
    }
}
