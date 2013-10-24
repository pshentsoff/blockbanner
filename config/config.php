<?php

/*---------------------------------------------------------------------------
 * @Plugin Name: BlockBanner
 * @Plugin Id: blockbanner
 * @Plugin URI: 
 * @Description: Banners Blocks management for LiveStreet/ACE
 * @Version: 0.0.1
 * @Author: Vadim Pshentsov (aka pshentsoff)
 * @Author URI: http://blog.pshentsoff.ru 
 * @LiveStreet Version: 1.x
 * @File Name: %%filename%%
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *----------------------------------------------------------------------------
 */

$config = array ();

// plugin`s settings table name
$config['table']['banners'] = '___db.table.prefix___blockbanner_banners';
$config['table']['groups'] = '___db.table.prefix___blockbanner_groups';
$config['table']['groupsbanners'] = '___db.table.prefix___blockbanner_groupsbanners';

//plugin's cache settings
$config['cache']['ttl'] = 1;

//blocks settings
$config['blocks']['error'] = 'blocks/block.error.tpl';
$config['blocks']['default'] = 'blocks/block.banner.tpl';
$config['blocks']['exclude_pages'] = array('admin','blockbanner');

$config['lists']['delimeter'] = ',';

//plugin routing
$config['$root$']['router']['page']['blockbanner'] = 'PluginBlockbanner_ActionBlockbanner';

return $config;

