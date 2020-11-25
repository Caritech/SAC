<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Route::get('dev/convert_swno','Dev\DevController@convert_swno');

Route::get('dev/db',function(){
  $table_name = 'dev_table';
  $table_name2 = 'dev_table_foreign';

  Schema::create($table_name2, function (Blueprint $table) {
      $table->increments('id');
      $table->bigIncrements('id');
    });

  if (Schema::hasTable($table_name)) {
    //dd('TABLE EXISTS');
  }else{
    Schema::create($table_name, function (Blueprint $table) {
      $table->bigIncrements('id');
    });
  }

  /*
    $table->foreign('user_id')->references('id')->on('users');
    $table->dropForeign('posts_user_id_foreign');

    $table->increments('id');

    $table->integer('votes');
    $table->tinyInteger('votes'); for onoff
    $table->bigInteger('votes');
    $table->decimal('amount', 8, 2);

    $table->string('description');
    $table->longText('description');

    $table->date('created_at');
    $table->dateTime('created_at');
    $table->time('sunrise');




    ->comment('my comment')//for next developer/admin use
    ->default($value) // prefill value/preselect
  */

  Schema::table($table_name, function (Blueprint $table) {
    $table->string('email');
    $table->string('email', 250)->change();
    $table->dropColumn('email');
    //$table->string('email')->nullable();
  });

  dd('DONE');


});

Route::get('/dev/getFileChange', 'Dev\DevController@ajax_getFileChange');
Route::get('/dev/html_components', 'Dev\DevController@html_components');

Route::get('/dev/home', 'Dev\DevController@index')->name('dev_home');
