let tr_donaciones_html = ""
$.ajax({
    url: "https://www.vigitrackecuador.com/can_rio/rest/mascota.php/galeria"
}).done(function(datos) {

var json_string = JSON.stringify(datos)
var json_parse = JSON.parse(json_string)

if (json_parse.status_code == 200) {


    for (var i = 0; i < json_parse.datos.length; i++) {
    tr_donaciones_html += `<div class="item">
            <img src=${json_parse.datos[i].photo64} alt="" class="item-img">
            <div class="item-text">
                <h3>${json_parse.datos[i].name}</h3>
            </div>
        </div>`
}

document.getElementById("galeria_caninos").innerHTML = tr_donaciones_html

}

}).fail(function() {
alert("Error Api Rest")
})