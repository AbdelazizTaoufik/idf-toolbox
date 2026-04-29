<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting_groups', function (Blueprint $table) {
            $table->string('weekday')->nullable()->after('description');
            $table->time('time')->nullable()->after('weekday');
            $table->boolean('is_public')->default(true)->after('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meeting_groups', function (Blueprint $table) {
            $table->dropColumn(['weekday', 'time', 'is_public']);
        });
    }
};
