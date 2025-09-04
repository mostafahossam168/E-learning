<?php
$map = ['create', 'read', 'update', 'delete'];

return [
    'models' => [
        'roles' => $map,
        'admins' => $map,
        'students' => $map,
        'teachers' => $map,
        'settings' => ['read', 'update'],
    ],
];