<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Frete extends Model
{
    use Notifiable;

    protected $table = "tb_fretes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "origem_latitude",
        "origem_longitude",
        "destino_latitude",
        "destino_longitude",
        "data_agendamento",
        "tipo_veiculo",
        "data_frete",
        "valor",
        "usuario_id"
    ];
}
