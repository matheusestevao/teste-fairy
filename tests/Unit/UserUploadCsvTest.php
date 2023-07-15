<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserUploadCsvTest extends TestCase
{
    public function test_import_and_read_document(): void
    {
        $file = __DIR__ . '/../../storage/app/public/arquivo_entrada.csv';

        $response = $this->withoutMiddleware()->post('users/import', [
            'file' => new UploadedFile($file, 'arquivo_entrada.csv', 'text/csv', null, true)
        ]);

        $response->assertRedirectToRoute('users.import');
        $response->assertSessionDoesntHaveErrors('file');
    }
}
