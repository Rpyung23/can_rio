function register_canino()
{
    let name = document.getElementById("inputNombreNuevaMascota").value;
    let obse = document.getElementById("TextareaObservacionesNuevoCanino").value;
    let edad = document.getElementById("inputEdadNuevaMascota").value;

    var id_tipo_raza = document.getElementById("idSelectorRazasNuevaMascota");
    var id_estado_salud = document.getElementById("idSelectorestadoSaludNuevaMascota");


    var valorTipoRaza = id_tipo_raza.options[id_tipo_raza.selectedIndex].getAttribute("id_tipo_raza")
    var valorRdtadoSalud =  id_estado_salud.options[id_tipo_raza.selectedIndex].getAttribute("id_tipo_estado_salud")



    let ObjRegister =
        {
            name:name,
            fecha:"2021-02-10",
            observacion:obse,
            estado:1,
            edad:edad,
            id_tipo_raza:valorTipoRaza,
            id_estado_salud:valorRdtadoSalud,
            photo64:base64_FotoNuevaMascota
        }


    $.ajax({
           url:"https://canriobamba.000webhostapp.com/can_rio/rest/mascota.php",
        datatype:"json",
        method:"POST",
        data:JSON.stringify(ObjRegister)
        }).done(function (datos)
    {
        var json_string = JSON.stringify(datos)
        var json_parse = JSON.parse(json_string)
        if(json_parse.status_code === 200)
        {
            alert("Canino Registrado")
        }else
            {
                alert("Lo sentimos no se pudo registrar el canino")
            }
    }).fail(function ()
    {
        alert("Error ApiRest")
    })

}