<?php

use Illuminate\Http\Request;

$this->post('auth', 'Auth\ApiAuthController@authenticate');
$this->post('register', 'Auth\ApiAuthController@register');
$this->get('me', 'Auth\ApiAuthController@getAuthenticatedUser');

$this->group([
    'middleware' => 'auth:api'
], function() {
    //atualizar dados do perfil
    $this->put('update', 'Auth\ApiAuthController@update');
    //rotas usuarios
    $this->get('user', 'UserController@index');
    $this->get('user/{id}/project', 'UserController@show');

    //rotas projetos
    $this->get('project', 'ProjectController@index');
    $this->get('project/user/{id}', 'ProjectController@show');
    $this->post('project/create', 'ProjectController@store');
    $this->post('addmember/{id}/project', 'ProjectController@addmember');
    $this->put('project/done/update/{id}','ProjectController@update');

    //rotas tarefas
    
    $this->get('projects/{id}/tasks', 'ProjectController@tasks');
    $this->get('user/tasks/{id}', 'UserController@show');
    $this->post('project/{id}/tasks/create', 'TaskController@store');
});