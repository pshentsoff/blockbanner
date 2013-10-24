<?php

/*---------------------------------------------------------------------------
 * @Plugin Name: BlockBanner
 * @Plugin Id: blockbanner
 * @Plugin URI: 
 * @Description: Banners Blocks management for LiveStreet/ACE
 * @Version: 0.1.8
 * @Author: Vadim Pshentsov (aka pshentsoff)
 * @Author URI: http://blog.pshentsoff.ru 
 * @LiveStreet Version: 1.x
 * @File Name: %%filename%%
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *----------------------------------------------------------------------------
 */

if(!class_exists('Plugin')) {
  die('This script can not be executed directly.');
  }

class PluginBlockbanner extends Plugin {

    /** Plugin init **/
    public function Init() {
        parent::Init();

        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__).'css/style.css');
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/blockbanner.js');

    }

    public function Activate() {
        $file = dirname(__FILE__).'/sql/install.sql';
        if(file_exists($file)) {
            $this->ExportSQL($file);
        }
        return true;
    }

    public function Deactivate() {
        $file = dirname(__FILE__).'/sql/uninstall.sql';
        if(file_exists($file)) {
            $this->ExportSQL($file);
        }
        return true;
    }
      
  }