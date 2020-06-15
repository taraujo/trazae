<?php

namespace App\Http\Helpers;

use App\Http\Entities\Usuario;
use App\Http\Enumerations\TipoGrupo;

class SessionHelper
{
    /**
     * @param Usuario $usuario
     */
    public static function init(Usuario $usuario)
    {
        session(
            [
                'user' => $usuario
            ]
        );
    }

    /**
     * @param User $usuario
     */
    public static function destroy()
    {
        session()->flush();
    }

    /**
     * @return User
     */
    public static function getUser()
    {
        return session()->get('user');
    }

    /**
     * @return Cliente
     */
    public static function getCliente()
    {
        return session()->get('user')
            ->cliente()->first();
    }

    /**
     * @return User
     */
    public static function isSuperUser()
    {
        return session()->get('user')->grupo->getOriginal('nome') == TipoGrupo::SUPER;
    }

    /**
     * @return User
     */
    public static function isAdminUser()
    {
        return session()->get('user')->grupo->getOriginal('nome') == TipoGrupo::ADMIN;
    }

    /**
     * @return User
     */
    public static function isUser()
    {
        return session()->get('user')->grupo->getOriginal('nome') == TipoGrupo::USER;
    }
}
