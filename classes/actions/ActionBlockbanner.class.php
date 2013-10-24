<?php
/**
 * @file ActionBlockbanner.class.php
 * @description
 *
 * PHP Version 5.3
 *
 * @package
 * @category
 * @copyright  2013, Vadim Pshentsov. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author     Vadim Pshentsov <pshentsoff@gmail.com>
 * @created    28.02.13
 */


class PluginBlockbanner_ActionBlockbanner extends ActionPlugin {

    public function Init() {

        $this->SetDefaultEvent('admin');

    }

    public function RegisterEvent() {
        $this->AddEvent('description', 'ShowDescription');
        $this->AddEvent('license', 'ShowLicense');
        $this->AddEvent('donate', 'ShowDonate');

        $this->AddEvent('admin', 'EventAdmin');
        $this->AddEvent('groups', 'EventGroups');
        $this->AddEvent('banners', 'EventBanners');
    }

    protected function ShowDescription() {
        $this->Viewer_Assign('sShowTextTitle', $this->Lang_Get('plugin.blockbanner.title').' : '.$this->Lang_Get('plugin.blockbanner.description'));
        $this->Viewer_Assign('sURLBack', 'blockbanner/admin');
        $this->Viewer_Assign('sURLBackTitle', $this->Lang_Get('plugin.blockbanner.goback'));
        $this->Viewer_Assign('sTextFile', Plugin::GetPath(__CLASS__).'/Readme.txt');
        $this->SetTemplateAction('showtext');
    }

    protected function ShowLicense() {
        $this->Viewer_Assign('sShowTextTitle', $this->Lang_Get('plugin.blockbanner.title').' : '.$this->Lang_Get('plugin.blockbanner.license'));
        $this->Viewer_Assign('sURLBack', 'blockbanner/admin');
        $this->Viewer_Assign('sURLBackTitle', $this->Lang_Get('plugin.blockbanner.goback'));
        $this->Viewer_Assign('sTextFile', Plugin::GetPath(__CLASS__).'/License.txt');
        $this->SetTemplateAction('showtext');
    }

    protected function ShowDonate() {
        $this->Viewer_Assign('sShowTextTitle', $this->Lang_Get('plugin.blockbanner.title').' : '.$this->Lang_Get('plugin.blockbanner.donate'));
        $this->Viewer_Assign('sURLBack', 'blockbanner/admin');
        $this->Viewer_Assign('sURLBackTitle', $this->Lang_Get('plugin.blockbanner.goback'));
        $this->Viewer_Assign('sHTMLFile', Plugin::GetPath(__CLASS__).'/Donate.html');
        $this->SetTemplateAction('showtext');
    }

    protected function EventAdmin() {

        if (!LS::Adm()) {
            return parent::EventNotFound();
        }

        $this->Viewer_Assign('bShowDonateLink', 1);
        $this->Viewer_Assign('sActionBlockbannerMenuTemplate', Plugin::GetTemplatePath(__CLASS__).'actions/ActionBlockbanner/menu.tpl');
        $this->SetTemplateAction('main');

    }

