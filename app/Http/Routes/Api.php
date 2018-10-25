<?php
declare(strict_types=1);

/** @var \Laravel\Lumen\Routing\Router $router */

// MailChimp group
$router->group(['prefix' => 'mailchimp', 'namespace' => 'MailChimp'], function () use ($router) {
    // Lists group
    $router->group(['prefix' => 'lists'], function () use ($router) {
        $router->post('/', 'ListsController@create');
        $router->get('/{listId}', 'ListsController@show');
        $router->put('/{listId}', 'ListsController@update');
        $router->delete('/{listId}', 'ListsController@remove');

        $router->post('/{listId}', 'MembersController@create');
        $router->get('/{listId}/member/{memberId}', 'MembersController@show');
        $router->put('/{listId}/member/{memberId}', 'MembersController@update');
        $router->delete('/{listId}/member/{memberId}', 'MembersController@remove');
    });
});
