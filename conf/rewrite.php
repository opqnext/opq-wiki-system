<?php
use \NoahBuscher\Macaw\Macaw;

Macaw::get('/','controller\IndexController@index');
Macaw::get('wiki/(:num)','controller\IndexController@wiki');    // wiki详情页
Macaw::get('add/(:num)','controller\IndexController@add');      // wiki增加
Macaw::get('commit','controller\IndexController@commit');
Macaw::post('ajax_new_wiki','controller\IndexController@ajax_new_wiki');
Macaw::get('diff/(:any)','controller\IndexController@diff');

Macaw::get('pull','controller\IndexController@pull_wiki');



Macaw::dispatch();