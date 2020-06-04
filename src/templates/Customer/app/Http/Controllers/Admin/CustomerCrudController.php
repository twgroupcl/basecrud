<?php

namespace App\Http\Controllers\Admin;

use App\Cruds\Customers\CustomerCrudFields;
use App\Http\Requests\CustomerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Customer');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/customers');
        $this->crud->setEntityNameStrings('cliente', 'clientes');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'vat_id',
            'label' => 'RUT',
        ]);

        $this->crud->addColumn([
            'name' => 'business_name',
            'label' => 'Nombre',
        ]);

        $this->crud->addColumn([
            'name' => 'phone',
            'label' => 'Teléfono',
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Añadido El',
            'type' => 'date',
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setCreateContentClass('col-md-12 bold-labels');
        $this->crud->setValidation(CustomerRequest::class);

        $this->crud = (new CustomerCrudFields())->get($this->crud);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setUpdateContentClass('col-md-12 bold-labels');
        $this->setupCreateOperation();
    }
}
