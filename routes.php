<?php


return $routes = [
    'GET' => [
        'courses' => 'CourseController@read',
        'courses/{id:\d+}' => 'CourseController@read',
        'subjects' => 'SubjectController@read',
        'subjects/{id:\d+}' => 'SubjectController@read'

    ],
    'POST' => [
        'courses' => 'CourseController@create',
        'subjects' => 'SubjectController@create'
    ],
    'PUT' => [
        'courses/{id:\d+}' => 'CourseController@update',

        'subjects/{id:\d+}' => 'SubjectController@update',

    ],
    'DELETE' => [
        'courses/{id:\d+}' => 'CourseController@delete',

        'subjects/{id:\d+}' => 'SubjectController@delete',

    ]
];


