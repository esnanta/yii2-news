/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=outlet-]").change(function () {
        calculate();
    });
    $("[id^=outletnew-]").change(function () {
        calculate();
    });    

    $(document).on("change", "[id^=outletdetail-]" ,function() {
       calculate();
    });

    $(document).on("click", "[id=outlet-detail-del-btn]" ,function() {
       calculate();
    });

//    SISAKAN SEBAGAI CONTOH
//    $("#outletnew-payment").change(function () {
//        calculate();
//    });

    function calculate(){
        //BAGIAN DETAIL
        //HILANGKAN KOMA SEBELUM DIHITUNG
        totalClaim  = 0;
        claim       = 0;
        for(i=0; i < 50; i++){
            if($('#outletdetail-' + i + '-assembly_cost').length > 0 ||
                    $('#outletdetail-' + i + '-monthly_bill').length > 0) {

                //HILANGKAN KOMA
                monthlyBill     = +$('#outletdetail-' + i + '-monthly_bill').val().replace(/,/g, "");
                assemblyCost    = +$('#outletdetail-' + i + '-assembly_cost').val().replace(/,/g, "");

                //claim      = monthlyBill+assemblyCost;
                claim      = assemblyCost+monthlyBill;
                totalClaim = totalClaim+claim;

                //GUNAKAN KOMA LAGI
                $('#outletdetail-' + i + '-monthly_bill').val(monthlyBill.toLocaleString());
                $('#outletdetail-' + i + '-assembly_cost').val(assemblyCost.toLocaleString());
            }
        }

        //KEMBALIKAN KOMA
        $('#outletnew-claim').val(totalClaim.toLocaleString());
    }

});

