<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("plane_id");
            $table->unsignedBigInteger("airport_id");
            $table->unsignedBigInteger("airport_destination_id");
            $table->dateTime("destination");
            $table->dateTime("arrival");
            $table->foreign("plane_id")->references("id")->on("planes")->onDelete("cascade");
            $table->foreign("airport_id")->references("id")->on("airports")->onDelete("cascade");
            $table->foreign("airport_destination_id")->references("id")->on("airports")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
