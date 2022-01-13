<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Post;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class, 'post_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->text('comment_content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
