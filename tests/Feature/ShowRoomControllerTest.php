<?php

namespace Tests\Feature;

use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ShowRoomControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/rooms');

        $response->assertStatus(200)
        ->assertSeeText('Type')
        ->assertViewIs('rooms.index')
        ->assertViewHas('rooms');
    }

/**
 * Undocumented function
 *
 * @return void
 */
    public function testRoomParameter()
    {
        // Hoi khac so voi video
        $roomTypes = RoomType::factory(3)->create();
        $rooms = Room::factory(20)->create();
        $roomType = $roomTypes->random();
        $response = $this->get('/rooms/' . $roomType->id);


        $response->assertStatus(200)
        ->assertSeeText('Type')
        ->assertViewIs('rooms.index')
        ->assertViewHas('rooms')
        ->assertSeeText($roomType->name);
    }

    public function testUpdateFile(){
        $file = UploadedFile::fake()->image('sample.jpg');
        $roomType = RoomType::factory()->create();
        $response = $this->put("/room_types/{$roomType->id}", ['picture' => $file]);

        $response->assertStatus(302)->assertRedirect('/room_types');
        Storage::disk('public')->assertExists($file->hashName());
    }
}
