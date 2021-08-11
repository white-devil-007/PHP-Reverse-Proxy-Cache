<?php
    function sanitize_file_name( $filename ) {
        $filename_raw = $filename;
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
        $filename = str_replace('/', '-', $filename);
        $filename = str_replace($special_chars, '', $filename);
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        return $filename = trim($filename, '.-_');
    }

    #header('Content-Type: application/json');

    $request = file_get_contents('php://input');
    $json = json_decode($request, true);

    $data = $json;

    $options = [
        CURLOPT_RETURNTRANSFER => true,     // return web page
#        CURLOPT_HEADER         => true,     // return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => isset($data['HTTP_REFERER']) ? $data['HTTP_REFERER'] : "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 360,      // timeout on connect
        CURLOPT_TIMEOUT        => 360,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    ];

    $url = $data["url"];

    $ch = curl_init($url.'?Cache');

    curl_setopt_array($ch, $options);

    $remoteSite = curl_exec($ch);
    
    #$header = curl_getinfo($ch);
    
    curl_close($ch);
    
    $cachefile = 'File/cached-'.sanitize_file_name($url).'.html';
    $cachetime = 18000;

    // Serve from the cache if it is younger than $cachetime
    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
        echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
        readfile($cachefile);
        exit;
    }
    $cached = fopen($cachefile, 'w');
    fwrite($cached, $remoteSite);
    fclose($cached);
    die();
