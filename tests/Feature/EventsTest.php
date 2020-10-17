<?php

namespace Tests\Feature;

use App\Event;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    protected $user, $file;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        Storage::fake('local');
        $this->file = UploadedFile::fake()->create('image', 0, 'image/jpeg');
    }

    /**  @test  */
    public function a_list_of_events_can_be_fetched_for_the_authenticated_user()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $event = factory(Event::class)->create([
            'user_id' => $user->id
        ]);
        factory(Event::class)->create([
            'user_id' => $anotherUser->id
        ]);

        $response = $this->get('/api/events?api_token=' . $user->api_token);
        $response->assertJsonCount(1)
                ->assertJson([
                    'data' => [
                        [
                            'data' => [
                                 'event_id' => $event->id
                            ]
                        ]
                    ]
                ]);

    }

    /**  @test  */
    public function an_unauthenticated_user_should_redirect_to_login()
    {

        $response = $this->post('/api/events', array_merge($this->data(), ['api_token' => '']));

        $response->assertRedirect('/login');
        $this->assertCount(0, Event::all());
    }

   /**  @test  */
    public function an_authenticated_user_can_add_a_event()
    {

        $response = $this->post('/api/events', $this->data());

        $event = Event::first();

        $this->assertEquals('Test Name', $event->name);
        $this->assertEquals('Test description paragraph', $event->description);
        $this->assertEquals('John Doe', $event->beneficier);
        $this->assertEquals('10/27/1990', $event->date->format('m/d/Y'));
        $this->assertEquals('20', $event->amount);
//        Storage::disk('local')->assertExists('image.jpg');

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'event_id' => $event->id
            ],
            'links' => [
                'self' => $event->path()
            ]
        ]);


    }
    /**  @test  */
    public function fields_are_required()
    {
        collect(['name', 'date', 'beneficier', 'amount'])
            ->each(function ($field){
                $response = $this->post('/api/events',
                    array_merge($this->data(), [ $field => '']));

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Event::all());
            });
    }

    /**  @test  */
    public function dates_are_properly_stored()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/events', $this->data());

        $this->assertCount(1, Event::all());
        $this->assertInstanceOf(Carbon::class, Event::first()->date);
        $this->assertEquals('10/27/1990', Event::first()->date->format('m/d/Y'));

    }


    /**  @test  */
    public function a_event_can_be_retrieved()
    {
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);

        $response = $this->get('/api/events/' . $event->id . '?api_token=' . $this->user->api_token);

        $response->assertJson([
            'data' => [
                'event_id' => $event->id,
                'name' => $event->name,
                'description' => $event->description,
                'beneficier' => $event->beneficier,
                'date' => $event->date->format('m/d/Y'),
                'amount' => $event->amount,
                'image' => $event->image,
                'updated_at' => $event->updated_at->diffForHumans()
            ]
        ]);
    }

    /**  @test  */
    public function only_the_users_events_can_be_retrieved()
    {
        $event = factory(Event::class)->create(['user_id' => $this->user->id]);
        $anotherUser = factory(User::class)->create();

        $response = $this->get('/api/events/' . $event->id . '?api_token=' . $anotherUser->api_token);

        $response->assertStatus(403);
    }

    /**  @test  */
    public function a_event_can_be_patched()
    {
        $this->withoutExceptionHandling();
        $event = factory(Event::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->put('/api/events/' . $event->id, $this->data());

        $event = $event->fresh();

        $this->assertEquals('Test Name', $event->name);
        $this->assertEquals('Test description paragraph', $event->description);
        $this->assertEquals('John Doe', $event->beneficier);
        $this->assertEquals('10/27/1990', $event->date->format('m/d/Y'));
        $this->assertEquals('20', $event->amount);
//        $this->assertEquals('/uploads/images/default.jpg', $event->image);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'event_id' => $event->id
            ],
            'links' => [
                'self' => $event->path()
            ]
        ]);

    }

    /**  @test  */
    public function only_the_owner_of_the_event_can_patch_the_event()
    {
        $event = factory(Event::class)->create();
        $anotherUser = factory(User::class)->create();

        $response = $this->put('/api/events/' . $event->id,
            array_merge($this->data()), ['api_token' => $anotherUser->api_token]);

        $response->assertStatus(403);
    }

    /**  @test  */
    public function a_event_can_be_deleted()
    {
        $event = factory(Event::class)->create([
            'user_id'=> $this->user->id
        ]);

        $response = $this->delete('/api/events/' . $event->id, ['api_token' => $this->user->api_token]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertCount(0, Event::all());
    }

    /**  @test  */
    public function only_owner_can_delete_a_event()
    {
        $event = factory(Event::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete('/api/events/' . $event->id, ['api_token' => $this->user->api_token]);

        $response->assertStatus(403);
    }

    private function data()
    {
        return [
            'name' => 'Test Name',
            'description' => 'Test description paragraph',
            'beneficier' => 'John Doe',
            'date' => '10/27/1990',
            'amount' => '20',
            'image' => $this->file,
            'api_token' => $this->user->api_token,

        ];
    }
}
