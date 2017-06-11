<?php

/*
 +-------------------------------------------------------------------------+
 | Copyright 2010-2017, Davide Franco			                   |
 |                                                                         |
 | This program is free software; you can redistribute it and/or           |
 | modify it under the terms of the GNU General Public License             |
 | as published by the Free Software Foundation; either version 2          |
 | of the License, or (at your option) any later version.                  |
 |                                                                         |
 | This program is distributed in the hope that it will be useful,         |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           |
 | GNU General Public License for more details.                            |
 +-------------------------------------------------------------------------+
*/

 session_start();
 include_once('core/global.inc.php');

 // Initialise view and model
 $view = new CView();
 $dbSql = new Bweb($view);

 // Get volumes list (pools.tpl)
 $pools = new Pools_Model();
 $pools_list = array();
 $plist = $pools->getPools();

 // Add more details to each pool
 foreach($plist as $pool) {

   // Total bytes for each pool
   $sql = "SELECT SUM(Media.volbytes) as sumbytes FROM Media WHERE Media.PoolId = '" . $pool['poolid'] . "'";
   $result = $pools->run_query($sql);
   $result = $result->fetchAll();
   $pool['totalbytes'] = CUtils::Get_Human_Size($result[0]['sumbytes']);

   $pools_list[] = $pool;
 }

 $view->assign('pools', $pools_list);

 // Set page name
 $current_page = 'Pools report';
 $view->assign('page_name', $current_page);
 
 // Process and display the template
 $view->display('pools.tpl');
