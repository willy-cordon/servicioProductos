<?php

return [
    'userManagement' => [
        'title'          => 'Usuarios',
        'title_singular' => 'Usuario',
    ],
    'permission'     => [
        'title'          => 'Permisos',
        'title_singular' => 'Permiso',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Titulo',
            'title_helper'      => '',
            'created_at'        => 'Creado el',
            'created_at_helper' => '',
            'updated_at'        => 'Actualizado el',
            'updated_at_helper' => '',
            'deleted_at'        => 'Borrado el',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Rol',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'name'               => 'Nombre',
            'name_helper'       => '',
            'permissions'        => 'Permisos',
            'permissions_helper' => '',
            'created_at'         => 'Creado el',
            'created_at_helper'  => '',
            'updated_at'         => 'Actualizado el',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Borrado el',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Usuarios',
        'title_singular' => 'Usuario',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Nombre',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verificado el',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => 'Dejar en vacío para no modificar',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Creado el',
            'created_at_helper'        => '',
            'updated_at'               => 'Actualizado el',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Borrado el',
            'deleted_at_helper'        => '',
        ],
    ],
    'account'=>[
        'title'=>'Cuentas',
        'title_singular'=>'Cuenta',
        'fields'=>[
            'id'=>'Id',
            'name'=>'Nombre',
            'name_helper'=>'',
            'description'=>'Descripción',
            'description_helper'=>'',
            'token' => 'Token',
            'merchant_id' => 'Merchant id',
            'user'=>'Usuario',
            'password'=>'Contraseña',
            'service' => 'Servicios',
            'service_helper'=>'Algunos servicios requieren autenticación manual'
        ]
    ],
    'service'=>[
        'title'=>'Servicios',
        'title_singular'=>'Servicio',
        'fields'=>[
            'id'=>'ID',
            'name'=>'Nombre',
            'name_helper'=>'',
            'client_id'=>'Id de cliente',
            'client_id_helper'=>'',
            'client_secret'=>'Código secreto del cliente',
            'client_secret_helper'=>'',
            'country_code'=>'Código de pais',
            'currency_code'=>'Código de moneda',
            'language_code'=>'Lenguaje',
            'before_description' => 'Antes de la descripción',
            'before_description_helper' => 'Este texto se incluira en todas las descripciones de los productos.',
            'after_description' => 'Despues de la descripción',
            'after_description_helper' => 'Este texto se incluira en todas las descripciones de los productos.',
            'status'=>'Estado',
            'service_code'=>'Código de servicio',
            'external_url'=>'Url',
            'available_order_fields' => 'Campos de pedido disponibles'
        ]

    ],
    'order'=>[
        'title'=>'Pedidos',
        'title_singular'=>'Pedido',
        'fields'=>[
            'id'=>'Id',
            'order_id'=>'Id de pedido',
            'seller_name'=>'Vendedor',
            'product_name'=>'Producto',
            'total_paid_amount'=>'Precio',
            'method_paid'=>'Metodo de pago',
            'status_order' => 'Estado del pedido',
            'payer_nickname' => 'Comprador',
        ],
        'fieldsWoo'=>[
            'id'=>'Id',
            'order_id'=>'Id de pedido',
            'product_name'=>'Producto',
            'total_paid_amount'=>'Precio',
            'user_name'=>'Nombre',
            'user_last_name'=>'Apellido',
            'user_email'=>'Email',
            'user_dni'=>'DNI',
            'user_phone'=>'Celular número',
            'user_phone_code'=>'Celular código',
            'address_reference' => 'Referencia',
            'address_address'=>'Calle',
            'address_number'=>'Numero',
            'address_piso'=>'Piso',
            'address_departament'=>'Departamento',
            'address_location'=>'Localidad',
            'address_postal_code'=>'Codigo postal',
            'address_observation' => 'Observaciones',
            'status_order' => 'Estádo del pedido',
            'last_updated'=>'Ultima actualización',
            'status'=>'Estado',

            'weight' => 'Peso(grs)*',
            'entrust_name' => 'Nombre de encomienda',
            'height' => 'Alto (cm)',
            'width' => 'Ancho (cm)',
            'depth' => 'Profundidad (cm)',
            'declared_value' => 'Valor declarado ($ C/IVA)',

        ]
    ],
    'product'=>[

        'title'=>'Productos',
        'title_singular'=>'Producto',
        'fields'=>[
            'id'=>'Id',
            'product_name'=>'Producto',
            'status_synchronize'=>'Estado de sincronización',
            'status_action'=>'Acción',
            'product_code'=>'Código de producto',
            'catalog_code'=>'Código de catalogo',
            'product_quantity'=>'Cantidad',
            'product_price'=>'Precio',
            'product_category'=>'Categoria'
        ]
    ],
    'account_service'=>[
        'title'=>'Servicios de cuenta',
        'fields'=>[
            'account'=>'Cuenta',
            'services'=>'Servicios',
        ]
    ]
];
