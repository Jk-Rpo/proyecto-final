<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('patient_id');
            $table->text('observations')->nullable(); // observaciones
            $table->string('status', 20)->nullable(); // estado -> Pendiente, Enviado, En proceso, Recibido
            $table->string('priority', 20)->nullable(); // prioridad -> Alta, Media, Baja, Urgente
            $table->string('type_samples', 20)->nullable(); // tipo de muestras
            $table->string('institution', 255)->nullable(); // institucion que remite

            // datos relacionados con el paciente
            $table->string('consecutive', 30)->unique()->nullable(); // consecutivo
            $table->integer('quantity_samples')->nullable(); // cantidad de muestras

            //datos relacionados con un estudio especial
            $table->string('number_case', 50)->nullable(); // número de caso
            $table->string('type_study', 255)->nullable(); // tipo de estudio
            $table->json('color', 255)->nullable(); //coloración
            $table->string('quantity_plates')->nullable(); // cantidad de placas
            $table->date('departure_date')->nullable(); // Fecha de salida
            $table->string('delivered_to', 255)->nullable(); // Entregado a

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
        
        // relation many to many with cups
        Schema::create('reception_cups', function (Blueprint $table) {
            $table->unsignedBigInteger('cups_id');
            $table->unsignedBigInteger('reception_id');
            $table->string('quantity', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->foreign('reception_id')->references('id')->on('receptions')->onDelete('cascade');
            $table->foreign('cups_id')->references('id')->on('cups')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('reception_cups');
        Schema::dropIfExists('receptions');
    }
};
