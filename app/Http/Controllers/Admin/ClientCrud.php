<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCrudRequest;
use App\Models\Address;
use App\Models\Client;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

abstract class ClientCrud extends CrudController
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
        $this->crud->setModel(Client::class);
        $this->crud->allowAccess('show');
        $this->crud->setEntityNameStrings('Клиент', 'Клиенты');
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
                'name' => 'phone',
                'label' => 'Телефон',
                'type' => 'text',
            ],
            [
                'name' => 'payed',
                'label' => 'Последняя оплата',
                'type' => 'datetime',
            ],
            [
                'name' => 'next_payment',
                'label' => 'Следующая оплата',
                'type' => 'datetime',
            ],
        ]);
        $this->fieldsSetup();
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
                'name' => 'phone',
                'label' => 'Телефон',
                'type' => 'text',
            ],
            [
                'name' => 'password',
                'label' => 'Телефон',
                'type' => 'text',
            ],
            [
                'name'      => 'gym_id',
                'label'     => 'Зал',
                'type'      => 'select2_from_array',
                'options'   => Address::getGyms(),
            ],
            [
                'name' => 'trainer_id',
                'label' => 'Тренер',
                'type' => 'select2_from_array',
                'options'   => Address::getGyms(),
            ],
            [
                'name' => 'payed',
                'label' => 'Последняя оплата',
                'type' => 'datetime',
            ],
            [
                'name' => 'next_payment',
                'label' => 'Следующая оплата',
                'type' => 'datetime',
            ],
        ]);
    }

    abstract public function mainSettingsSetup();

    abstract public function fieldsSetup();
}
