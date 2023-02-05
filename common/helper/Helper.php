<?php
namespace common\helper;

use Yii;

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
    
    //TANGGAL PERTAMA DIHITUNG PADA BULAN BERIKUTNYA
    //KARENA TAGIHAN IURAN BULANAN PERTAMA DIBEBANKAN PADA 
    //ONGKOS PASANG
    public static function getFirstDateBilling($date, $billingCycle){
        
        //CEK TANGGAL TAGIHAN
        //KALAU DI ATAS 28, BUAT KE BULAN BERIKUTNYA
        $hari = (int) (date('d',$date)); 
        if($hari > 28){
            $date = self::getNextDue($date, $billingCycle);
        }
        
        $bulan      = date('m',$date);
        $tahun      = date('Y',$date);         
        //$newDateDue = $tahun.'-'.$bulan.'-'.$billingCycle;  
        
        //PILIH BULAN BERIKUTNYA
        $newDateDue = date('Y-m-d', strtotime('+1 month', strtotime($tahun.'-'.$bulan.'-'.$billingCycle)));


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
    
    public static function getMonthBetweenDates($date1,$date2){
        $year1  = date('Y',$date1);
        $year2  = date('Y',$date2);
        
        $month1 = date('m',$date1);
        $month2 = date('m',$date2);
        
        $value = $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        
        return $value;
    }
}

?>