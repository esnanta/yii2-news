/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=accountpayable-]").change(function () {
        calculate();
    });
    
    $(document).on("change", "[id^=accountpayabledetail-]" ,function() {
       calculate();
    });
     
    $(document).on("click", "[id=account-payable-detail-del-btn]" ,function() {
       calculate();
    }); 
    
//    SISAKAN SEBAGAI CONTOH  
//    $("#accountpayable-payment").change(function () {
//        calculate();
//    });
    
    function calculate(){
        //BAGIAN DETAIL
        //HILANGKAN KOMA SEBELUM DIHITUNG
        row = 0;
        for(i=0; i < 30; i++){
            if($('#accountpayabledetail-' + i + '-amount').length > 0) {
                
                //HILANGKAN KOMA
                tmp = +$('#accountpayabledetail-' + i + '-amount').val().replace(/,/g, "");
                
                //HITUNG AKUMULASI TOTAL DETAIL
                row = row + tmp;              
                
                //GUNAKAN KOMA LAGI
                $('#accountpayabledetail-' + i + '-amount').val(tmp.toLocaleString());
            }            
        }
        
        //HILANGKAN KOMA SEBELUM DIHITUNG
        claim       = +$('#accountpayable-claim').val().replace(/,/g, "");
        surcharge   = +$('#accountpayable-surcharge').val().replace(/,/g, "");
        penalty     = +$('#accountpayable-penalty').val().replace(/,/g, "");
        discount    = +$('#accountpayable-discount').val().replace(/,/g, "");
        payment     = +$('#accountpayable-payment').val().replace(/,/g, "");
        
        //HITUNG TOTAL & BALANCE
        claim       = row;
        total       = claim + surcharge + penalty;
        balance     = payment-(total-discount);

        //KEMBALIKAN KOMA
        $('#accountpayable-claim').val(claim.toLocaleString());
        $('#accountpayable-surcharge').val(surcharge.toLocaleString());
        $('#accountpayable-penalty').val(penalty.toLocaleString());
        $('#accountpayable-total').val(total.toLocaleString());
        $('#accountpayable-discount').val(discount.toLocaleString());
        $('#accountpayable-payment').val(payment.toLocaleString());
        $('#accountpayable-balance').val(balance.toLocaleString());
    }

});

