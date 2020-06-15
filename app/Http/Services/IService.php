<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * Interface ServiceBaseInterface
 *
 * @package App\Http\Services\Admin
 */
interface IService
{

    /**
     * insere um registro na base de dados
     *
     * @param Model $entity
     * @return Model|mixed
     */
    public function insert($entity);

    /**
     * Atualiza um registro
     *
     * @param Model $entity
     * @return Model|mixed
     */
    public function update($entity);

    /**
     * Remove um registro da base de dados
     *
     * @param Model $entity
     * @return mixed
     */
    public function delete($entity);

    /**
     * Responsável por trazer todos os registros de uma entidade
     *
     * @return mixed
     */
    public function all();

    /**
     * Busca um registro na base de dados de acordo com as condições passadas.
     *
     * @param array $criteria
     * @param null $param
     * @return mixed
     *
     */
    public function findBy(array $criteria, $param = null);


    /**
     * Retorna a paginação da entidade
     *
     * @param int $pagination
     * @param null $criteria
     * @param null $param
     * @return mixed
     *
     *
     */
    public function paginate($pagination = 30, $criteria = null, $param = null);
}
