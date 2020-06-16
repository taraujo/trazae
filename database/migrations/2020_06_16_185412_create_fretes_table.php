<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFretesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_fretes', function (Blueprint $table) {
            $table->id();
            $table->double("origem_latitude");
            $table->double("origem_longitude");
            $table->double("destino_latitude");
            $table->double("destino_longitude");
            $table->double("distancia");
            $table->date("data_frete")->default('now()');
            $table->integer("tipo_veiculo");
            $table->decimal('valor', 10, 2);
            $table->integer('usuario_id');
            $table->foreign('usuario_id')
                ->references('id')->on("tb_usuarios");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_fretes');
    }
}
