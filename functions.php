<?php

// General CURL get data function, if redirect = redirect then follow redirect.
function getUrlData($url, $redirect = null) {
    $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $html = curl_exec($ch);
    $redirectURL = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL );
    
    curl_close($ch);

    if ($redirect === 'redirect') {
        return $redirectURL;
    } else {
        return $html;
    }
}


function recordTimeStamp() {

    $date = date('Y-m-d');
    file_put_contents('_data/timestamp.txt', $date);

}

function getTimeStamp() {

    $time = file_get_contents('_data/timestamp.txt');
    return $time;
}

// Get Wiki Data
function getWikiData() {

    $date = date('Y-m-d');
    $saved_time = getTimeStamp();
    $data_file = '_data/wiki.json';

    // If recoreded timestamp != current timestamp: Get new Time, run parse, save data, load from that data.
    if ($date !== $saved_time) {

        recordTimeStamp();

        // wiki page data links
        $wiki_page_link = getUrlData('en.wikipedia.org/wiki/Special:RandomInCategory/Featured_articles', 'redirect');
        $wiki_src_title = str_replace('https://en.wikipedia.org/wiki/', '', $wiki_page_link);

        // Get Page & Meta JSON data
        $meta_url = 'en.wikipedia.org/w/api.php?action=query&titles='. $wiki_src_title .'&indexpageids=&format=json';
        $content_url = 'en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=' . $wiki_src_title;

        $wiki_meta = json_decode(getUrlData($meta_url), true);
        $wiki_content = json_decode(getUrlData($content_url), true);

        // We need to make one call to get page meta info, to get page ID, then use that data to get the content.
        $wiki_data = array(
            "meta" => $wiki_meta,
            "content" => $wiki_content
        );

        // Parse data from wiki array
        $id = $wiki_data['meta']['query']['pageids'][0];
        $title = $wiki_data['content']['query']['pages'][$id]['title'];
        $content = $wiki_data['content']['query']['pages'][$id]['extract'];
        $public_url = 'https://en.wikipedia.org/wiki/' . $wiki_src_title;

        // Create new array with only needed info
        $data = array(
            "wiki_id" => $id,
            "title" => $title,
            "content" => $content,
            "url" => $public_url
        );

        // Save array into file for caching
        file_put_contents($data_file, json_encode($data), true);
        $wiki_data = json_decode(file_get_contents($data_file), true);

    } 
    else 
    {
        // Load saved data within a day period
        $wiki_data = json_decode(file_get_contents($data_file), true);
    }

    // Return Data Array
    return $wiki_data;
}




?>