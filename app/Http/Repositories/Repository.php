<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class Repository implements IRepository
{
    protected $entity;

    /**
     * Service constructor.
     * @param Model $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param array $data
     * @return Model
     * @throws \Exception
     */
    public function create(array $data)
    {
        $model = $this->getEntity();
        $model->fill(array_intersect_key($data, array_flip($model->getFillable())));
        return $this->insert($model);
    }

    /**
     * @param Model $entity
     * @return Model
     * @throws \Exception
     */
    public function insert($entity)
    {
        \DB::beginTransaction();
        try {
            $entity->save();
            \DB::commit();
            return $entity;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        return null;
    }

    /**
     * @param Model $entity
     * @return Model
     * @throws \Exception
     */
    public function update($entity)
    {
        \DB::beginTransaction();
        try {
            $entity->update();
            \DB::commit();
            return $entity;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        return null;
    }

    /**
     * @param Model $entity
     * @return bool
     * @throws \Exception
     * @internal param Model $id
     */
    public function delete($entity)
    {
        if (!is_object($entity)) {
            $entity = $this->findById($entity);
        }
        \DB::beginTransaction();
        try {
            $entity->delete();
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        if (is_array($id)) {
            return $this->entity->whereIn('id', $id)->get();
        }
        return $this->entity->find($id);
    }

    /**
     * @param $column
     * @return mixed
     */
    public function max($column)
    {
        return $this->entity->max($column);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->entity->all();
    }

    /**
     * Exemplo
     * $response = $this->service->findBy(
     * [
     *      [ 'phone', 'like', '%141%' ]
     * ],
     * [
     *      'orderBy' => 'email',
     *      'type' => 'DESC',
     *      'limit' => 1
     * ]
     * );
     *
     * @param null $criteria
     * @param null $param
     * @return mixed
     */
    public function findBy($criteria = null, $param = null)
    {
        if ($criteria) {
            $result = $this->entity->where($criteria);
            //Verificar Order By
            if (isset($param['orderBy'])) {
                $type = (isset($param['type'])) ? $param['type'] : 'ASC';
                $result->orderBy($param['orderBy'], $type);
            }
            //Verifica LIMIT
            if (isset($param['limit'])) {
                $result->limit($param['limit']);
            }
            //Verifica WhereIn
            if (isset($param['whereIn'])) {
                $result->WhereIn($param['whereIn'][0], $param['whereIn'][1]);
            }
            $result = $result->get();
        } else {
            $result = $this->entity->orderBy($param['orderBy'], $param['type'])->limit($param['limit'])->get();
        }
        return $result;
    }

    /**
     * @param $criteria
     * @param $param
     */
    public function findBySql($criteria = null, $param = null)
    {
        if ($criteria) {
            $result = $this->entity->where($criteria);
            //Verificar Order By
            if (isset($param['orderBy'])) {
                $type = (isset($param['type'])) ? $param['type'] : 'ASC';
                $result->orderBy($param['orderBy'], $type);
            }
            //Verifica LIMIT
            if (isset($param['limit'])) {
                $result->limit($param['limit']);
            }
            //Verifica WhereIn
            if (isset($param['whereIn'])) {
                $result->WhereIn($param['whereIn'][0], $param['whereIn'][1]);
            }
            $result = $result->toSql();
        } else {
            $result = $this->entity->orderBy($param['orderBy'], $param['type'])->limit($param['limit'])->toSql();
        }
        return $result;
    }

    /**
     * @param $pagination
     * @param null $criteria
     * @param null $param
     * @return mixed
     */
    public function paginate($pagination, $criteria = null, $param = null)
    {
        $param = $this->formatParams($param);

        if ($criteria) {
            $result = $this->entity->where($criteria)
                ->orderBy($param['orderBy'], $param['type'])
                ->paginate($pagination);
        } else {
            $result = $this->entity->orderBy($param['orderBy'], $param['type'])->paginate($pagination);
        }

        return $result;
    }

    private function formatParams($param)
    {
        if (!isset($param['orderBy'])) {
            $param['orderBy'] = 'id';
        }

        if (!isset($param['type'])) {
            $param['type'] = 'ASC';
        }
        return $param;
    }

    /**
     * Retorna uma instancia do Model setado no repositório
     *
     * @return Model
     */
    private function getEntity()
    {
        $model = get_class($this->entity);
        return new $model();
    }
}
