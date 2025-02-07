<?php

return [
    'layout' => 'layouts.layout', // You must set it. Example: 'layout' => 'adminlte::page'
    'userModelClass' => App\Models\User::class, // You can change it
    'adminUserId' => null, // You must set it. This is the initial user id, which must be an administrator, at least at the first stage.
    'routesMainPermission' => Itstructure\LaRbac\Models\Permission::ADMINISTRATE_PERMISSION,  // You can change it
    'routesAuthMiddlewares' => ['auth'],  // You can change it
    'memberNameAttributeKey' => 'name',
    'rowsPerPage' => 10,
];
