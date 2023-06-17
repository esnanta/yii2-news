<?php

/**
 * Description of Menu
 *
 * @author Cassiopeia
 */

namespace common\widgets\menu;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class LeftMenu_1 extends Menu
{
    public $options = ['id'=>'sideNavMenu', 'class' => 'u-sidebar-navigation-v1-menu u-side-nav--top-level-menu g-min-height-100vh mb-0'];
    public $itemOptions = ['class' => 'u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item'];
    public $linkTemplate = '<a href="{url}" class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12"> <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">{icon}</span> {label} </a>';
    public $submenuTemplate = "\n<li class='u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item u-side-nav-opened has-active'>\n{items}\n</li>\n";
    public $activateParents = true;

    protected function renderItem($item)
    {
        $label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
        $url = isset($item['url']) ? Url::to($item['url']) : null;
        $icon = isset($item['icon']) ? Html::tag('span', '', ['class' => $item['icon']]) : '';
        $template = isset($item['template']) ? $item['template'] : $this->linkTemplate;

        if (isset($item['items']) && !empty($item['items'])) {
            $template = str_replace('class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item"', 'class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item u-side-nav-opened has-active" data-toggle="dropdown"', $template);
            $template .= ' ' . Html::tag('b', '', ['class' => 'caret']);
            $submenu = parent::renderItems($item['items']);
        } else {
            $submenu = '';
        }

        return strtr($template, [
            '{url}' => Html::encode($url),
            '{label}' => $label,
            '{icon}' => $icon,
            '{items}' => $submenu,
        ]);
    }
}
