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
        // Таблица событий
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->date('day');                        // Дата ДД.ММ.ГГГГ
            $table->time('start')->nullable();          // Время начала H:m
            $table->time('end')->nullable();            // Время завершения H:m
            $table->unsignedBigInteger('type_id');      // Тип привязанной модели - tasks,users,notes etc...
            $table->unsignedBigInteger('item_id');      // id привязанной модели
            $table->unsignedBigInteger('autor_id');     // id автора
            $table->string('title')->nullable();        // заголовок/название
            $table->text('content')->nullable();        // описание
            $table->unsignedBigInteger('status_id');    // id статуса события (Завершено, Перенесено, В процессе)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
