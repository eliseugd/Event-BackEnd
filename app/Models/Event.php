<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $table = "event";

    protected $fillable = [
        'id',
		'name',
		'description',
		'date',
		'id_user_creator',
		'id_category',
        'status'
    ];

    protected function search($params, $fillable = null, $data_return = true) {

        if ($fillable == null) {
            $fillable = $this->fillable;
        }

        $events = Event::select($fillable)
                                            ->where( function ($query)
                                                use ($params) {

                                                if (isset($params->event) && !empty($params->event)) {
                                                    $query->fill($params->event);
                                                }

                                                if (isset($params->id_user) && !empty($params->id_user)) {
                                                    $query->where('id_user_creator', $params->id_user);
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

            $events = $events->orderBy('id', 'DESC');

            $events = $events->get();

        } else {
            $events = $events->count();
        }

        return $events;
    }
}
