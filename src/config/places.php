<?php

return [
    'linkable_to_page' => true,
    'per_page' => 30,
    'order' => [
        'title' => 'asc',
    ],
    'sidebar' => [
        'icon' => '<i class="bi bi-geo-alt"></i>',
        'weight' => 40,
    ],
    'permissions' => [
        'read places' => 'Read',
        'create places' => 'Create',
        'update places' => 'Update',
        'delete places' => 'Delete',
    ],
];
