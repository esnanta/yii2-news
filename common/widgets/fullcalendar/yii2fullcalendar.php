<?php

 /**
 * This class is used to embed FullCalendar JQuery Plugin to my Yii2 Projects
 * @copyright Frenzel GmbH - www.frenzel.net
 * @link http://www.frenzel.net
 * @author Philipp Frenzel <philipp@frenzel.net>
 *
 */

namespace common\widgets\fullcalendar;

use yii2fullcalendar\yii2fullcalendar as BaseYii2Fullcalendar;

class yii2fullcalendar extends BaseYii2Fullcalendar
{
    /**
     * Define the look n feel for the calendar header, known placeholders are left, center, right
     * @var array header format
     */
    public $header = [
        'center'=>'title',
        'left'=>'prev, next, today',
        'right'=>'month, agendaWeek'
    ];
}
