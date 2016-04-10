<?php
echo "start";
error_log("NOW callback start.");

// アカウント情報設定
$channel_id = "1462085693";
$channel_secret = "bd98cbb48d7458d7cc3d464ecb924805";
$mid = "uc8ced9e8141d7cca1ef6ea6c9fb51230";

// リソースURL設定
$original_content_url_for_image = "https://tsubasabot.azurewebsites.net/5248.jpg";
$preview_image_url_for_image = "https://tsubasabot.azurewebsites.net/5248.jpg";
$original_content_url_for_video = "[https://www.youtube.com/watch?v=R1gOcj_rFcU]";
$preview_image_url_for_video = "[https://yt3.ggpht.com/-u1m1s3j34kw/AAAAAAAAAAI/AAAAAAAAAAA/kxxnX3pl5Ig/s88-c-k-no-rj-c0xffffff/photo.jpg]";
$original_content_url_for_audio = "[音声URL]";
$download_url_for_rich = "[リッチ画像URL]";

// メッセージ受信
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
$content = $json_object->result{0}->content;
$text = $content->text;
$from = $content->from;
$message_id = $content->id;
$content_type = $content->contentType;

// ユーザ情報取得
api_get_user_profile_request($from);

// メッセージが画像、動画、音声であれば保存
if (in_array($content_type, array(2, 3, 4))) {
    api_get_message_content_request($message_id);
}

// メッセージコンテンツ生成
$image_content = <<< EOM
        "contentType":2,
        "originalContentUrl":"{$original_content_url_for_image}",
        "previewImageUrl":"{$preview_image_url_for_image}"
EOM;
$video_content = <<< EOM
        "contentType":3,
        "originalContentUrl":"{$original_content_url_for_video}",
        "previewImageUrl":"{$preview_image_url_for_video}"
EOM;
$audio_content = <<< EOM
        "contentType":4,
        "originalContentUrl":"{$original_content_url_for_audio}",
        "contentMetadata":{
            "AUDLEN":"240000"
        }
EOM;
$location_content = <<< EOM
        "contentType":7,
        "text":"Convention center",
        "location":{
            "title":"Convention center",
            "latitude":35.61823286112982,
            "longitude":139.72824096679688
        }
EOM;
$sticker_content = <<< EOM
        "contentType":8,
        "contentMetadata":{
          "STKID":"3",
          "STKPKGID":"332",
          "STKVER":"100"
        }
EOM;
$rich_content = <<< EOM
        "contentType": 12,
        "contentMetadata": {
            "DOWNLOAD_URL": "{$download_url_for_rich}",
            "SPEC_REV": "1",
            "ALT_TEXT": "Alt Text.",
            "MARKUP_JSON": "{\"canvas\":{\"width\": 1040, \"height\": 1040, \"initialScene\": \"scene1\"},\"images\":{\"image1\": {\"x\": 0, \"y\": 0, \"w\": 1040, \"h\": 1040}},\"actions\": {\"link1\": {\"type\": \"web\",\"text\": \"Open link1.\",\"params\": {\"linkUri\": \"http://line.me/\"}},\"link2\": {\"type\": \"web\",\"text\": \"Open link2.\",\"params\": {\"linkUri\": \"http://linecorp.com\"}}},\"scenes\":{\"scene1\": {\"draws\": [{\"image\": \"image1\", \"x\": 0, \"y\": 0, \"w\": 1040, \"h\": 1040}],\"listeners\": [{\"type\": \"touch\", \"params\": [0, 0, 1040, 720], \"action\": \"link1\"}, {\"type\": \"touch\", \"params\": [0, 720, 1040, 720], \"action\": \"link2\"}]}}}"
        }
EOM;

// 受信メッセージに応じて返すメッセージを変更
$event_type = "138311608800106203";
if ($text == "image") {
    $content = $image_content;
} else if ($text == "video") {
    $content = $video_content;
} else if ($text == "audio") {
    $content = $audio_content;
} else if ($text == "location") {
    $content = $location_content;
/*
} else if ($text == "sticker") {
    $content = $sticker_content;
*/
} else if ($text == "rich") {
    $content = $rich_content;
} else if ($text == "multi") {
    $event_type = "140177271400161403";
$content = <<< EOM
    "messageNotified": 0,
    "messages": [
        {{$image_content}},
        {{$video_content}},
        {{$audio_content}},
        {{$location_content}},
        {{$rich_content}}
    ]
EOM;
} else { // 上記以外はtext送信
    if ($content_type != 1) {
        $text = "テキスト以外";
    }
$content = <<< EOM
        "contentType":1,
        "text":"なになに、「{$text}」って、どういうことなの？"
EOM;
}
$post = <<< EOM
{
    "to":["{$from}"],
    "toChannel":1383378250,
    "eventType":"{$event_type}",
    "content":{
        "toType":1,
        {$content}
    }
}
EOM;

api_post_request("/v1/events", $post);

error_log("callback end.");
echo "<br>clallback end";

function get_weather_on($city)
{
 return json_deocde(file_get_contents(
  'http://weather.livedoor.com/forecast/webservice/json/v1?city='.$city));
};

function api_post_request($path, $post) {
    $url = "https://trialbot-api.line.me{$path}";
    $headers = array(
        "Content-Type: application/json",
        "X-Line-ChannelID: {$GLOBALS['channel_id']}",
        "X-Line-ChannelSecret: {$GLOBALS['channel_secret']}",
        "X-Line-Trusted-User-With-ACL: {$GLOBALS['mid']}"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curl);
    error_log($output);
    echo "<br>《".$output."》";

    if(curl_errno($curl ))
{
    echo 'Curl error: ' . curl_error($curl );
}
}

function api_get_user_profile_request($mid) {
    $url = "https://trialbot-api.line.me/v1/profiles?mids={$mid}";
    $headers = array(
        "X-Line-ChannelID: {$GLOBALS['channel_id']}",
        "X-Line-ChannelSecret: {$GLOBALS['channel_secret']}",
        "X-Line-Trusted-User-With-ACL: {$GLOBALS['mid']}"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curl);
    error_log($output);
    echo "<br>《".$output."》";
}

function api_get_message_content_request($message_id) {
    $url = "https://trialbot-api.line.me/v1/bot/message/{$message_id}/content";
    $headers = array(
        "X-Line-ChannelID: {$GLOBALS['channel_id']}",
        "X-Line-ChannelSecret: {$GLOBALS['channel_secret']}",
        "X-Line-Trusted-User-With-ACL: {$GLOBALS['mid']}"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curl);
    file_put_contents("/tmp/{$message_id}", $output);
}
echo "<br>"."end.";
?>
