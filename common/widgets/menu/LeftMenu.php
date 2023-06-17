<?php

/**
 * Description of Menu
 *
 * PROSES MENU INI DIPENDING 
 * SAMPAI DI MANA PROSESNYA SUDAH LUPA
 * 
 * @author Cassiopeia
 */

namespace common\widgets\menu;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class LeftMenu extends Menu
{
    private $id=0;
    public $parentItemOptions = ['class' => '<a href="{url}" class="media submenu-link" data-hssm-target="#sub-menu-{id}">  <span class="d-flex align-self-center submenu-icon">{icon}</span> {label} </a>'];
    
    public $options = ['id' => 'sideNavMenu', 'class' => 'u-sidebar-navigation-v1-menu u-side-nav--top-level-menu  mb-0'];
    public $itemOptions = ['class' => 'u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item'];
    public $linkTemplate = '<a href="{url}" class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12"> <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">{icon}</span> {label} </a>';
    public $submenuTemplate = "\n<ul id='sub-menu-{id}' class='u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0'>\n{items}\n</ul>\n";
    public $activateParents = false;
    private $_idCounter = 1;

    protected function getUniqueId()
    {
        return $this->id . '-sub-' . $this->_idCounter++;
    }

    protected function renderItem($item)
    {
        $label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
        $url = isset($item['url']) ? Url::to($item['url']) : '#';
        $icon = isset($item['icon']) ? Html::tag('span', '', ['class' => $item['icon']]) : '';
        $template = isset($item['template']) ? $item['template'] : $this->linkTemplate;
        $hasSubmenu = isset($item['items']) && !empty($item['items']);

        if ($hasSubmenu) {
            $this->itemOptions['class'] = 'u-sidebar-navigation-v1-menu-item has-submenu';
            $this->linkTemplate = '<a href="{url}" class="media submenu-link" data-hssm-target="#sub-menu-{id}">  <span class="d-flex align-self-center submenu-icon">{icon}</span> {label} </a>';
            $template = isset($item['template']) ? $item['template'] : $this->linkTemplate;

            $submenuId = $this->getUniqueId();
            $submenuTemplate = strtr($this->submenuTemplate, ['{id}' => $submenuId]);
            $submenu = parent::renderItems($item['items'], ['submenuTemplate' => $submenuTemplate]);

            return strtr($template, [
                '{url}' => Html::encode($url),
                '{label}' => $label,
                '{icon}' => $icon,
                '{items}' => $submenu,
                '{id}' => $submenuId,
            ]);
        } 
        else {
            
            $this->itemOptions['class'] = 'u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item';
            $parentItemOptions = $item['level'] == 0 ? $this->parentItemOptions : [];
            
            return Html::tag('li', strtr($template, [
                '{url}' => Html::encode($url),
                '{label}' => $label,
                '{icon}' => $icon,
            ]), array_merge($this->itemOptions, $parentItemOptions));
        }
    }
    
    
    protected function normalizeItems($items, &$active) {
        $normalizedItems = parent::normalizeItems($items, $active);

        $this->addLevel($normalizedItems);

        return $normalizedItems;
    }

    private function addLevel(&$items, $level = 0) {
        foreach ($items as &$item) {
            $item['level'] = $level;
            if (isset($item['items'])) {
                $this->addLevel($item['items'], $level + 1);
            }
        }
    }

}

