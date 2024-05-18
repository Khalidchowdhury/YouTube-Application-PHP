<?php

require 'YouTubeService.php';

$youtubeService = new YouTubeService();

$query = isset($_GET['query']) ? $_GET['query'] : '';
$pageToken = isset($_GET['pageToken']) ? $_GET['pageToken'] : '';

$videos = $youtubeService->fetchVideos($query, 50, $pageToken);

echo json_encode($videos);
