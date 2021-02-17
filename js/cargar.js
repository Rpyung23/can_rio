let base64_FotoNuevaMascota = null;
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {

            base64_FotoNuevaMascota = e.target.result

            //console.log(e.target.result);

            var previewZone = document.getElementById('IdImgFotoNuevaMascota');
            previewZone.src = base64_FotoNuevaMascota;
        }

        reader.readAsDataURL(input.files[0]);
    }
}



$(document).on("change","#idInputFileFotoNuevaMascota",function (e)
{
    readFile(e.target || e.srcElement)
});