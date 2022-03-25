<?php

return
[
    'GET|/' =>
        [
            'class' => \Addequatte\Newspaper\Controllers\MainController::class,
            'foo' => 'index'
        ],
    'GET|/post/<id>' =>
        [
            'class' => \Addequatte\Newspaper\Controllers\MainController::class,
            'foo' => 'post'
        ],
  'GET|/admin' =>
      [
          'class' => \Addequatte\Newspaper\Controllers\AdminController::class,
          'foo' => 'index'
      ],
    'GET|/admin/post/new' =>
        [
            'class' => \Addequatte\Newspaper\Controllers\AdminController::class,
            'foo' => 'new'
        ],
    'POST|/admin/post/create' =>
        [
            'class' => \Addequatte\Newspaper\Controllers\AdminController::class,
            'foo' => 'create'
        ],
    'GET|/admin/post/edit/<id>' =>
        [
            'class' => \Addequatte\Newspaper\Controllers\AdminController::class,
            'foo' => 'edit'
        ],
    'POST|/admin/post/save/<id>' =>
        [
            'class' => \Addequatte\Newspaper\Controllers\AdminController::class,
            'foo' => 'save'
        ],
    'GET|/admin/post/delete/<id>' =>
        [
            'class' => \Addequatte\Newspaper\Controllers\AdminController::class,
            'foo' => 'delete'
        ]
];