<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\Repository;

/**
 * Class Service
 *
 * @package App\Http\Services
 */
abstract class Service extends Application implements IService
{

    protected $repository;

    /**
     * Service constructor.
     *
     * @internal param $repository
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function create(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param Model $entity
     * @return Model
     * @throws Exception
     */
    public function insert($entity)
    {
        try {
            return $this->repository->insert($entity);
        } catch (\Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param Model $entity
     * @return Model|null
     * @throws Exception
     */
    public function update($entity)
    {
        try {
            return $this->repository->update($entity);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     * Atualiza uma array de dados de acordo com o id do Model informado
     *
     * @param int $id
     * @param array $dados
     * @throws Exception
     * @return Model
     */
    public function merge($id, array $dados)
    {
        try {
            $model = $this->findById($id);
            $model->fill(array_intersect_key($dados, array_flip($model->getFillable())));
            return $this->update($model);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param Model $entity
     * @return null
     * @throws Exception
     */
    public function delete($entity)
    {
        try {
            return $this->repository->delete($entity);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @return null
     * @throws Exception
     */
    public function all()
    {
        try {
            return $this->repository->findAll();
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param
     *            $id
     * @return Model|null
     * @throws Exception
     */
    public function find($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param
     *            $id
     * @return Model|null
     * @throws Exception
     */
    public function findById($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param
     *            $id
     * @return Model|null
     * @throws Exception
     */
    public function max($column)
    {
        try {
            return $this->repository->max($column);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param array $criteria
     * @param null $param
     * @return null
     * @throws Exception
     */
    public function findBy(array $criteria, $param = null)
    {
        try {
            return $this->repository->findBy($criteria, $param);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     *
     * @param int $pagination
     * @param null $criteria
     * @param null $param
     * @return null
     * @throws Exception
     */
    public function paginate($pagination = 30, $criteria = null, $param = null)
    {
        try {
            return $this->repository->paginate($pagination, $criteria, $param);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     * Retorna a instancia do service em um singleton
     * registrado no container do laravel
     *
     * (Overriding Container::make)
     *
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     */
    public function make($abstract, array $parameters = [])
    {
        return parent::make($abstract, $parameters);
    }
}
