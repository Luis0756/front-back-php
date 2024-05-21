function calcular() {
    let v1 = $("v1").val()
    let v2 = $("v2").val()
    let op = $("op").val()          
    
    
    $.ajax({
        url: 'calcular.php',
        type: 'POST',
        data: {},
        success: function (retorno) {
            alert(retorno)
        }
    })
}