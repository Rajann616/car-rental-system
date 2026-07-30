<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerDocumentTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::create([
            'name' => 'Document User',
            'email' => 'docuser@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_can_view_document_upload_page()
    {
        $response = $this->actingAs($this->customer)->get('/customer/documents');
        $response->assertStatus(200);
        $response->assertSee('ID Verification');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_can_upload_valid_driving_license_file()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('license.jpg', 500, 'image/jpeg');

        $response = $this->actingAs($this->customer)->post('/customer/documents', [
            'type' => 'Driving License',
            'document_file' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('documents', [
            'user_id' => $this->customer->id,
            'type' => 'Driving License',
            'status' => 'Pending',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function customer_cannot_upload_invalid_document_type()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('doc.pdf', 100, 'application/pdf');

        $response = $this->actingAs($this->customer)->post('/customer/documents', [
            'type' => 'Invalid Type',
            'document_file' => $file,
        ]);

        $response->assertSessionHasErrors(['type']);
    }
}
