<?php
use \NoahBuscher\Macaw\Macaw;

Macaw::get('/','controller\IndexController@index');
Macaw::get('wiki/(:num)/(:num)','controller\IndexController@wiki');    // wiki详情页
Macaw::get('add/(:num)/(:num)','controller\IndexController@add');      // wiki增加
Macaw::get('edit/(:num)/(:num)','controller\IndexController@edit');      // wiki增加
Macaw::get('commit','controller\IndexController@commit');
Macaw::get('navigation','controller\IndexController@navigation');
Macaw::post('ajax_new_wiki','controller\IndexController@ajax_new_wiki');
Macaw::post('ajax_edit_wiki','controller\IndexController@ajax_edit_wiki');
Macaw::get('diff/(:any)','controller\IndexController@diff');

Macaw::get('pull','controller\IndexController@pull_wiki');
Macaw::get('clone','controller\IndexController@clone_wiki');



Macaw::dispatch();