<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyReportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('officer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->date('report_date');
            $table->enum('entry_type', ['arrival', 'departure']);
            $table->integer('total_count');
            $table->integer('male_count')->nullable();
            $table->integer('female_count')->nullable();
            $table->integer('asylum_male')->nullable();
            $table->integer('asylum_female')->nullable();
            $table->integer('deport_male')->nullable();
            $table->integer('deport_female')->nullable();
            $table->integer('return_male')->nullable();
            $table->integer('return_female')->nullable();
            $table->json('nationalities')->nullable(); // JSON to store nationality breakdown
            $table->enum('mode', ['flight', 'marine', 'land']);
            $table->string('flight_number')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->timestamps();

            $table->unique(['officer_id', 'location_id', 'report_date', 'entry_type'], 'unique_report');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
}
