<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

class CreateFollowersTable extends Migration
{
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'followed_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('followed_at');

            $table->unique(['followed_user_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('followers');
    }
}
