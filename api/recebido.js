$("#troco").keyup(function(e) {
    var troco = $(this).val();
    $.post('processamento/recebido.php', { 'troco': troco }, function(data) {
        $("#resultado_troco").html(data);
    })

});