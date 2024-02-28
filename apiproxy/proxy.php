<?php

// Determinar si la solicitud es HTTPS y construir la URL actual.
$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$URL_ATUAL = $scheme . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Obtener el método de la solicitud.
$method = $_SERVER['REQUEST_METHOD'];

// Verificar si el parámetro 'url' está presente y no está vacío.
if (!empty($_GET["url"])) {
    $url = $_GET['url'];
    $urlParts = parse_url($url);
    $clientIp = $urlParts['host'] ?? '';

    // Verificar si la IP del cliente está autorizada.
    $ipsLiberadas = file_get_contents("ips.txt");
    if (strpos($ipsLiberadas, $clientIp) !== false) {
        $headers = getallheaders();
        $headers_str = [];
        foreach ($headers as $key => $value) {
            if ($key != 'Host') {
                $headers_str[] = "$key:$value";
            }
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Manejar diferentes tipos de contenido de solicitud.
        if ($method == "PUT" || $method == "PATCH" || ($method == "POST" && empty($_FILES))) {
            $data_str = file_get_contents('php://input');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
        } elseif ($method == "POST" && !empty($_FILES)) {
            $data_str = [];
            foreach ($_FILES as $key => $value) {
                $data_str[$key] = '@' . realpath($value['tmp_name']);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str + $_POST);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_str);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;
    } else {
        echo "<script>alert('IP não Autorizado!');</script>";
        echo "<script>window.location.href = 'https://t.me/paineis';</script>";
        exit;
    }
} else {
    echo "<script>alert('Método não Autorizado!\\nFavor usar dessa forma do exemplo\\n$URL_ATUAL?url=http://ipvps:5000');</script>";
    echo "<script>window.location.href = 'https://t.me/paineis';</script>";
    exit;
}
?>
