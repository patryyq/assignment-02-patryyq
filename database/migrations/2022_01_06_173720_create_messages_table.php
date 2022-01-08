<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'to_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'from_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('message_content');
            $table->integer('read');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
