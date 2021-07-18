<?php
    //intialize arrary for Post Request
    $postFields = array(
        "ServiceType"=>"2",
        "State" => "0",
        "Name" => "john",
        "PracticeName" => "cena",
        "Location" => "banana",
        "FundingSchemeId" => "1",
        "AreaOfPracticeId" => "apple",
        "Distance" => "20"
    );
    // get link for the curler
    $link = "https://www.otaus.com.au/search/membersearchdistance";

    //function used to crawl through Post Request
    function curl_get($url, $gzip=false){
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
	    If($gzip) curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_POST,1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($postFields));
	    $content = curl_exec($curl);
	    curl_close($curl);
	    return $content;
    }

    //function call 
    $content = curl_get($link,$gzip=false);
    //decoding JSON data from curl to Array
    $decoced = json_decode($content, TRUE);
    //selecting the concerns key, value pair from the decoded JSON
    $arrayToBeParsed = $decoced["plottings"];
    //Setting up static header name for the csv file
    $header = array("Practice Name","Contact Name","Address 1","Address2","Phone" ,"Website","latitude" ,"Longitude" , "Contact Id", "Organization Id");
    //csv file initialized with mode "W"
    $fp = fopen("Data.csv", "w"); 
    fputcsv ($fp, $header, "\t"); // loading the header value into the csv file
    foreach ($arrayToBeParsed as $key => $val) {
        if(is_array($val)) { 
            fputcsv($fp, $val, "\t"); // for each key value pair, loading the value under the header from the array
        } else {
            echo "error";
        }
    }
    fclose($fp); // close csv file
    exit();
?>