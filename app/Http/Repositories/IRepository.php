<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * @package App\Http\Repositories\Base
 */
interface IRepository
{

    /**
     * insere um registro na base de dados
     *
     * @param Model $entity
     * @return Model
     */
    public function insert($entity);
    /**
     * Atualiza um registro
     *
     * @param Model $entity
     * @return Model
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
    public function findAll();

    /**
     * Retorna um registro de uma entidade recebendo o id como parêmetro
     *
     * @param $id
     * @return Model
     */
    public function findById($id);

    /**
     * Busca um registro na base de dados de acordo com as condições passadas.
     *
     * @param null $criteria
     * @param null $param
     * @return mixed
     */
    public function findBy($criteria = null, $param = null);

    /**
     * Retorna a paginação da entidade
     *
     * @param $pagination
     * @param null $criteria
     * @param null $param
     * @return mixed
     */
    public function paginate($pagination, $criteria = null, $param = null);
}
