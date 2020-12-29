<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')
                ->references('id')
                ->on('users')
                /*->onDelete('restrict')
                ->onUpdate('restrict')*/;
            $table->string('title');
            $table->text('description');
            $table->boolean('done')->default(false);
            $table->string('attributedat')->nullable();
            $table->foreign('attributedat')
                ->references('email')
                ->on('users')
                /*->onDelete('restrict')
                ->onUpdate('restrict')*/;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
