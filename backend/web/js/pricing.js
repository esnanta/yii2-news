/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=pricing-]").change(function () {
        calculate();
    });
     
      
//    SISAKAN SEBAGAI CONTOH  
//    $("#pricing-payment").change(function () {
//        calculate();
//    });
    
    function calculate(){
        
        //HILANGKAN KOMA SEBELUM DIHITUNG
        quantity    = +$('#pricing-quantity').val().replace(/,/g, "");
        price       = +$('#pricing-price').val().replace(/,/g, "");

        //KEMBALIKAN KOMA
        $('#pricing-quantity').val(quantity.toLocaleString());
        $('#pricing-price').val(price.toLocaleString());
    }

});