    protected function EventGroups() {

        if (!LS::Adm()) {
            return parent::EventNotFound();
        }

        if(isPost('blockbanner_groups_add')) {
            $this->Viewer_Assign('BlockbannerGroupsAddNew', 1);
        } elseif(isPost('blockbanner_groups_delete')) {
            $aGroups = getRequest('blockbanner_groups', array(), 'post');
            $aSelected = array();
            foreach($aGroups as $id=>$aGroup) {
                if(isset($aGroup['selected']) && $aGroup['selected'] == 'on' && isset($aGroup['id'])) {
                    $aSelected[] = $aGroup['id'];
                }
            }
            if(!empty($aSelected)) $this->PluginBlockbanner_Blockbanner_DeleteGroups($aSelected);
            //@todo удаление из таблицы соответсвий
            unset($aSelected);
            unset($aGroups);
        } elseif(isPost('blockbanner_groups_save')) {

            $aGroups = getRequest('blockbanner_groups', array(), 'post');

            // простенькая проверка параметров @todo: нормальную проверку
            foreach($aGroups as $id => $aGroup) {
                //@todo: нормальную проверку параметров
                $aGroups[$id]['id'] = isset($aGroup['id']) ? (int)$aGroup['id'] : null;
                //@todo проверку имени на уникальность
                $aGroups[$id]['name'] = (isset($aGroup['name']) && !empty($aGroup['name'])) ? htmlspecialchars($aGroup['name']) : 'NewGroup 1';
                $aGroups[$id]['hook'] = htmlspecialchars($aGroup['hook']);
                $aGroups[$id]['template'] = htmlspecialchars($aGroup['template']);
                $aGroups[$id]['comments'] = htmlspecialchars($aGroup['comments']);
                $aGroups[$id]['include_pages'] = htmlspecialchars($aGroup['include_pages']);
                $aGroups[$id]['exclude_pages'] = htmlspecialchars($aGroup['exclude_pages']);
                $aGroups[$id]['visible'] = isset($aGroup['visible']) ? 1 : 0;
            }

            $this->PluginBlockbanner_Blockbanner_SetGroups($aGroups);
            $this->PluginBlockbanner_Blockbanner_SetGroupsBanners($aGroups);

            unset($aGroups);
        }

//        $aBanners = $this->PluginBlockbanner_Blockbanner_GetBanners(null, false);
        $aGroups = $this->PluginBlockbanner_Blockbanner_GetGroups(false);
        foreach($aGroups as $id => $aGroup) {
            $aGroups[$id]['banners'] = $this->PluginBlockbanner_Blockbanner_GetGroupBannersAll($aGroup['id']);
        }

        $this->Viewer_Assign('aBlockbanner_Groups', $aGroups);
        $this->Viewer_Assign('bShowDonateLink', Config::Get('plugin.blockbanner.tests.show_donate_link'));
        $this->Viewer_Assign('sActionBlockbannerMenuTemplate', Plugin::GetTemplatePath(__CLASS__).'actions/ActionBlockbanner/menu.tpl');
        $this->SetTemplateAction('groups');

    }

    protected function EventBanners() {

        if (!LS::Adm()) {
            return parent::EventNotFound();
        }

        if(isPost('blockbanner_banners_add')) {
            $this->Viewer_Assign('BlockbannerBannersAddNew', 1);
        } elseif(isPost('blockbanner_banners_delete')) {
            $aBanners = getRequest('blockbanner_banners', array(), 'post');
            $aSelected = array();
            foreach($aBanners as $id=>$aBanner) {
                if(isset($aBanner['selected']) && $aBanner['selected'] == 'on' && isset($aBanner['id'])) {
                    $aSelected[] = $aBanner['id'];
                }
            }
            //@todo удаление из таблицы соответствий
//            PluginFirephp::GetLog($aSelected);
            if(!empty($aSelected)) $this->PluginBlockbanner_Blockbanner_DeleteBanners($aSelected);
            unset($aSelected);
            unset($aBanners);
        } elseif(isPost('blockbanner_banners_save')) {
            $aBanners = getRequest('blockbanner_banners', array(), 'post');
            // простенькая проверка параметров @todo: нормальную проверку
            foreach($aBanners as $id => $aBanner) {
                //@todo: нормальную проверку параметров
                $aBanners[$id]['id'] = isset($aBanner['id']) ? (int)$aBanner['id'] : null;
                //@todo не задали имя - берем из именя файла изображения или урл, или назначаем временное
/*                if(empty($aBanner['name'])) {
                    if(!empty($aBanner['image_url'])) {
                        $aBanners[$id]['name'] =
                    }
                }*/
                $aBanners[$id]['visible'] = isset($aBanner['visible']) ? 1 : 0;
            }
            $this->PluginBlockbanner_Blockbanner_SetBanners($aBanners);
            unset($aBanners);
        }

        $aBanners = $this->PluginBlockbanner_Blockbanner_GetBanners(null, false);
        $this->Viewer_Assign('aBlockbanner_Banners', $aBanners);
        $this->Viewer_Assign('bShowDonateLink', Config::Get('plugin.testomania.tests.show_donate_link'));
        $this->Viewer_Assign('sActionBlockbannerMenuTemplate', Plugin::GetTemplatePath(__CLASS__).'actions/ActionBlockbanner/menu.tpl');
        $this->SetTemplateAction('banners');

    }
}
