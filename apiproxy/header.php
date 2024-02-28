<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/mainstilus.css">

    <link rel="icon" type="image/png" href="css/bajopixel.png">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script>
function Copiar() {
            var copyText = document.getElementById("textcopy").innerText.trim();
            if (copyText.length === 0) {
                Swal.fire({
                    title: 'Atenção',
                    text: 'Não há conteúdo para copiar!',
                    icon: 'warning'
                });
                return;
            }

            var tempInput = document.createElement("input");
            tempInput.value = copyText;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        }

            </script> 
</head>
<body>
<?php
function myalertuser($status, $msgtitle, $msgalert, $dirt) {
	$myalert = "
let timerInterval
Swal.fire({
position: 'center',
icon: '" . $status . "',
title: '" . $msgtitle . "',
html: '<center>" . $msgalert . "</center>',
timer: 5000,
timerProgressBar: true,
willClose: () => {
clearInterval(timerInterval)
}
}).then((result) => {
if (result.dismiss === Swal.DismissReason.timer) {
window.location='" . $dirt . "';
} else {
window.location='" . $dirt . "';
}
})
";
	$alert = '<script type="text/javascript">' . $myalert . '</script>';
	return $alert;
}
function info_alert($status, $msgtitle, $msgalert, $dirt)
{
echo "<div hidden id=\"textcopy\">$msgalert</div>";
$my_alert = "
Swal.fire({
position: 'center',
icon: '" . $status . "',
title: '" . $msgtitle . "',
html: '<center>🎉CHECKUSER GERADO COM SUCESSO!🎉<br><br>" . $msgalert . "</center>',
confirmButtonText: 'Copiar',
confirmButtonColor: '#8080ff',
}).then((result) => {
if (result.isConfirmed) {
Copiar();
Swal.fire({
position: 'center',
icon: 'success',
title: 'Sucesso!',
html: '<center>URL copiada com sucesso!</center>',
showConfirmButton: false,
timer: 1500
}).then((result) => {
if (result.dismiss === Swal.DismissReason.timer) {
window.location='" . $dirt . "';
} else {
window.location='" . $dirt . "';
}
})
} else {
window.location='" . $dirt . "';
}
})
";
$alert = '<script type="text/javascript">' . $my_alert . '</script>';
return $alert;
};
?>
</body>
</html>
</html>