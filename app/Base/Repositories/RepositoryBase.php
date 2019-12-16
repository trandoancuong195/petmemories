<?php

namespace App\Base\Repositories;

use App\Helpers\Query\Query;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class RepositoryBase
{
    /**
     * Retrieve list of all objects in model.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function all($request)
    {
        $model       = $this->model;
        $columns     = $model::getColumns();
        $collection  = $this->collection;
        $transformer = $this->transformer;

        $offset = 0;
        $limit  = 20;
        if ($request->input('offset')) {
            $offset = (int) $request->input('offset');
        }
        if ($request->input('limit')) {
            $limit = (int) $request->input('limit');
        }

        $collection
            ->setLimit($limit)
            ->setOffset($offset);

        // parameters from query string
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $columns)) {
                // retrieve collection
                if ($whereConditions = Query::getQueryConditions($key, $value)) {
                    foreach ($whereConditions as $whereCondition) {
                        // wrong operator
                        if ($whereCondition === false) {
                            break;
                        }

                        list($column, $operator, $sqlValue) = $whereCondition;
                        switch ($operator) {
                            case 'IS NOT NULL':
                                call_user_func_array([$collection->getDb(), 'whereNotNull'], [$column]);
                                break;
                            case 'IS NULL':
                                call_user_func_array([$collection->getDb(), 'whereNull'], [$column]);
                                break;
                            case 'IN':
                                call_user_func_array(
                                    [$collection->getDb(), 'whereIn'],
                                    [$column, explode(',', $sqlValue)]
                                );
                                break;
                            case '=':
                                call_user_func_array(
                                    [$collection, 'filterBy'],
                                    [$column, $sqlValue]
                                );
                                break;
                            case 'NOT IN':
                                call_user_func_array(
                                    [$collection->getDb(), 'whereNotIn'],
                                    [$column, explode(',', $sqlValue)]
                                );
                                break;
                            case 'LIKE':
                                call_user_func_array(
                                    [$collection->getDb(), 'where'],
                                    [$column, $operator, '%' . $sqlValue . '%']
                                );
                                break;
                            default:
                                call_user_func_array([$collection->getDb(), 'where'], $whereCondition);
                                break;
                        }
                    }
                }
            }
        }

        $orders = '';
        // sorting
        //check if have collumn created_at
        if ($request->input('order_by')) {
            $orders = $request->input('order_by');
        } else {
            $orders = 'created_at|desc';
        }

        if (is_array($orders)) {
            foreach ($orders as $order) {
                list($column, $direction) = explode('|', $order);
                $collection->orderBy($column, $direction);
            }
        } else {
            if (is_array(explode('|', $orders)) && count(explode('|', $orders)) > 1) {
                list($column, $direction) = explode('|', $orders);
                $collection->orderBy($column, $direction);
            }
        }

        $resource       = new Collection($collection->getItems(), $transformer);
        $data           = $this->fractal->createData($resource)->toArray();
        $data['paging'] = $collection->getPaging();

        return $data;
    }

    /**
     * Retrieve object with id.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function find($id)
    {
        $model       = $this->model;
        $transformer = $this->transformer;
        $object      = $model::findOrFail($id);

        return $this->fractal->createData(new Item($object, $transformer))->toArray();
    }
}
