<?php

$accessToken = 'EAANlTRfocxkBAPkhsZBZA2yLbqILNZCeGtJJEUyCppsLIx8m9gyVYjmypXBTBpnKW8uVLzYZA4O9uv0vN7sTqvVGZCfvXGdG43TpZBNJH5cSurRtgEHOlJbSY40jWZAbbJD7hTVDnJALEp9XdfRB7ojGidZCVsf0WRVr6IgYHzq9oZAfuNPI7n3N7ZB2fNTGDsQrsZD';
$accessTokentest = 'EAAGWzxs6ofoBABtuZCDwMG6vamkYmRNFCmZCeAMeWEpI771w54DUsNqc8Oucfu7HYP6GtIX3JvM66r7pMrMZA8qIzOFIkB36lXsfMpdcNMxt2GFrDvulj4KVZBg8yuGXNse0F5bUVTaQOQDVn7nW68DcIIXbCvl77VqsvadzP3YIQIRp2ByLVMRItHoR2hEZD';
$apiversion = 'v5.0';
$ad_campaign_id = '331859797400599'; //Actisweep;
$accountID = 'act_331859797400599';
$account = '570641216770816';
$secret = '3c4ea1d288553fe31e0564e0a3f69172';


require __DIR__ . '/vendor/autoload.php';


$app_secret = '3c4ea1d288553fe31e0564e0a3f69172';
$app_id = '955806718128921';
$id = '365676250584894';

$fb = new \Facebook\Facebook([
    'app_id' => '955806718128921',
    'app_secret' => '1792d172e69dee746210a4ec6456a76c',
    'default_graph_version' => 'v5.0',
]);
//var_dump(get_class_methods ($fb));
try {
    // Returns a `FacebookFacebookResponse` object
    $response = $fb->get(
    // ad_set id : 23843854426790061 RTG - VV nettoyages routes
        '/10158484356634381/adaccounts',
        $accessToken
    );
//    var_dump($response);
    echo '</br>';
    echo '</br>';
    echo '</br>';
} catch (FacebookExceptionsFacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (FacebookExceptionsFacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
$getDecodeBody = $response->getDecodedBody();
//var_dump($getDecodeBody['data']); //=> ARRAY
var_dump(sizeof($getDecodeBody['data']));
var_dump($getDecodeBody['data'][0]['id']);
//var_dump($getDecodeBody['data'][0]['cpc']);


