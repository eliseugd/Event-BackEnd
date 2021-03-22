<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersEventView extends Model
{
    use HasFactory;

    public $table = "users_event_view";

    protected $fillable = [
        'id_user_event',
		'id_event',
        'name_event',
        'description',
        'date',
		'id_user',
        'username',
        'name',
		'participation_situation',
    ];

    protected function search($params, $fillable = null, $data_return = true) {

        if ($fillable == null) {
            $fillable = $this->fillable;
        }

        $events = UsersEventView::select($fillable)
                                            ->where( function ($query)
                                                use ($params) {

                                                if (isset($params->id_user) && !empty($params->id_user)) {
                                                    $query->where('id_user', $params->id_user);
                                                }

                                                if (isset($params->id_event) && !empty($params->id_event)) {
                                                    $query->where('id_event', $params->id_event);
                                                }

                                                if (isset($params->participation_situation) && !empty($params->participation_situation)) {
                                                    $query->where('participation_situation', $params->participation_situation);
                                                }

                                                return $query;

                                                });
                                                
        /** se for para retornar registros */
        if ($data_return) {

            if (isset($params['limit']) && isset($params['offset'])) {
                $events = $events->limit($params['limit'])
                                    ->offset($params['offset']);
            } else if(isset($params['limit'])) {
                $events = $events->limit($params['limit']);
            }

            $events = $events->orderBy('date', 'ASC');

            $events = $events->get();

        } else {
            $events = $events->count();
        }

        return $events;
    }
}

