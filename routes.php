<?php

return $routes = [
    'GET' => [
        'courses' => 'CourseController@read',
        'subjects' => 'SubjectController@read'
    ],
    'POST' => [
        'courses' => 'CourseController@create',
        'subjects' => 'SubjectController@create'

    ],
    'PUT' => [
        'courses' => 'CourseController@update',
        'subjects' => 'SubjectController@update'

    ],

    'DELETE' => [
        'courses' => 'CourseController@delete',
        'subjects' => 'SubjectController@delete'

    ]

  
    ]; 
