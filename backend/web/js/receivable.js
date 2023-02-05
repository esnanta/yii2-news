/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//http://jsfiddle.net/kY98p/10/


$(document).ready(function () {

    $("[id^=receivable-]").change(function () {
        calculate();
    });
       
    $(document).on("change", "[id^=receivabledetail-]" ,function() {
       calculate();
    });
    
    $(document).on("click", "[id^=receivable-detail-del-btn]" , function(){
        calculate();
    });      
    
//    $(document).on("click", "a", function(){
//        alert("A link was clicked!");
//    });     
//    SISAKAN SEBAGAI CONTOH  
//    $("#receivable-payment").change(function () {
//        calculate();
//    });
    
    function calculate(){
        //BAGIAN DETAIL
        //HILANGKAN KOMA SEBELUM DIHITUNG
        totalClaim = 0;
        totalPenalty = 0;
        for(i=0; i < 30; i++){
            if($('#receivabledetail-' + i + '-claim').length > 0 ||
                    $('#receivabledetail-' + i + '-penalty').length > 0) {
                
                //HILANGKAN KOMA
                detailClaim = +$('#receivabledetail-' + i + '-claim').val().replace(/,/g, "");
                detailPenalty = +$('#receivabledetail-' + i + '-penalty').val().replace(/,/g, "");
                detailTotal = detailClaim+detailPenalty;
                
                //HITUNG AKUMULASI TOTAL DETAIL
                totalClaim = totalClaim + detailClaim;              
                totalPenalty = totalPenalty + detailPenalty;
                
                //GUNAKAN KOMA LAGI
                $('#receivabledetail-' + i + '-claim').val(detailClaim.toLocaleString());
                $('#receivabledetail-' + i + '-penalty').val(detailPenalty.toLocaleString());
                $('#receivabledetail-' + i + '-total').val(detailTotal.toLocaleString());
            }  
        }
        
        //HILANGKAN KOMA SEBELUM DIHITUNG
        claim       = +$('#receivable-claim').val().replace(/,/g, "");
        surcharge   = +$('#receivable-surcharge').val().replace(/,/g, "");
        penalty     = +$('#receivable-penalty').val().replace(/,/g, "");
        discount    = +$('#receivable-discount').val().replace(/,/g, "");
        payment     = +$('#receivable-payment').val().replace(/,/g, "");
        
        //HITUNG TOTAL & BALANCE
        claim       = totalClaim;
        penalty     = totalPenalty;
        total       = claim + surcharge + penalty;
        balance     = payment-(total-discount);

        //KEMBALIKAN KOMA
        $('#receivable-claim').val(claim.toLocaleString());
        $('#receivable-surcharge').val(surcharge.toLocaleString());
        $('#receivable-penalty').val(penalty.toLocaleString());
        $('#receivable-total').val(total.toLocaleString());
        $('#receivable-discount').val(discount.toLocaleString());
        $('#receivable-payment').val(payment.toLocaleString());
        $('#receivable-balance').val(balance.toLocaleString());
    }

});

