<?php
namespace common\widgets;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;
use yii\grid\ActionColumn as BaseActionColumn;
use yii\helpers\Html;

class ActionColumn extends BaseActionColumn {

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */

    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        $class = 'btn btn-sm btn-primary';
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        $class = 'btn btn-sm btn-info';
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $class = 'btn btn-sm btn-danger';
                        break;
                    default:
                        $title = ucfirst($name);
                        $class = 'btn btn-sm btn-default';
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => $class,
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }    
    
}