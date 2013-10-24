<?php
/**
 * @file Blockbanner.class.php
 * @description Модуль для работы с данными плагина Blockbanner
 *
 * PHP Version 5.3
 *
 * @package
 * @category
 * @copyright  2013, Vadim Pshentsov. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author     Vadim Pshentsov <pshentsoff@gmail.com>
 * @created    26.02.13
 */

if(!class_exists('Module')) {
    die('This script can not be executed directly.');
}

class PluginBlockbanner_ModuleBlockbanner extends Module {

    protected $oMapper;
    protected $oUserCurrent;

    public function Init() {

        $this->oUserCurrent=$this->User_GetUserCurrent();
        $this->oMapper=Engine::GetMapper(__CLASS__);

    }

    /**
     * Возвращает список хуков групп в виде массива
     * @param bool $bVisibleOnly возвращать только видимые
     * @return mixed список хуков в виде массива
     */
    public function GetGroups($bVisibleOnly = true) {

        $tag = 'blockbanner_hookslist_'.($bVisibleOnly ? 'visible' : 'all');

        if(($aHooksList = $this->Cache_Get($tag)) === false) {
            $aHooksList = $this->oMapper->GetGroups($bVisibleOnly);
            $this->Cache_Set($aHooksList, $tag, array('blockbanner_hookschange', 'blockbanner_groupchange'), Config::Get ('plugin.blockbanner.cache.ttl'));
        }

        return $aHooksList;
    }

    /**
     * Сохранение данных групп
     * @param $aGroups массив с массивами данных групп
     */
    public function SetGroups($aGroups) {
        if (!LS::Adm()) return;
        //@todo: тут должна быть проверка прав пользователя
        //@todo: тут должна быть проверка данных массива
        $this->oMapper->SetGroups($aGroups);
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blockbanner_groupchange'));
    }

    /**
     * Удаление групп по id
     * @param $aGroups массив с id групп для удаления
     */
    public function DeleteGroups($aGroups) {
        if (!LS::Adm()) return;
        $this->oMapper->DeleteGroups($aGroups);
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blockbanner_groupchange'));
    }

    /**
     * Возвращает массив с данными группы по имени группы
     * @param $sGroupName имя групы баннеров
     * @return mixed массив с данными группы
     */
    public function GetGroupByName($sGroupName) {

        $tag = 'blockbanner_group_'.$sGroupName;

        if(($aGroupData = $this->Cache_Get($tag)) === false) {
            $aGroupData = $this->oMapper->GetGroupByName($sGroupName);
            $this->Cache_Set($aGroupData, $tag, array('blockbanner_hookschange'), Config::Get ('plugin.blockbanner.cache.ttl'));
        }

        return $aGroupData;
    }

    /**
     * Получение массива данных баннеров группы по имени этой группы
     * @param $sGroupName имя группы баннеров
     * @param $bVisibleOnly возвращать только видимые
     * @return mixed массив данных баннеров группы
     */
    public function GetBanners($sGroupName = null, $bVisibleOnly = true) {
        $tag = 'blockbanner_bannerslist_'.((isset($sGroupName)&&!empty($sGroupName)) ? $sGroupName : 'all').($bVisibleOnly ? '_visible' : '_all');

        if(($aBannersList = $this->Cache_Get($tag)) === false) {
            $aBannersList = $this->oMapper->GetBanners($sGroupName, $bVisibleOnly);
            $this->Cache_Set($aBannersList, $tag, array('blockbanner_hookschange', 'blockbanner_bannerschange'), Config::Get ('plugin.blockbanner.cache.ttl'));
        }

        return $aBannersList;
    }

    /**
     * Сохранение данных баннеров
     * @param $aBanners массив с массивами с данными баннеров
     */
    public function SetBanners($aBanners) {
        if (!LS::Adm()) return;
        $this->oMapper->SetBanners($aBanners);
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blockbanner_bannerschange'));

    }

    /**
     * Удаление баннеров по id
     * @param $aBanners массив с id баннеров для удаления
     */
    public function DeleteBanners($aBanners) {
        if (!LS::Adm()) return;
        $this->oMapper->DeleteBanners($aBanners);
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blockbanner_bannerschange'));
    }

    /**
     * Возвращает массив текущего пути роутера
     * @return array массив с элементами пути роутера
     */
    public function GetRouterPages() {
        $result = array(Router::GetAction(), Router::GetActionEvent());
        return $result;
    }

    /**
     * Проверяет список на совпадение с текущим путем роутера
     * @param $sGroupPages список страниц
     * @return bool возвращает истину, если в переданном списке есть совпадение со списком из текущего пути роутера
     */
    public function CheckGroupPages($sGroupPages) {

        $sGroupPages = trim($sGroupPages);

//        if(!$sGroupPages) return true;

        $aPages = explode(Config::Get('plugin.blockbanner.lists.delimeter'), $sGroupPages);
        $aRouterPages = $this->GetRouterPages();

        foreach($aPages as $sPage) {
            $sPage = trim($sPage);
            $result = in_array($sPage, $aRouterPages);
            if($result) return true;
        }

        return false;
    }

    /**
     * Сохраняет соответвие баннеров группам
     * @param $aGroups массив групп с вложенными массивами используемых баннеров
     */
    public function SetGroupsBanners($aGroups) {
        if (!LS::Adm()) return;
        $this->oMapper->SetGroupsBanners($aGroups);
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blockbanner_groupchange','blockbanner_hookschange'));
    }

    public function GetGroupBannersAll($iGroupId) {
        $tag = 'blockbanner_groupbannerslist_'.$iGroupId;

        if(($aBannersList = $this->Cache_Get($tag)) === false) {
            $aBannersList = $this->oMapper->GetGroupBannersAll($iGroupId);
            $this->Cache_Set($aBannersList, $tag, array('blockbanner_groupschange', 'blockbanner_bannerschange'), Config::Get ('plugin.blockbanner.cache.ttl'));
        }

        return $aBannersList;
    }

}
