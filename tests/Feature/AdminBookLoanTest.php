<?php

namespace Tests\Feature;

use App\Models\AdminModule;
use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBookLoanTest extends TestCase
{
    use DatabaseTransactions;

    private function adminWithBookLoansAccess(): User
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->adminModules()->attach(AdminModule::where('key', AdminModule::BOOK_LOANS)->firstOrFail());

        return $admin;
    }

    public function test_admin_without_module_is_forbidden()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->get('/admin/book-loans')->assertForbidden();
        $this->actingAs($admin)->get('/admin/book-loans/history')->assertForbidden();
    }

    public function test_index_only_lists_users_with_open_loans_grouped_and_counted()
    {
        $admin = $this->adminWithBookLoansAccess();

        $borrower = User::factory()->create(['name' => 'Vielleiher']);
        $returnedOnly = User::factory()->create(['name' => 'Alles zurückgegeben']);

        BookLoan::create([
            'user_id' => $borrower->id,
            'title' => 'Buch A',
            'loan_photo_path' => 'book-loans/a.jpg',
            'loaned_at' => now()->subDays(5),
        ]);
        BookLoan::create([
            'user_id' => $borrower->id,
            'title' => 'Buch B',
            'loan_photo_path' => 'book-loans/b.jpg',
            'loaned_at' => now()->subDays(1),
        ]);
        BookLoan::create([
            'user_id' => $returnedOnly->id,
            'title' => 'Buch C',
            'loan_photo_path' => 'book-loans/c.jpg',
            'loaned_at' => now()->subDays(10),
            'return_photo_path' => 'book-loans/c-return.jpg',
            'returned_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/admin/book-loans');

        $response->assertOk();
        $response->assertSee('Vielleiher');
        $response->assertSee('2 Bücher');
        $response->assertDontSee('Alles zurückgegeben');
    }

    public function test_index_can_be_filtered_by_user_search()
    {
        $admin = $this->adminWithBookLoansAccess();

        $borrowerA = User::factory()->create(['name' => 'Vielleiher']);
        $borrowerB = User::factory()->create(['name' => 'Anderer Nutzer']);

        BookLoan::create([
            'user_id' => $borrowerA->id,
            'title' => 'Buch A',
            'loan_photo_path' => 'book-loans/a.jpg',
            'loaned_at' => now(),
        ]);
        BookLoan::create([
            'user_id' => $borrowerB->id,
            'title' => 'Buch B',
            'loan_photo_path' => 'book-loans/b.jpg',
            'loaned_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/admin/book-loans?search=Viel');

        $response->assertOk();
        $response->assertSee('Vielleiher');
        $response->assertDontSee('Anderer Nutzer');
    }

    public function test_history_only_shows_returned_loans_and_filters_by_user_and_date_ranges()
    {
        $admin = $this->adminWithBookLoansAccess();

        $userA = User::factory()->create(['name' => 'Nutzer A']);
        $userB = User::factory()->create(['name' => 'Nutzer B']);

        BookLoan::create([
            'user_id' => $userA->id,
            'title' => 'Offenes Buch',
            'loan_photo_path' => 'book-loans/open.jpg',
            'loaned_at' => now(),
        ]);

        $matching = BookLoan::create([
            'user_id' => $userA->id,
            'title' => 'Match Buch',
            'loan_photo_path' => 'book-loans/match.jpg',
            'loaned_at' => '2026-01-10',
            'return_photo_path' => 'book-loans/match-return.jpg',
            'returned_at' => '2026-01-20',
        ]);

        BookLoan::create([
            'user_id' => $userB->id,
            'title' => 'Anderer Nutzer',
            'loan_photo_path' => 'book-loans/other.jpg',
            'loaned_at' => '2026-01-10',
            'return_photo_path' => 'book-loans/other-return.jpg',
            'returned_at' => '2026-01-20',
        ]);

        $response = $this->actingAs($admin)->get('/admin/book-loans/history');
        $response->assertOk();
        $response->assertDontSee('Offenes Buch');
        $response->assertSee('Match Buch');
        $response->assertSee('Anderer Nutzer');

        $response = $this->actingAs($admin)->get('/admin/book-loans/history?' . http_build_query([
            'user' => $userA->name,
            'loaned_from' => '2026-01-01',
            'loaned_to' => '2026-01-15',
            'returned_from' => '2026-01-15',
            'returned_to' => '2026-01-25',
        ]));

        $response->assertOk();
        $response->assertSee('Match Buch');
        $response->assertDontSee('Anderer Nutzer');
    }

    public function test_admin_can_view_loan_photo_regardless_of_ownership()
    {
        Storage::fake('local');
        $admin = $this->adminWithBookLoansAccess();
        $borrower = User::factory()->create();

        $path = 'book-loans/photo.jpg';
        Storage::disk('local')->put($path, UploadedFile::fake()->image('photo.jpg')->get());

        $bookLoan = BookLoan::create([
            'user_id' => $borrower->id,
            'title' => 'Buch',
            'loan_photo_path' => $path,
            'loaned_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.book-loans.photo', [$bookLoan, 'loan']))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('admin.book-loans.photo', [$bookLoan, 'return']))
            ->assertNotFound();
    }
}
