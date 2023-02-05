/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=applicationgrade-]").change(function () {
        calculate();
    });
    
    $(document).on("change", "[id^=applicationgrade-]" ,function() {
       calculate();
    });
     
//    SISAKAN SEBAGAI CONTOH  
//    $("#applicationgrade-payment").change(function () {
//        calculate();
//    });
    
    function calculate(){
        //BAGIAN DETAIL
        //HILANGKAN KOMA SEBELUM DIHITUNG
        row = 0;
        for(i=0; i < 30; i++){
            if($('#applicationgrade-' + i + '-grade').length > 0) {
                
                //HILANGKAN KOMA
                tmp = +$('#applicationgrade-' + i + '-grade').val().replace(/,/g, "");
                
                //HITUNG AKUMULASI TOTAL DETAIL
                row = row + tmp;              
                
                //GUNAKAN KOMA LAGI
                $('#applicationgrade-' + i + '-grade').val(tmp.toLocaleString());
            }            
        }
        
//        //HILANGKAN KOMA SEBELUM DIHITUNG
//        claim       = +$('#applicationgrade-claim').val().replace(/,/g, "");
//        surcharge   = +$('#applicationgrade-surcharge').val().replace(/,/g, "");
//        penalty     = +$('#applicationgrade-penalty').val().replace(/,/g, "");
//        discount    = +$('#applicationgrade-discount').val().replace(/,/g, "");
//        payment     = +$('#applicationgrade-payment').val().replace(/,/g, "");
//        
//        //HITUNG TOTAL & BALANCE
//        claim       = row;
//        total       = claim + surcharge + penalty;
//        balance     = payment-(total-discount);
//
//        //KEMBALIKAN KOMA
//        $('#applicationgrade-claim').val(claim.toLocaleString());
//        $('#applicationgrade-surcharge').val(surcharge.toLocaleString());
//        $('#applicationgrade-penalty').val(penalty.toLocaleString());
//        $('#applicationgrade-total').val(total.toLocaleString());
//        $('#applicationgrade-discount').val(discount.toLocaleString());
//        $('#applicationgrade-payment').val(payment.toLocaleString());
//        $('#applicationgrade-balance').val(balance.toLocaleString());
    }

});

