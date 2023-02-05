/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=validitydetail-]").change(function () {
        calculate();
    });
     
      
//    SISAKAN SEBAGAI CONTOH  
//    $("#validitydetail-payment").change(function () {
//        calculate();
//    });
    
    function calculate(){
        
        //HILANGKAN KOMA SEBELUM DIHITUNG
        claim       = +$('#validitydetail-amount').val().replace(/,/g, "");

        //KEMBALIKAN KOMA
        $('#validitydetail-amount').val(claim.toLocaleString());
    }

});

