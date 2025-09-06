<?php
$map = ['create', 'read', 'update', 'delete'];

return [
    'models' => [
        'roles' => $map,
        'admins' => $map,
        'students' => $map,
        'teachers' => $map,
        'categories' => $map,
        'courses' => $map,
        'lessons' => $map,
        'settings' => ['read', 'update'],
        'actives' => ['read', 'delete'],
        'statistics_home' => ['read'],
    ],
];
