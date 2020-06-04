<?php

namespace App\Cruds\Customers;

use App\Models\Currency;
use App\Models\SiiActivity;

class CustomerCrudFields
{
    public function get($crud)
    {
        $crud->addField([
            'name' => 'vat_id',
            'label' => 'RUT',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            'tab' => 'General',
        ]);

        $crud->addField([
            'name' => 'business_name',
            'label' => 'Razón Social',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            'tab' => 'General',
        ]);

        $crud->addField([
            'name' => 'email',
            'label' => 'Email',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            'tab' => 'General',
        ]);

        $crud->addField([
            'name' => 'phone',
            'label' => 'Teléfono',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            'tab' => 'General',
        ]);

        $crud->addField([
            'name' => 'addresses',
            'label' => 'Direcciones',
            'type' => 'repeatable',
            'fields' => [
                [
                    'name' => 'address_type',
                    'type' => 'select2_from_array',
                    'label' => 'Tipo',
                    'options' => [
                        'shipping' => 'Envío',
                        'billing' => 'Facturación',
                    ],
                    'wrapper' => [
                        'class' => 'form-group col-md-3'
                    ],
                ],
                [
                    'name' => 'address1',
                    'label' => 'Dirección',
                    'wrapper' => [
                        'class' => 'form-group col-md-3'
                    ],
                ],
                [
                    'name' => 'address2',
                    'label' => 'Número',
                    'wrapper' => [
                        'class' => 'form-group col-md-3'
                    ],
                ],
                [
                    'name' => 'city',
                    'type' => 'select2_from_array',
                    'label' => 'Comuna',
                    'options' => [
                    ],
                    'wrapper' => [
                        'class' => 'form-group col-md-3'
                    ],
                ],
                [
                    'name' => 'vat_id',
                    'label' => 'RUT',
                    'wrapper' => [
                        'class' => 'form-group col-md-4'
                    ],
                ],
                [
                    'name' => 'first_name',
                    'label' => 'Nombre',
                    'wrapper' => [
                        'class' => 'form-group col-md-4'
                    ],
                ],
                [
                    'name' => 'last_name',
                    'label' => 'Apellido',
                    'wrapper' => [
                        'class' => 'form-group col-md-4'
                    ],
                ],
                [
                    'name' => 'email',
                    'label' => 'Email',
                    'type' => 'email',
                    'wrapper' => [
                        'class' => 'form-group col-md-4'
                    ],
                ],
                [
                    'name' => 'phone',
                    'label' => 'Teléfono',
                    'wrapper' => [
                        'class' => 'form-group col-md-4'
                    ],
                ],
                [
                    'name' => 'default_address',
                    'label' => 'Dirección principal',
                    'type' => 'checkbox',
                    'wrapper' => [
                        'class' => 'form-group col-md-4'
                    ],
                ],
            ],
            'tab' => 'Direcciones',
        ]);

        $crud->addField([
            'label' => 'Giros',
            'type' => 'select2_multiple',
            'name' => 'sii_activities',
            'entity' => 'sii_activities',
            'attribute' => 'activityDetail',
            'pivot' => true,
            'model' => SiiActivity::class,
            'tab' => 'Giros',
        ]);

        $crud->addField([
            'name' => 'notes',
            'label' => 'Notas',
            'type' => 'textarea',
            'tab' => 'Adicionales',
        ]);

        return $crud;
    }
}