<?php
/**
 * @file Blockbanner.mapper.class.php
 * @description Маппер для работы с таблицами плагина Blockbanner
 *
 * PHP Version 5.3
 *
 * @package
 * @category
 * @copyright  2013, Vadim Pshentsov. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author     Vadim Pshentsov <pshentsoff@gmail.com>
 * @created    27.02.13
 */

if(!class_exists('Mapper')) {
    die('This script can not be executed directly.');
}


class PluginBlockbanner_ModuleBlockbanner_MapperBlockbanner extends Mapper {

    public function GetGroups($bVisibleOnly = true) {
        $sql = 'SELECT *';
        $sql .= ' FROM `'.Config::Get ('plugin.blockbanner.table.groups') . '` AS `groups`';
        $sql .= ($bVisibleOnly ? ' WHERE `groups`.`visible`=1' : '');
        $sql .= ' ORDER BY `id` ASC';

        $result = $this->oDb->select($sql);

        return $result;
    }

    public function GetGroupByName($sGroupName) {
        $sql = 'SELECT *';
        $sql .= ' FROM `'.Config::Get ('plugin.blockbanner.table.groups') . '`';
        $sql .= ' WHERE `name` = ?s';

        $result = $this->oDb->select($sql, $sGroupName);

        return $result;
    }

    public function SetGroups($aGroups) {
        foreach($aGroups as $aGroup) {
            $this->SetGroup($aGroup);
            //@todo: обработка исключений
        }
    }

    public function SetGroup($aGroup) {
        //@todo: обработка исключений
        if(!isset($aGroup['id']) || empty($aGroup['id'])) {
            return $this->_InsertGroup($aGroup);
        } else {
            return $this->_UpdateGroup($aGroup);
        }
    }

    public function DeleteGroups($aGroups) {
        foreach($aGroups as $aGroup) {
            $this->DeleteGroup($aGroup['id']);
            //@todo: обработка исключений
        }
    }

    public function DeleteGroup($iGroup_id) {
        if(empty($iGroup_id) || $iGroup_id <= 0) return false;
        return $this->_DeleteGroup($iGroup_id);
    }

    protected function _InsertGroup($aGroup) {

        $sql = 'INSERT INTO `'.Config::Get('plugin.blockbanner.table.groups').'`';
        $sql .= ' (`name`, `hook`, `template`, `visible`, `include_pages`, `exclude_pages`, `comments`)';
        $sql .= " VALUES (?s, ?s, ?s, ?d, ?s, ?s, ?s)";

        return $this->oDb->query($sql, $aGroup['name'], $aGroup['hook'], $aGroup['template'], $aGroup['visible'], $aGroup['include_pages'], $aGroup['exclude_pages'], $aGroup['comments']);
    }

    protected function _UpdateGroup($aGroup) {

        $sql = 'UPDATE `'.Config::Get('plugin.blockbanner.table.groups').'`';
        $sql .= ' SET `name`=?s, `hook`=?s,`template`=?s,`visible`=?s,`include_pages`=?s,`exclude_pages`=?s,`comments`=?s';
        $sql .= ' WHERE `id`=?d';

        return $this->oDb->query($sql, $aGroup['name'], $aGroup['hook'], $aGroup['template'], $aGroup['visible'], $aGroup['include_pages'], $aGroup['exclude_pages'], $aGroup['comments'], $aGroup['id']);
    }

    protected function _DeleteGroup($iGroup_id) {
        $sql = 'DELETE FROM `'.Config::Get('plugin.blockbanner.table.groups').'`';
        $sql .= ' WHERE `id`=?d';
        return $this->oDb->query($sql, $iGroup_id);
    }

    public function GetBanners($sGroupName = null, $bVisibleOnly = true) {

        $sql = 'SELECT `banners`.*';
        $sql .= ' FROM `'.Config::Get('plugin.blockbanner.table.banners').'` AS `banners`';
        if(isset($sGroupName) && !empty($sGroupName)) {
            $sql .= ', `'.Config::Get('plugin.blockbanner.table.groups').'` AS `groups`';
            $sql .= ', `'.Config::Get('plugin.blockbanner.table.groupsbanners').'` AS `groupsbanners`';
            $sql .= ' WHERE';
            $sql .= ' `groups`.`id` = `groupsbanners`.`group_id`';
            $sql .= ' AND `groupsbanners`.`banner_id` = `banners`.`id`';
            $sql .= (isset($sGroupName) && !empty($sGroupName)) ? ' AND `groups`.`name` = ?s' : '';
            $sql .= $bVisibleOnly ? ' AND `banners`.`visible`=1' : '';
        } else {
            $sql .= $bVisibleOnly ? 'WHERE `banners`.`visible`=1' : '';
        }
        $sql .= ' ORDER BY `banners`.`order` ASC, `banners`.`id` ASC';

        $result = $this->oDb->select($sql, $sGroupName);

        return $result;
    }

