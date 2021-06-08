<?
$config = MuxPhp\Configuration::getDefaultConfiguration()
->setUsername(getenv('MUX_TOKEN_ID'))
->setPassword(getenv('MUX_TOKEN_SECRET'));

$liveApi = new MuxPhp\Api\LiveStreamsApi(
  new GuzzleHttp\Client(),
  $config
);

$createAssetRequest = new MuxPhp\Models\CreateAssetRequest(["playback_policy" => [MuxPhp\Models\PlaybackPolicy::PUBLIC_PLAYBACK_POLICY]]);
$createLiveStreamRequest = new MuxPhp\Models\CreateLiveStreamRequest(["playback_policy" => [MuxPhp\Models\PlaybackPolicy::PUBLIC_PLAYBACK_POLICY], "new_asset_settings" => $createAssetRequest]);
$stream = $liveApi->createLiveStream($createLiveStreamRequest);

?>