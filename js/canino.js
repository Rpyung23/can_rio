function register_canino() {

    let name = document.getElementById("inputNombreNuevaMascota").value;
    let obse = document.getElementById("TextareaObservacionesNuevoCanino").value;
    let edad = document.getElementById("inputEdadNuevaMascota").value;

    var id_tipo_raza = document.getElementById("idSelectorRazasNuevaMascota");
    var id_estado_salud = document.getElementById("idSelectorestadoSaludNuevaMascota");


    var valorTipoRaza = id_tipo_raza.options[id_tipo_raza.selectedIndex].getAttribute("id_tipo_raza")
    var valorRdtadoSalud = id_estado_salud.options[id_tipo_raza.selectedIndex].getAttribute("id_tipo_estado_salud")



    let ObjRegister = {
        name: name,
        fecha: "2021-02-10",
        observacion: obse,
        estado: 1,
        edad: edad,
        id_tipo_raza: valorTipoRaza,
        id_estado_salud: valorRdtadoSalud,
        photo64: base64_FotoNuevaMascota
    }


    $.ajax({
        url: "https://www.vigitrackecuador.com/can_rio/rest/mascota.php",
        datatype: "json",
        method: "POST",
        data: JSON.stringify(ObjRegister)
    }).done(function(datos) {
        var json_string = JSON.stringify(datos)
        var json_parse = JSON.parse(json_string)
        if (json_parse.status_code == 200) {
            Swal.fire(
                `Canino`,
                'Canino registrado exitosamente',
                '',
                'success'
            )
            leer_caninos()
        } else {
            alert("Lo sentimos no se pudo registrar el canino")
        }
    }).fail(function() {
        alert("Error ApiRest")
    })

}

function leer_caninos() {
    let th_todos_caninos = "";

    $.ajax({
        url: "https://www.vigitrackecuador.com/can_rio/rest/mascota.php/todas",
        datatype: "json",
        method: "GET"
    }).done(function(datos) {

        var json_string = JSON.stringify(datos)
        var json_parse = JSON.parse(json_string);

        if (json_parse.status_code == 200) {
            for (let i = 0; i < json_parse.datos.length; i++) {


                var foto = json_parse.datos[i].photo64;
                if (foto == "" || foto == null) {
                    foto = "img/img_no_disponible.jpg"
                }

                th_todos_caninos += `<tr>
                <th scope="row">${json_parse.datos[i].idMascota}</th>
                <td>${json_parse.datos[i].name}</td>
                <td>${json_parse.datos[i].fecha_ingreso.replace(" 00:00:00","")}</td>
                <td>${json_parse.datos[i].observaciones}</td>
                <td>${json_parse.datos[i].edad}</td>
                <td>${json_parse.datos[i].detalleTipoRaza}</td>
                <td>${json_parse.datos[i].detalleEstadoSalud}</td>
                <td>
                    <div class="text-center">
                        <img src="${foto}" class="rounded" alt="..." style="width: 50px;height: 50px;">
                    </div>
                </td>
                <td>
                    <button type="button" id_canino=${json_parse.datos[i].idMascota} class="btn_list_canino_delete btn btn-danger"><img src= "img/delete.png"></button>
                    <button type="button" id_canino=${json_parse.datos[i].idMascota} class="btn_list_canino_update btn btn-info"><img src= "img/update.png"></button>
                </td>
            </tr>`
            }

            document.getElementById("id_ThBody_TodasMascotas").innerHTML = th_todos_caninos
        } else {
            alert("No existen datos disponibles")
        }


    }).fail(function() {
        alert("Error en Api-REest")
    })

}

leer_caninos()

$(document).on("click", ".btn_list_canino_delete", function() {

    var id_canino = $(this)[0].getAttribute("id_canino");

    Swal.fire({
        title: 'Eliminar Canino',
        text: "Desea eliminar al canino " + id_canino,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteCanino(id_canino)
        }
    })


})

$(document).on("click", ".btn_list_canino_update", function() {
    var id_canino = $(this)[0].getAttribute("id_canino");
    alert("Update" + id_canino)

})


function deleteCanino(id_canino) {

    let json_body_delete_canino = {
        "id_mascota": id_canino
    }

    $.ajax({
        crossDomain: true,
        url: "https://www.vigitrackecuador.com/can_rio/rest/mascota.php",
        dataType: 'application/json',
        method: "DELETE",
        data: JSON.stringify(json_body_delete_canino)
    }).done(function(datos) {

        var json_string = JSON.stringify(datos)
        var json_parse = JSON.parse(json_string)

        if (json_parse.status_code == 200) {
            Swal.fire(
                `Canino ${id_canino}`,
                'Eliminado!',
                'Los cambios han sido guardados',
                'success'
            )
            leer_caninos()
        } else {
            Swal.fire(
                `Canino ${id_canino}`,
                '',
                'No se pudo completar los cambios',
                'info'
            )
        }

    }).fail(function(e) {


        console.log(e.responseText)

        //var JSON_string = JSON.stringify(e.responseText)

        var json_parse = JSON.parse(e.responseText);

        console.log(json_parse.status_code)

        if (json_parse.status_code == 200) {
            Swal.fire(
                `Canino ${id_canino}`,
                'Eliminado!',
                'Los cambios han sido guardados',
                'success'
            )

            leer_caninos()

        } else {
            Swal.fire(
                `Canino ${id_canino}`,
                'No se pudo completar los cambios de eliminación',
                'info'
            )
        }

    })
}

// Basic example
$(document).ready(function() {
    $('#id_table_canino').DataTable({
        "pagingType": "simple" // "simple" option for 'Previous' and 'Next' buttons only
    });
    $('.dataTables_length').addClass('bs-select');
});