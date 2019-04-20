<?php

namespace Tests\Feature;

use App\Media;
use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function aMediaFileCanBeCreated()
    {
        $media = factory(Media::class)->create();

        $this->assertNotEquals($media, null);
    }

    /**
     * @test
     *
     * @return void
     */
    public function aMediaFileHasAName()
    {
        $media = factory(Media::class)->create(['name' => 'Jumping rabbit']);

        $this->assertEquals($media->name, 'Jumping rabbit');
    }

    /**
     * @test
     *
     * @return void
     */
    public function aMediaFileHasADescription()
    {
        $media = factory(Media::class)->create(['description' => 'Jumping rabbits are very cute']);

        $this->assertEquals($media->description, 'Jumping rabbits are very cute');
    }

    /**
     * @test
     *
     * @return void
     */
    public function multipleMediaFilesCanBeUploadedSimultaneously()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        Storage::fake();

        $response = $this->json('POST', route('media.store'), [ 'uploadedFiles' => [
                UploadedFile::fake()->image('photo1.jpg'),
                UploadedFile::fake()->image('photo2.jpg')
            ]
        ]);

        foreach (Media::all() as $media) {
            Storage::assertExists($media->filepath);
        }

        Storage::assertMissing("differentfolder".$media->filepath);
    }

    /**
     * @test
     *
     * @return void
     */
    public function anIndexOfAllMediaFilesIsPresented()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        Storage::fake();

        $response = $this->json('POST', route('media.store'), [
            'uploadedFiles' => [
                UploadedFile::fake()->image('photo1.jpg'),
                UploadedFile::fake()->image('photo2.jpg')
            ]
        ]);

        foreach (Media::all() as $media) {
            Storage::assertExists($media->filepath);
        }

        $response = $this->get(route('media.index'))->assertSee($media->filepath);
    }
}
