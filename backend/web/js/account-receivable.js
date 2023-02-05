/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=accountreceivable-]").change(function () {
        calculate();
    });
    
    $(document).on("change", "[id^=accountreceivabledetail-]" ,function() {
       calculate();
    });
    
    $(document).on("click", "[id=account-receivable-detail-del-btn]" ,function() {
       calculate();
    });   
      
//    SISAKAN SEBAGAI CONTOH  
//    $("#accountreceivable-payment").change(function () {
//        calculate();
//    });
    
    function calculate(){
        //BAGIAN DETAIL
        //HILANGKAN KOMA SEBELUM DIHITUNG
        row = 0;
        for(i=0; i < 30; i++){
            if($('#accountreceivabledetail-' + i + '-amount').length > 0) {
                
                //HILANGKAN KOMA
                tmp = +$('#accountreceivabledetail-' + i + '-amount').val().replace(/,/g, "");
                
                //HITUNG AKUMULASI TOTAL DETAIL
                row = row + tmp;              
                
                //GUNAKAN KOMA LAGI
                $('#accountreceivabledetail-' + i + '-amount').val(tmp.toLocaleString());
            }            
        }
        
        //HILANGKAN KOMA SEBELUM DIHITUNG
        claim       = +$('#accountreceivable-claim').val().replace(/,/g, "");
        surcharge   = +$('#accountreceivable-surcharge').val().replace(/,/g, "");
        penalty     = +$('#accountreceivable-penalty').val().replace(/,/g, "");
        discount    = +$('#accountreceivable-discount').val().replace(/,/g, "");
        payment     = +$('#accountreceivable-payment').val().replace(/,/g, "");
        
        //HITUNG TOTAL & BALANCE
        claim       = row;
        total       = claim + surcharge + penalty;
        balance     = payment-(total-discount);

        //KEMBALIKAN KOMA
        $('#accountreceivable-claim').val(claim.toLocaleString());
        $('#accountreceivable-surcharge').val(surcharge.toLocaleString());
        $('#accountreceivable-penalty').val(penalty.toLocaleString());
        $('#accountreceivable-total').val(total.toLocaleString());
        $('#accountreceivable-discount').val(discount.toLocaleString());
        $('#accountreceivable-payment').val(payment.toLocaleString());
        $('#accountreceivable-balance').val(balance.toLocaleString());
    }

});

