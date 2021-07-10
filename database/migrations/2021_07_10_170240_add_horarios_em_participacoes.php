<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHorariosEmParticipacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participacoes', function (Blueprint $table) {
            $table->time('horarioInicio');
            $table->time('horarioFim');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participacoes', function (Blueprint $table) {
            $table->dropColumn(['horarioInicio', 'horarioFim']);
        });
    }
}
