// User routes
$router->get('/user/profile', 'UserController@profile');
$router->get('/user/edit-profile', 'UserController@editProfile');
$router->post('/user/update-profile', 'UserController@updateProfile'); 