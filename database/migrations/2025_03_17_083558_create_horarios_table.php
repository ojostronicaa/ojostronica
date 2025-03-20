<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->time('hora_fin');
            $table->time('hora_inicio');
            $table->timestamps();
        });

        DB::table('horarios')->insert([
            ['hora_inicio'=>'08:30', 'hora_fin'=>'9:25'],
            ['hora_inicio'=>'9:25', 'hora_fin'=>'10:20'],
            ['hora_inicio'=>'10:20', 'hora_fin'=>'11:15'],
            ['hora_inicio'=>'11:45', 'hora_fin'=>'12:40'],
            ['hora_inicio'=>'12:40', 'hora_fin'=>'13:35'],
            ['hora_inicio'=>'13:35', 'hora_fin'=>'14:30']
        ]);

    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
