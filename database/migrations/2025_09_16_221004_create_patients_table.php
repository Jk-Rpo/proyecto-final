<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('identity_type', 50);
            $table->string('identity', 50)->nullable();
            $table->string('first_name', 50);
            $table->string('second_name', 50)->nullable();
            $table->string('first_surname', 50);
            $table->string('second_surname', 50)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
