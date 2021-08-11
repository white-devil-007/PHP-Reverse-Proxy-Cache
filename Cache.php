if (!isset($_GET['Cache'])) {
    $url = $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(isset($_GET)) {
        $exploded_url = explode( "?", $url );
            
        $count_url = 0;
        foreach($exploded_url as $a) {
            if($a = 'Cache') {
                $count_url++;
            }
            if($count_url == 3) {
                die();
            }
        }
    }

    $Da5a = array("url" => $url);
    #, "headers" => getallheaders()
        
    if(isset($_SERVER['HTTP_REFERER'])) {
        $Da5a["referer"] = $_SERVER['HTTP_REFERER'];
    }
    $url_hook = "YOUR CACHE SERVER WEBHOOK URL";

    // Initialize a CURL session.
    $ch = curl_init();

    // Return Page contents.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Da5a));

    //grab URL and pass it to the variable.
    curl_setopt($ch, CURLOPT_URL, $url_hook);

    $result = curl_exec($ch);

    echo $result;

    die();
}
