<?php
use \NoahBuscher\Macaw\Macaw;

Macaw::get('/','controller\IndexController@index');
Macaw::get('wiki/(:num)','controller\IndexController@wiki');
Macaw::get('add/(:num)','controller\IndexController@add');
Macaw::get('commit','controller\IndexController@commit');
Macaw::post('ajax_new_wiki','controller\IndexController@ajax_new_wiki');



Macaw::dispatch();