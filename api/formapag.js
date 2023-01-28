$("#estados").on("change", function() {
    var idEstado = $("#estados").val();
    // alert(idEstado);
    $.ajax({
        url: 'processamento/buscar.php',
        type: "POST",
        data: { id: idEstado },
        beforeSend: function() {
            $("#cidades").css({ 'display': 'block' });
            $("#cidades").html("Carregando....");
        },
        success: function(data) {
            $("#cidades").css({ 'display': 'block' });
            $("#cidades").html(data);
        },
        error: function(data) {
            $("#cidades").css({ 'display': 'block' });
            $("#cidades").html("Houve um erro ao carregar os dados...");
        }
    });
});