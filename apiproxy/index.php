<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "header.php";
if ($_SERVER ["REQUEST_METHOD"] === "POST" && isset ( $_POST ["submitIPdelete"] )) {
$passcheck = $_POST['passcheck'];
$existingsenhas = file("password.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$ipToDelete = $_POST['ipAddress'];
if (in_array($passcheck, $existingsenhas)) {
if (filter_var($ipToDelete, FILTER_VALIDATE_IP)) {
    $existingIps = file("ips.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (in_array($ipToDelete, $existingIps)) {
        $filteredIps = array_filter($existingIps, function ($ip) use ($ipToDelete) {
            return $ip != $ipToDelete;
        });

        file_put_contents("ips.txt", implode(PHP_EOL, $filteredIps) . PHP_EOL);

        echo myalertuser ( 'success', 'Sucesso!', 'IP excluído com sucesso!', $_SERVER ["HTTP_REFERER"] );
		exit ();
    } else {
        echo myalertuser ( 'warning', 'Atenção!', 'Esse IP não existe!', $_SERVER ["HTTP_REFERER"] );
		exit ();
    }
} else {
    echo myalertuser ( 'error', 'Erro!', 'IP inválido!<br>Digite o IP de 0.0.0.0 à 255.255.255.255!', $_SERVER ["HTTP_REFERER"] );
	exit ();
}
} else {
        echo myalertuser ( 'error', 'Erro!', 'A senha não confere', $_SERVER ["HTTP_REFERER"] );
		exit ();
    }
}
if ($_SERVER ["REQUEST_METHOD"] === "POST" && isset ( $_POST ["submitIPaddress"] )) {
$passcheck = $_POST['passcheck'];
$existingsenhas = file("password.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$urlProxy = $_SERVER['HTTP_HOST'];
$appcheck = $_POST['appcheck'];
$ipAddress = $_POST['ipAddress'];
$portacheck = $_POST['portacheck'];
if (in_array($passcheck, $existingsenhas)) {
if (filter_var($ipAddress, FILTER_VALIDATE_IP)) {
	$existingIps = file("ips.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if ($_POST ["portacheck"] < 1) {
	echo myalertuser ( 'error', 'Erro!', 'PORTA inválida!<br>Digite a PORTA de 1 à 65535!', $_SERVER ["HTTP_REFERER"] );
	exit ();
	}
	if ($_POST ["portacheck"] > 65535) {
	echo myalertuser ( 'error', 'Erro!', 'PORTA inválida!<br>Digite a PORTA de 1 à 65535!', $_SERVER ["HTTP_REFERER"] );
	exit ();
	}

    if (!in_array($ipAddress, $existingIps)) {
        $file = fopen("ips.txt", "a+");

        if ($file) {
            fwrite($file, $ipAddress . PHP_EOL);
            fclose($file);
            if ($appcheck == "DTunnelMOD") {
		    echo info_alert ( 'success', 'Sucesso!', "https://" . $urlProxy . "/apiproxy/proxy.php?url=http://" . $ipAddress . ":" . $portacheck . "", $_SERVER ["HTTP_REFERER"] );
		    exit ();
						} else if ($appcheck === "Conecta4G") {
							echo info_alert ( 'success', 'Sucesso!', "https://" . $urlProxy . "/apiproxy/proxy.php?url=http://" . $ipAddress . ":" . $portacheck . "/checkUser", $_SERVER ["HTTP_REFERER"] );
							exit ();
						} else if ($appcheck === "GLTunnelMOD") {
							echo info_alert ( 'success', 'Sucesso!', "https://" . $urlProxy . "/apiproxy/proxy.php?url=http://" . $ipAddress . ":" . $portacheck . "/gl", $_SERVER ["HTTP_REFERER"] );
							exit ();
							} else {
								echo info_alert ( 'success', 'Sucesso!', "https://" . $urlProxy . "/apiproxy/proxy.php?url=http://" . $ipAddress . ":" . $portacheck . "/anymod", $_SERVER ["HTTP_REFERER"] );
								exit ();
                            }
        } else {
			echo myalertuser ( 'error', 'Erro!', 'Erro ao salvar IP!<br>Arquivos não possui permissão!', $_SERVER ["HTTP_REFERER"] );
	exit ();
        }
    } else {
		echo myalertuser ( 'warning', 'Atenção!', 'Esse IP já existe!', $_SERVER ["HTTP_REFERER"] );
	exit ();
    }
} else {
	echo myalertuser ( 'error', 'Erro!', 'IP inválido!<br>Digite o IP de 0.0.0.0 à 255.255.255.255!', $_SERVER ["HTTP_REFERER"] );
	exit ();
}
} else {
        echo myalertuser ( 'error', 'Erro!', 'A senha não confere', $_SERVER ["HTTP_REFERER"] );
		exit ();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProxyAPI</title>
    <link rel="stylesheet" type="text/css" href="css/mainstilus.css">

    <link rel="icon" type="image/png" href="css/bajopixel.png">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
function isValidIP(e) {

    const alert = "Digite só números e ponto!";

    const res = document.querySelector("#resipAddress");
    let written = document.querySelector("#ipAddress").value;
    if (/[abcdefghijklmnopqrstuvxwyz !@#$%&*,;:?]/i.test(written)) {
        document.getElementById("resipAddress").innerHTML = alert;
        document.getElementById("resipAddress").style.display = "block";
		document.getElementById("portachecklabel").style.display = "none";
		document.getElementById("portacheck").style.display = "none";
		document.getElementById("resportacheck").style.display = "none";
		document.getElementById("passchecklabel").style.display = "none";
		document.getElementById("passcheck").style.display = "none";
		document.getElementById("submitIPaddress").style.display = "none";
		document.getElementById("submitIPdelete").style.display = "none";
        if(e) e.preventDefault();
    } else {
        document.getElementById("resipAddress").style.display = "none";
		document.getElementById("portachecklabel").style.display = "";
		document.getElementById("portacheck").style.display = "";
		document.getElementById("passchecklabel").style.display = "";
		document.getElementById("passcheck").style.display = "";
		document.getElementById("submitIPaddress").style.display = "";
		document.getElementById("submitIPdelete").style.display = "";
    }
	
}
	
function isValidporta(e) {

    const alert = "Digite só números!";

    const res = document.querySelector("#resportacheck");
    let written = document.querySelector("#portacheck").value;
    if (/[abcdefghijklmnopqrstuvxwyz !@#$%&*.,;:?]/i.test(written)) {
        document.getElementById("resportacheck").innerHTML = alert;
        document.getElementById("resportacheck").style.display = "block";
		document.getElementById("passchecklabel").style.display = "none";
		document.getElementById("passcheck").style.display = "none";
		document.getElementById("submitIPaddress").style.display = "none";
		document.getElementById("submitIPdelete").style.display = "none";
        if(e) e.preventDefault();
    } else {
        document.getElementById("resportacheck").style.display = "none";
		document.getElementById("passchecklabel").style.display = "";
		document.getElementById("passcheck").style.display = "";
		document.getElementById("submitIPaddress").style.display = "";
		document.getElementById("submitIPdelete").style.display = "";
    }

}
</script>
</head>
<body>
    <div id="container">
        <h1>
            <span>Gerar link CHECKUSER</span><br>
        </h1> 	
        <form id="ipForm" action="" method="post" onsubmit="return validateForm();">
			<label>Quer gerar pra qual app?</label>
            <select id="appcheck" name="appcheck">
			<option value="DTunnelMOD">DTUNNELMOD</option>
            <option value="Conecta4G">CONECTA4G</option>
			<option value="GLTunnelMOD">GLTUNNELMOD</option>
			<option value="AnyMOD">ANYMOD</option>
            </select>
			<a id="ipAddresslabel">Digite o IP:</a>
            <input type="text" id="ipAddress" name="ipAddress" placeholder="Digite o IP" onkeypress="isValidIP(event)" oninput="isValidIP()" maxlength="15">
			<span id="resipAddress" style="color:Orange"></span>
			<a id="portachecklabel">Digite a PORTA:</a>
            <input type="text" id="portacheck" name="portacheck" placeholder="Digite a PORTA" onkeypress="isValidporta(event)" oninput="isValidporta()" maxlength="5">
			<span id="resportacheck" style="color:Orange"></span>
			<a id="passchecklabel">Digite a SENHA:</a>
			<input type="password" id="passcheck" name="passcheck" placeholder="Digite a SENHA" minlength="4" maxlength="32">
            <button type="submit" id="submitIPaddress" name="submitIPaddress">GERAR</button>
            <button type="submit" id="submitIPdelete" name="submitIPdelete">EXCLUIR</button>			
        </form>
    </div>
        </body>
        </html>