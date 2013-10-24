<?php

/*---------------------------------------------------------------------------
 * @Plugin Name: BlockBanner
 * @Plugin Id: blockbanner
 * @Plugin URI: 
 * @Description: Класс хуков плагина Blockbanner
 * @Version: 0.3.2
 * @Author: Vadim Pshentsov (aka pshentsoff)
 * @Author URI: http://blog.pshentsoff.ru 
 * @LiveStreet Version: 1.x
 * @File Name: %%filename%%
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *----------------------------------------------------------------------------
 */

if(!class_exists('Hook')) {
  die('This script can not be executed directly.');
  }

class PluginBlockBanner_HookBlockbanner extends Hook {

  public function RegisterHook() {

      /* Регистрация списка хуков */
      if ($aHooksList = $this->PluginBlockbanner_Blockbanner_GetGroups()) {
          foreach($aHooksList as $hook) {
              $this->AddHook('template_'.$hook['hook'], 'CommonHook');
          }
      }

    }

    /**
     * Общая функция обработки хуков
     * @param $aParam пар-ры переданные хуку
     * @return string возвращает созданный HTML с баннерами или с сообщение об ошибке
     */
    public function CommonHook($aParam) {

      if(in_array(Router::GetAction(),Config::Get('plugin.blockbanner.blocks.exclude_pages'))) {
          return ''; //nothing;
      }

      $out = '<!-- No (visible) banners for this hook -->';

      if(isset($aParam['name']) && !empty($aParam['name'])) {

          if($aGroup = array_shift($this->PluginBlockbanner_Blockbanner_GetGroupByName($aParam['name']))) {
              //Check include pages list
              if(!empty($aGroup['include_pages']) && !$this->PluginBlockbanner_Blockbanner_CheckGroupPages($aGroup['include_pages'])) return $out;
              //Check exclude pages list
              if(!empty($aGroup['exclude_pages']) && $this->PluginBlockbanner_Blockbanner_CheckGroupPages($aGroup['exclude_pages'])) return $out;

              $aBannersList = $this->PluginBlockbanner_Blockbanner_GetBanners($aParam['name']);
              if(empty($aBannersList)) return $out;

              $this->Viewer_Assign('aBlockBanner_Banners', $aBannersList);
              $this->Viewer_Assign('aBlockBanner_Group', $aGroup);

              $template = (isset($aGroup['template']) && !empty($aGroup['template'])) ? $aGroup['template'] : Config::Get('plugin.blockbanner.blocks.default');
              $out = $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).$template);

          } else {

              $this->Viewer_Assign('sBlockbanner_ErrorMsg', "Can not get data for '{$aParam['name']}'");
              $out = $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).Config::Get('plugin.blockbanner.blocks.error'));

          }
      }

      return $out;
    }
    
  }