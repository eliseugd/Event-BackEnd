<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UsersEventView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW users_event_view
                        AS
                        SELECT ue.id as id_user_event,
                            ev.id as id_event,
                            ev.name as name_event,
                            ev.description,
                            ev.date,
                            u.id as id_user,
                            u.username,
                            u.name,
                            ue.participation_situation FROM user_event ue
                        LEFT JOIN user u ON u.id = ue.id_user
                        LEFT JOIN event ev ON ev.id = ue.id_event");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW users_event_view");
    }
}
