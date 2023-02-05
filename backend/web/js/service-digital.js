/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=service-]").change(function () {
        calculate();
    });
    
    $(document).on("change", "[id^=servicedetail-]" ,function() {
       calculate();
    });
    
    $(document).on("click", "[id=service-detail-del-btn]" ,function() {
       calculate();
    });   
      
//    SISAKAN SEBAGAI CONTOH  
//    $("#servicenew-payment").change(function () {
//        calculate();
//    });
    
    function calculate(){
        //BAGIAN DETAIL
        //HILANGKAN KOMA SEBELUM DIHITUNG
        totalMonthlyBill = 0;
        for(i=0; i < 50; i++){           
            if($('#servicedetail-' + i + '-monthly_bill').length > 0 ) {
                
                //HILANGKAN KOMA               
                monthly_bill    = +$('#servicedetail-' + i + '-monthly_bill').val().replace(/,/g, "");  
                totalMonthlyBill = totalMonthlyBill + monthly_bill;

                //GUNAKAN KOMA LAGI
                $('#servicedetail-' + i + '-monthly_bill').val(monthly_bill.toLocaleString());
            }      
        }
        
        //HILANGKAN KOMA SEBELUM DIHITUNG
        surcharge   = +$('#service-surcharge').val().replace(/,/g, "");
        
        //HITUNG TOTAL
        claim       = totalMonthlyBill;
        total       = claim + surcharge;
        
        //KEMBALIKAN KOMA
        $('#service-claim').val(claim.toLocaleString());
        $('#service-surcharge').val(surcharge.toLocaleString());
        $('#service-total').val(total.toLocaleString());
    }

});

