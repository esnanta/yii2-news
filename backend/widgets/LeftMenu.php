<?php

/**
 * Description of Menu
 *
 * @author Cassiopeia
 */

namespace backend\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class LeftMenu extends Menu
{
    public $linkTemplate = '<a href="{url}" class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12">{label}</a>';
    public $submenuTemplate = "\n<ul class='my-custom-submenu'>\n{items}\n</ul>\n";
    public $activateParents = true;
    public $options = ['id'=>'sideNavMenu', 'class' => 'u-sidebar-navigation-v1-menu u-side-nav--top-level-menu g-min-height-100vh mb-0'];
    public $itemOptions = ['class' => 'u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item'];
    
    protected function renderItem($item)
    {
        $label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
        $url = isset($item['url']) ? Url::to($item['url']) : null;
        $template = isset($item['template']) ? $item['template'] : $this->linkTemplate;

        if (isset($item['items']) && !empty($item['items'])) {
            $template = $this->submenuTemplate;
            $label .= ' <span class="caret"></span>';
            $submenu = parent::renderItems($item['items']);
        } else {
            $submenu = '';
        }

        return strtr($template, [
            '{url}' => Html::encode($url),
            '{label}' => $label,
            '{items}' => $submenu,
        ]);
    }
}
