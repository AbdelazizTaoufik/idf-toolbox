<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The admin modules a user can be granted access to. Kept here (rather than
     * a seeder) so that every environment, including production, ends up with
     * the exact same rows as soon as the migration runs.
     *
     * @var array<string, string>
     */
    private array $modules = [
        'users' => 'Benutzerverwaltung',
        'submissions' => 'Kummerkastenbeiträge',
        'meeting_groups' => 'Sitzungsgruppen',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_modules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->timestamps();
        });

        $now = now();
        DB::table('admin_modules')->insert(
            collect($this->modules)->map(fn ($label, $key) => [
                'key' => $key,
                'label' => $label,
                'created_at' => $now,
                'updated_at' => $now,
            ])->values()->all()
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_modules');
    }
};
