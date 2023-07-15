<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserUploadCsvTest extends TestCase
{
    public function create_user(): void
    {
        $user = User::factory()->create([
            'hire_date' => '2000-01-01'
        ]);
        $this->actingAs($user);
    }

    public function test_import_and_read_document(): void
    {
        $file = __DIR__ . '/../../storage/app/public/arquivo_entrada.csv';

        $this->create_user();

        $response = $this->withoutMiddleware()->post('users/import', [
            'file' => new UploadedFile($file, 'arquivo_entrada.csv', 'text/csv', null, true)
        ]);

        $response->assertRedirectToRoute('users.import');
        $response->assertSessionDoesntHaveErrors('file');
    }
}
