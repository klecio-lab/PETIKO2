<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pedido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->text('nomeCliente');
            $table->text('cep');
            $table->text('rua');
            $table->text('complemento');
            $table->text('bairro');
            $table->text('cidade');
            $table->text('uf');
            $table->integer('IDpedido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
