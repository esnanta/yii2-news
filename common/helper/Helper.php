<?php
namespace common\helper;

use Yii;
use backend\models\AuthAssignment;

class Helper {

    public static function getMonthPeriod($_date){
        $bulan = date('m',$_date);
        $tahun = date('Y',$_date);
        return $bulan.$tahun;
    }

    public static function getOverdue($_dateTransaction,$_dateOverdue) {
        $checkDatediff = $_dateTransaction - strtotime("+5 days", $_dateOverdue);
        $value = floor($checkDatediff/(60*60*24));
        return ($value <=0) ? 0 : $value;
    }

    public static function getDue($_date){
        return strtotime("+14 days",$_date);
    }

    public static function removeNumberSeparator($_number){
        return str_replace(',', '', $_number);
    }

    public static function GetBetween($var1='',$var2='',$pool){
        $temp1 = strpos($pool,$var1)+strlen($var1);
        $result = substr($pool,$temp1,strlen($pool));
        $dd=strpos($result,$var2);
        if($dd == 0){
            $dd = strlen($result);
        }
        return substr($result,0,$dd);
    }

    public static function formatBillingCycle($_date,$_monthPeriod){
        $date   = $_date;
        $month  = substr($_monthPeriod, 0,2);
        $year   = substr($_monthPeriod, 2,6);

        $newDate = $year.'-'.$month.'-'.$date;

        return self::setDateToNoon(strtotime($newDate));
    }

    public static function getPercent($number,$total) {
        if ($total > 0) {
            return round((($number / $total) * 100), 2);
        } else {
            return 0;
        }
    }

    public static function getNextDue($currentDate,$billingCycle){

        //SET CURRENT DATE TO FIRST DATE OF MONTH
        $tmpCurrentDate = date('Y',$currentDate).'-'.date('m',$currentDate).'-'.'01';
        $newCurrentDate = self::setDateToNoon(strtotime($tmpCurrentDate));

        // One month from a specific date
        $dateDue    = strtotime('+1 month', $newCurrentDate);

        $bulan      = date('m',$dateDue);
        $tahun      = date('Y',$dateDue);

        $newDateDue = $tahun.'-'.$bulan.'-'.$billingCycle;

        return self::setDateToNoon(strtotime($newDateDue));
    }

    public static function getFirstDateBilling($date, $billingCycle){

        //CEK TANGGAL TAGIHAN
        //KALAU DI ATAS 28, BUAT KE BULAN BERIKUTNYA
        $hari = (int) (date('d',$date));
        if($hari > 28){
            $date = self::getNextDue($date, $billingCycle);
        }

        $bulan      = date('m',$date);
        $tahun      = date('Y',$date);
        $newDateDue = $tahun.'-'.$bulan.'-'.$billingCycle;

        if(Yii::$app->params['First_Month_Billing']){
            return self::setDateToNoon(strtotime($newDateDue));
        }
        else{
            return self::getNextDue($date, $billingCycle);
        }

    }

    public static function setDateToNoon($date){
        $hari       = date('d',$date);
        $bulan      = date('m',$date);
        $tahun      = date('Y',$date);

        $newDate = $tahun.'-'.$bulan.'-'.$hari;
        return strtotime($newDate.' 12:00:00');
    }


    public static function getAccessDenied(){
        return 'Access Denied! You do not have permission to access this page.';
    }
    
    public static function getLoginInfo(){
        $username = '"Guest"';
        if(Yii::$app->user->getIsGuest()==false){
            $tmpUsername    = Yii::$app->user->identity->username;
            $roles          = '';
            $authAssignments = AuthAssignment::find()->where(['user_id'=>Yii::$app->user->id])->all();
            foreach ($authAssignments as $authAssignmentModel) {
//                $roles = '<span class="label label-default">'.$authAssignmentModel.'</span>';
            }
            $username = $tmpUsername.', role '.$roles;
        }
        return 'Anda mengakses sebagai '.$username;
    }
    
    public static function getTimeElapsedString($ptime){
        $etime = time() - $ptime;
        if( $etime < 1 ){
            return 'less than 1 second ago';
        }

        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );

        foreach( $a as $secs => $str ){
            $d = $etime / $secs;
            if( $d >= 1 ){
                $r = round( $d );
                return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
            }
        }
    }

}
?>