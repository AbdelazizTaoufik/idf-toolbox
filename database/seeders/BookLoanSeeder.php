<?php

namespace Database\Seeders;

use App\Models\BookLoan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'Amina Khalil' => 'amina@test.com',
            'Yusuf Demir' => 'yusuf@test.com',
            'Sara Ahmadi' => 'sara@test.com',
            'Omar Farouk' => 'omar@test.com',
        ];

        $createdUsers = [];
        foreach ($users as $name => $email) {
            $createdUsers[$name] = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt('test'),
                    'is_admin' => false,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Amina: mehrere offene Ausleihen, um Gruppierung & Sortierung zu testen.
        $this->seedLoansForUser($createdUsers['Amina Khalil'], [
            ['title' => 'Die Reise zum verlorenen Schatz', 'loaned_at' => now()->subDays(3)],
            ['title' => 'Grundlagen der arabischen Sprache', 'loaned_at' => now()->subDays(10)],
        ]);

        // Yusuf: eine einzelne, schon länger offene Ausleihe (steht in der Übersicht ganz oben).
        $this->seedLoansForUser($createdUsers['Yusuf Demir'], [
            ['title' => 'Geschichten der Propheten', 'loaned_at' => now()->subDays(25)],
        ]);

        // Sara: nur bereits zurückgegebene Ausleihen -> taucht nur in der Historie auf, nicht in der Übersicht.
        $this->seedLoansForUser($createdUsers['Sara Ahmadi'], [
            [
                'title' => 'Einführung in die islamische Ethik',
                'loaned_at' => now()->subMonths(2),
                'returned_at' => now()->subMonths(2)->addDays(9),
            ],
            [
                'title' => 'Kinderbuch: Der kleine Muezzin',
                'loaned_at' => now()->subWeeks(6),
                'returned_at' => now()->subWeeks(5),
            ],
        ]);

        // Omar: Mix aus einer offenen und mehreren zurückgegebenen Ausleihen.
        $this->seedLoansForUser($createdUsers['Omar Farouk'], [
            ['title' => 'Sirah - Das Leben des Propheten', 'loaned_at' => now()->subDays(1)],
            [
                'title' => 'Arabische Kalligrafie für Einsteiger',
                'loaned_at' => now()->subMonths(1),
                'returned_at' => now()->subDays(20),
            ],
        ]);
    }

    /**
     * @param  array<int, array{title: string, loaned_at: \Illuminate\Support\Carbon, returned_at?: \Illuminate\Support\Carbon}>  $loans
     */
    private function seedLoansForUser(User $user, array $loans): void
    {
        if (BookLoan::where('user_id', $user->id)->exists()) {
            return;
        }

        foreach ($loans as $loan) {
            $isReturned = isset($loan['returned_at']);

            BookLoan::create([
                'user_id' => $user->id,
                'title' => $loan['title'],
                'loan_photo_path' => $this->makePlaceholderPhoto('Leihfoto: '.$loan['title']),
                'loaned_at' => $loan['loaned_at'],
                'return_photo_path' => $isReturned ? $this->makePlaceholderPhoto('Rückgabefoto: '.$loan['title']) : null,
                'returned_at' => $loan['returned_at'] ?? null,
            ]);
        }
    }

    private function makePlaceholderPhoto(string $label): string
    {
        $path = 'book-loans/'.Str::uuid()->toString().'.jpg';

        $image = imagecreatetruecolor(400, 300);
        $background = imagecolorallocate($image, random_int(60, 180), random_int(60, 180), random_int(60, 180));
        imagefill($image, 0, 0, $background);

        $textColor = imagecolorallocate($image, 255, 255, 255);
        $lines = explode("\n", wordwrap($label, 30, "\n", true));
        foreach ($lines as $i => $line) {
            imagestring($image, 3, 10, 10 + $i * 15, $line, $textColor);
        }

        ob_start();
        imagejpeg($image, null, 80);
        $contents = ob_get_clean();
        imagedestroy($image);

        Storage::disk('local')->put($path, $contents);

        return $path;
    }
}
