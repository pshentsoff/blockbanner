<?php

/*---------------------------------------------------------------------------
 * @Plugin Name: BlockBanner
 * @Plugin Id: blockbanner
 * @Plugin URI: 
 * @Description: Banners Blocks management for LiveStreet/ACE
 * @Version: 0.0.1
 * @Author: Vadim Pshentsov (aka pshentsoff)
 * @Author URI: http://blog.pshentsoff.ru 
 * @LiveStreet Version: 0.0.2
 * @File Name: %%filename%%
 * @License: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *----------------------------------------------------------------------------
 */

return array(
    'title' => 'Blockbanner',
    'blockbanner' => 'Blockbanner',
    'uploadimg' => '',
    'description' => 'Описание',
    'license' => 'Лицензия',
    'donate' => 'Пожертвования',
    'goback' => 'Вернуться',

    'buttons' => array(
        'add' => 'Добавить',
        'delete' => 'Удалить',
        'save' => 'Сохранить',
    ),

    'groups' => array(
        'title' => 'Группы баннеров',
        'name' => 'Наименование',
        'hook' => 'Хук',
        'template' => 'Шаблон',
        'banners' => 'Баннеры (неск. с нажатой &lt;Ctrl&gt;)',
        'include_pages' => 'Вкл. страницы (пусто - все)',
        'exclude_pages' => 'Исключить страницы',
        'comments' => 'Комментарии к группе',
    ),

    'banners' => array(
        'title' => 'Баннеры',
        'name' => 'Имя баннера',
        'url' => 'Ссылка баннера',
        'url_title' => 'Заголовок ссылки',
        'image_path' => 'Путь к баннеру (не исп.)',
        'image_url' => 'Веб-путь к баннеру',
        'image_alt' => 'Текст изобр.',
        'preview' => 'Предв. просмотр',
        'order' => 'Порядок',
        'visible' => 'Видимость',
    ),

);
  