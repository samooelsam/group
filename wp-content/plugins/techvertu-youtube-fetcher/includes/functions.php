<?php 
function techvertu_youtube_api_call($transitName, $channelID, $maxResults, $API_key, $youtubeAPIBaseUrl, $channelName){
    $storedData = get_transient($transitName);
    if(empty($storedData)){
        $youtubeData = file_get_contents($youtubeAPIBaseUrl.'?order=date&part=snippet&channelId='.$channelID.'&maxResults='.$maxResults.'&key='.$API_key.'');
        $video_list = json_decode($youtubeData);
        set_transient($transitName, $video_list, DAY_IN_SECONDS);
        techvertu_showing_youtube_data($storedData, $channelID, $channelName);
    }
    else{
        techvertu_showing_youtube_data($storedData, $channelID, $channelName);
    }

}
function techvertu_showing_youtube_data($storedData, $channelID, $channelName){
    echo('<div class="youtube-vids-wrapper clearfix">');
    foreach ($storedData->items as $item) {
        if (isset($item->id->videoId)) {
            echo '<div class="jfh-youtube-item clearfix">
                    <iframe width="280" height="150" src="https://www.youtube.com/embed/'.$item->id->videoId.'" frameborder="0" allowfullscreen></iframe>
                    <h2>'. $item->snippet->title .'</h2>
                </div>';
        } 
    }
    if($storedData){
        echo('<div class="more-link-wrapper clearfix"><a target="_blank" href="https://www.youtube.com/channel/'.$channelID.'">'.$channelName.'</a></div>');
    } 
    echo('</div>');
}
function jfh_scripts()
{
    wp_enqueue_style('jfh-styles', TECH_FETCHER_URL . 'assets/css/style.css', '0.1.0', 'all');
}
add_action('wp_enqueue_scripts', 'jfh_scripts');