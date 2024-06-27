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
        // Таблица историй статусов по моделям (без модели. участвует в событии смены статуса по моделям)
        Schema::create('log_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');  // id типа (модель)
            $table->unsignedBigInteger('item_id');  // id элемента модели
            $table->unsignedBigInteger('new_id');   // новый статус на дату создания (id)
            $table->unsignedBigInteger('old_id');   // старый статус на дату создания (id)
            $table->unsignedBigInteger('autor_id'); // автор записи (id)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_statuses');
    }
};
