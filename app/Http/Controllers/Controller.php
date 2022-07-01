<?php

namespace App\Http\Controllers;

use App\Models\NotificationBanner;
use App\Services\ClientService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Json;
use Mail;
use Validator;
use View;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * Model class to be used by methods.
     *
     * @var Class
     */
    protected $model;

    /**
     * Number of database records to fetch.
     *
     * @var int
     */
    protected $limit = 15;

    /**
     * Detail of requested client browser, os and device etc.
     *
     * @var array
     */
    protected $client;

    /**
     * Sets model.
     *
     * @param object $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Returns model.
     *
     * @return object
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets limit.
     *
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Returns limit.
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Sets the requested client details.
     *
     * @param array $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * Returns the requested client details.
     *
     * @return array
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->setClient(ClientService::getDetails());

        View::share([
            'clientDetails' => $this->getClient(),
            'globalNotificationBanner' => NotificationBanner::getNotificationBanner(),
        ]);
    }

    /**
     * Returns the database entity.
     *
     * @param int $id
     *
     * @return array
     */
    protected function getEntity($id)
    {
        $model = $this->getModel();

        return $model::findOrFail($id);
    }

    /**
     * Returns the database entity.
     *
     * @param string $identifier
     * @param array $conditions
     *
     * @return array
     */
    protected function getEntityByIdentifier($identifier, Array $conditions = [])
    {
        $newConditions = [
            ['column' => 'identifier', 'condition' => '=', 'value' => $identifier],
        ];
        if (!empty($conditions)) {
            $newConditions = array_merge($newConditions, $conditions);
        }

        return $this->getEntityByFields($newConditions);
    }

    /**
     * Returns the database entity.
     *
     * @param array $conditions
     *
     * @return array
     */
    protected function getEntityByFields(Array $conditions = [])
    {
        $model = $this->getModel();
        $query = $this->applyQueryConditions($model, $conditions);

        return $query->firstOrFail();
    }

    /**
     * Returns database entities with limit and offset.
     *
     * @param int $offset
     * @param array $conditions
     * @param array $orderBy
     *
     * @return array
     */
    protected function getEntities($offset, Array $conditions = [], Array $orderBy = [])
    {
        $model = $this->getModel();
        $query = $this->applyQueryConditions($model, $conditions);

        return $this->applyOrderBy($query, $orderBy)
            ->take($this->getLimit())
            ->skip($offset)
            ->get();
    }

    /**
     * Returns database entities with pagination.
     *
     * @param array $conditions
     * @param array $orderBy
     *
     * @return array
     */
    protected function getEntitiesWithPagination(Array $conditions = [], Array $orderBy = [])
    {
        $model = $this->getModel();
        $query = $this->applyQueryConditions($model, $conditions);

        return $this->applyOrderBy($query, $orderBy)
            ->paginate($this->getLimit());
    }

    /**
     * Returns all database entities.
     *
     * @param array $conditions
     * @param array $orderBy
     *
     * @return array
     */
    protected function getAllEntities(Array $conditions = [], Array $orderBy = [])
    {
        $model = $this->getModel();
        $query = $this->applyQueryConditions($model, $conditions);

        return $this->applyOrderBy($query, $orderBy)
            ->get();
    }

    /**
     * Returns database entities count.
     *
     * @param array $conditions
     *
     * @return int
     */
    protected function getEntitiesCount(Array $conditions = [])
    {
        $model = $this->getModel();
        $query = $this->applyQueryConditions($model, $conditions);

        return $query->count();
    }

    /**
     * Applies conditions on model and returns it.
     *
     * @param object $model
     * @param array $conditions
     *
     * @return object
     */
    private function applyQueryConditions($model, Array $conditions)
    {
        foreach ($conditions as $condition) {
            $model = $model->where($condition['column'], $condition['condition'], $condition['value']);
        }

        return $model;
    }

    /**
     * Applies order on model and returns it.
     *
     * @param object $model
     * @param array $orderBy
     *
     * @return object
     */
    private function applyOrderBy($model, Array $orderBy)
    {
        if (!empty($orderBy)) {
            $model = $model->orderBy($orderBy['column'], $orderBy['type']);
        }

        return $model;
    }

    /**
     * Updates the database entity.
     *
     * @param array $data
     * @param int $id
     * @param redirect () $redirect
     *
     * @return array
     */
    protected function updateEntity(Array $data, $id, $redirect)
    {
        $entity = $this->getEntity($id);
        $entity->fill($data);
        $entity->setScenario('update');
        $validator = Validator::make($entity->toArray(), $entity->rules(), $entity->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                ->withInput();
        }
        $entity->update();

        return $entity;
    }

    /**
     * Validates the database entity.
     *
     * @param array $data
     * @param int $id
     *
     * @return response()
     */
    protected function validateEntityAjax(Array $data, $id)
    {
        $entity = $this->getEntity($id);
        $entity->fill($data);
        $entity->setScenario('update');

        $validator = Validator::make($entity->toArray(), $entity->rules(), $entity->messages());
        if ($validator->fails()) {
            return response()->json($validator->errors()->getMessages(), Response::HTTP_BAD_REQUEST);
        }

        return response()->json();
    }

    /**
     * Updates the database entity.
     *
     * @param array $data
     * @param array $conditions
     * @param redirect () $redirect
     *
     * @return array
     */
    protected function updateEntityByFields(Array $data, Array $conditions, $redirect)
    {
        $entity = $this->getEntityByFields($conditions);
        $entity->fill($data);
        $entity->setScenario('update');
        $validator = Validator::make($entity->toArray(), $entity->rules(), $entity->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                ->withInput();
        }
        $entity->update();

        return $entity;
    }

    /**
     * Deletes the database entity.
     *
     * @param int $id
     * @param boolean $forceDelete
     */
    protected function deleteEntity($id, $forceDelete = false)
    {
        $this->handleDeleteEntity($this->getEntity($id), $forceDelete);
    }

    /**
     * Deletes the database entity.
     *
     * @param array $conditions
     * @param boolean $forceDelete
     */
    protected function deleteEntityByFields(Array $conditions = [], $forceDelete = false)
    {
        $this->handleDeleteEntity($this->getEntityByFields($conditions), $forceDelete);
    }

    /**
     * Deletes or disables the database entity.
     *
     * @param array $entity
     * @param boolean $forceDelete
     */
    private function handleDeleteEntity($entity, $forceDelete)
    {
        if ($forceDelete === true) {
            $entity->forceDelete();
        } else {
            if (isset($entity->disabled)) {
                $entity->disabled = 1;
                $entity->update();
            } else {
                $entity->delete();
            }
        }
    }

    /**
     * Uploads a file and returns the file path.
     *
     * @param Illuminate\Http\Request::file() $file
     * @param string $destinationPath
     * @param string $fileName
     *
     * @return string
     */
    protected function uploadFile($file, $destinationPath = 'uploads', $fileName = null)
    {
        try {
            if ($fileName === null) {
                $fileName = mt_rand() . '-' . date('d-m-Y-H-i-s') . '.' . $file->getClientOriginalExtension();
            }
            $file->move($destinationPath, $fileName);

            return $destinationPath . '/' . $fileName;
        } catch (\Exception $e) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * Returns the validation for image file.
     *
     * @param array $data
     *
     * @return array
     */
    protected function validateImage($data)
    {
        return Validator::make(
            $data,
            ['file' => 'required|max:1000|validateImage'],
            ['required' => 'The :attribute is required.']
        );
    }

    /**
     * Sends an email.
     *
     * @param string $view
     * @param array $data
     * @param array $headers
     */
    public function sendEmail($view = "layouts.email", Array $data = [], Array $headers = [])
    {
        Mail::send($view, $data, function ($message) use ($headers) {
            $message->from($headers['from_email'], $headers['from_name']);
            $message->to($headers['to_email'], $headers['to_name'])->subject($headers['subject']);
        });
    }

    /**
     * Downloads the csv file.
     *
     * @param array $data
     * @param redirect () $redirect
     * @param mixed $conditions
     *
     * @return file
     */
    protected function downloadCSV($data, $redirect, $conditions = [])
    {
        $entity = $this->getModel();
        $validator = Validator::make($data, $entity->downloadCSVRules(), $entity->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                ->withInput();
        }
        $items = $this->getCSVEntities($data, $conditions);
        $fileName = $entity->getCSVFilePath();
        $handle = fopen($fileName, 'w+');
        foreach ($items as $item) {
            fputcsv($handle, $item);
        }
        fclose($handle);

        return response()->download($fileName);
    }

    /**
     * Returns the csv items array.
     *
     * @param array $data
     * @param mixed $conditions
     *
     * @return array
     */
    private function getCSVEntities(Array $data, $conditions)
    {
        $model = $this->getModel();
        $query = is_array($conditions) ? $this->applyQueryConditions($model, $conditions) : $model->getCSVBaseQuery();
        $array = [$model->getCSVHeader()];
        $fromDate = new \DateTime($data['from_date']);
        $toDate = new \DateTime($data['to_date']);
        $dates = [$fromDate->sub(new \DateInterval('P1D')), $toDate->add(new \DateInterval('P1D'))];
        $items = $query->whereBetween('created_at', $dates)->get();
        foreach ($items as $item) {
            $array[] = $item->buildCSVArray();
        }

        return $array;
    }


    /**
     * Stores a new entity in database.
     *
     * @param array $data
     * @param redirect () $redirect
     *
     * @return array
     */
    protected function storeEntity($data, $redirect)
    {
        $entity = $this->getModel();
        $entity->fill($data);
        $validator = Validator::make($entity->toArray(), $entity->rules(), $entity->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                ->withInput();
        }
        $entity->save();

        return $entity;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function isValid($data)
    {
        $entity = $this->getModel();
        $entity->fill($data);
        $validator = Validator::make($entity->toArray(), $entity->rules(), $entity->messages());

        return $validator->fails() ? false : true;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function getErrors($data)
    {
        $entity = $this->getModel();
        $entity->fill($data);
        $validator = Validator::make($entity->toArray(), $entity->rules(), $entity->messages());

        return $validator->getMessageBag()->toArray();
    }

    /**
     * @param $data
     * @return object
     */
    protected function save($data)
    {
        $entity = $this->getModel();
        $entity->fill($data);
        $entity->save();

        return $entity;
    }

    /**
     * @param $data
     * @param $id
     * @return array
     */
    protected function update($data, $id)
    {
        $entity = $this->getEntity($id);
        $entity->fill($data);
        $entity->setScenario('update');
        $entity->update();

        return $entity;
    }
}
