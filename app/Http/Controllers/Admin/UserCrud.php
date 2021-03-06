<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCrudRequest;
use App\Models\Address;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

abstract class UserCrud extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        $this->crud->setModel(User::class);
        $this->crud->allowAccess('show');

        $this->mainSettingsSetup();
    }


    public function setupCreateOperation()
    {
        $this->addUserFields();
    }

    public function setupUpdateOperation()
    {
        $this->addUserFields();
    }

    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->unsetValidation();

        return $this->traitStore();
    }

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->unsetValidation();

        return $this->traitUpdate();
    }

    public function setupListOperation()
    {
        $this->crud->setColumns([
            [
                'name' => 'name',
                'label' => 'Имя',
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => 'Почта',
                'type' => 'text',
            ],
            [
                'name' => 'phone',
                'label' => 'Телефон',
                'type' => 'text',
            ],
            [
                'name' => 'working_days',
                'label' => 'Рабочие дни',
                'type' => 'model_function',
                'function_name' => 'workingDays',
                'limit' => 1000,
            ],
            [
                'name' => 'salary',
                'label' => 'Зарплата',
                'type' => 'number',
            ],
            [
                'name' => 'gym',
                'label' => 'Спортзал',
                'type' => 'model_function',
                'function_name' => 'gymAddress',
                'limit' => 1000,
            ],
        ]);
    }


    protected function addUserFields()
    {
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Имя',
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => 'Почта',
                'type' => 'text',
            ],
            [
                'name' => 'password',
                'label' => 'Пароль',
                'type' => 'text',
            ],
            [
                'name' => 'phone',
                'label' => 'Телефон',
                'type' => 'text',
            ],
            [
                'name' => 'working_day_type',
                'label' => 'Рабочие дни',
                'type' => 'select2_from_array',
                'options'     => [0 => "ПН, СР, ПТ", 1 => "ВТ, ЧТ, СБ"],
            ],
            [
                'name' => 'salary',
                'label' => 'Зарплата',
                'type' => 'number',
            ],
            [
                'name' => 'gym_id',
                'label' => 'Залы',
                'type' => 'select2_from_array',
                'options'     => Address::getGyms(),
            ],
            [
                // two interconnected entities
                'label' => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type' => 'checklist_dependency',
                'name' => ['roles', 'permissions'],
                'subfields' => [
                    'primary' => [
                        'label' => trans('backpack::permissionmanager.roles'),
                        'name' => 'roles', // the method that defines the relationship in your Model
                        'entity' => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => config('permission.models.role'), // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label' => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name' => 'permissions', // the method that defines the relationship in your Model
                        'entity' => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => config('permission.models.permission'), // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);
    }

    abstract function mainSettingsSetup();
}