    public function SetBanners($aBanners) {
        foreach($aBanners as $aBanner){
            $this->SetBanner($aBanner);
            //@todo обработка исключений
        }
    }

    public function SetBanner($aBanner) {
        //@todo: обработка исключений
        if(!isset($aBanner['id']) || empty($aBanner['id'])) {
            return $this->_InsertBanner($aBanner);
        } else {
            return $this->_UpdateBanner($aBanner);
        }

    }

    public function DeleteBanners($aBanners) {
        foreach($aBanners as $key=>$iBannerId) {
            $this->DeleteBanner($iBannerId);
            //@todo: обработка исключений
        }
    }

    public function DeleteBanner($iBannerId) {
        if(empty($iBannerId) || $iBannerId <= 0) return false;
        return $this->_DeleteBanner($iBannerId);
    }

    protected function _UpdateBanner($aBanner) {

        $sql = 'UPDATE `'.Config::Get('plugin.blockbanner.table.banners').'`';
        $sql .= ' SET `name`=?s, `url`=?s,`url_title`=?s,`image_path`=?s,`image_url`=?s,`image_alt`=?s,`order`=?d, `visible`=?d';
        $sql .= ' WHERE `id`=?d';

        $result = $this->oDb->query($sql, $aBanner['name'], $aBanner['url'], $aBanner['url_title'], $aBanner['image_path'], $aBanner['image_url'], $aBanner['image_alt'], $aBanner['order'], $aBanner['visible'], $aBanner['id']);
        return $result;
    }

    protected function _InsertBanner($aBanner) {
        $sql = 'INSERT INTO `'.Config::Get('plugin.blockbanner.table.banners').'`';
        $sql .= ' (`name`, `url`, `url_title`, `image_path`, `image_url`, `image_alt`, `order`, `visible`)';
        $sql .= ' VALUES (?s, ?s, ?s, ?s, ?s, ?s, ?d, ?d)';

        $result = $this->oDb->query($sql, $aBanner['name'], $aBanner['url'], $aBanner['url_title'], $aBanner['image_path'], $aBanner['image_url'], $aBanner['image_alt'], $aBanner['order'], $aBanner['visible']);
        return $result;
    }

    protected function _DeleteBanner($iBannerId) {
        $sql = 'DELETE FROM `'.Config::Get('plugin.blockbanner.table.banners').'`';
        $sql .= ' WHERE `id`=?d';
        return $this->oDb->query($sql, $iBannerId);
    }

    public function GetGroupBannersAll($iGroupId) {
        if($iGroupId <= 0) return false;

        $sql = 'SELECT `banners`.*, (`groups`.`id` = ?d) AS `selected`';
//        $sql = 'SELECT `banners`.*';
        $sql .= ' FROM `'.Config::Get('plugin.blockbanner.table.banners').'` AS `banners`';
        $sql .= ' LEFT JOIN (';
        $sql .= ' `'.Config::Get('plugin.blockbanner.table.groupsbanners').'` AS `groupsbanners`';
        $sql .= ', `'.Config::Get('plugin.blockbanner.table.groups').'` AS `groups`';
        $sql .= ') ON (';
        $sql .= ' `banners`.`id` = `groupsbanners`.`banner_id`';
        $sql .= ' AND `groupsbanners`.`group_id` = `groups`.`id`';
        $sql .= ')';


        $result= $this->oDb->select($sql, $iGroupId);
        return $result;
    }

    public function SetGroupsBanners($aGroups) {
        foreach($aGroups as $aGroup) {
            $this->SetGroupBanners($aGroup);
        }
    }

    public function SetGroupBanners($aGroup) {
        //удалить все для группы
        $this->_DeleteGroupBannersAll($aGroup['id']);
        //сохранить все для группы
        if(isset($aGroup['banners']) && !empty($aGroup['banners']))
            $this->_InsertGroupBanners($aGroup['id'], $aGroup['banners']);
    }

    protected function _DeleteGroupBannersAll($iGroupId) {

        if($iGroupId <= 0) return false;

        $sql = 'DELETE FROM `'.Config::Get('plugin.blockbanner.table.groupsbanners').'`';
        $sql .= ' WHERE `group_id`=?d';

        $result = $this->oDb->query($sql, $iGroupId);
        return $result;
    }

    protected function _InsertGroupBanners($iGroupId, $aBanners) {

        if($iGroupId <= 0 || empty($aBanners)) return false;

        $sql = 'INSERT INTO `'.Config::Get('plugin.blockbanner.table.groupsbanners').'`';
        $sql .= ' (`group_id`, `banner_id`)';
        $sql .= ' VALUES (?d, ?d)';

        foreach($aBanners as $aBannerId) {
            $this->oDb->query($sql, $iGroupId, $aBannerId);
        }

        return true;
    }

}
