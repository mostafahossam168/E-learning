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
        'coupones' => $map,
        'settings' => ['read', 'update'],
        'enrollments' => ['read', 'update'],
        'actives' => ['read', 'delete'],
        'contacts' => ['read', 'delete'],
        'statistics_home' => ['read'],
    ],
];