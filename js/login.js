$(document).on("click", "#btnIngresar", function() {
    let usuario = document.getElementById("user").value
    let contrasena = document.getElementById("pass").value

    let datos_user = {
        "user": "canrio",
        "pass": "Puma150012"
    }
    let aux = JSON.stringify(datos_user)

    console.log(aux)
    $.ajax({
        url: "https://www.vigitrackecuador.com/can_rio/rest/login.php",
        datatype: "json",
        method: "GET",
        data: "user=" + usuario + "&pass=" + contrasena
    }).done(function(datos) {
        console.log(datos)
            //console(datos)
        let json_string = JSON.stringify(datos)
        let json_parse = JSON.parse(json_string)
            /*{
    		"status_code": 200
		}*/
        if (json_parse.status_code == 200) {

            location.href = "admin.html";
        } else {
            alert('Credenciales no validas')
        }
    }).fail(function() {
        alert("error API rest")
    })
})