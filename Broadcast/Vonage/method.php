<?php

require './php/vendor/autoload.php';

use OpenTok\OpenTok;
$apiKey = '4106684';
$apiSecret = '1a45b914aa3ef78baa106032014663d3702bd41a';
$opentok = new OpenTok($apiKey, $apiSecret);
    // Create a session that attempts to use peer-to-peer streaming:
    $session = $opentok->createSession();

    // A session that uses the OpenTok Media Router, which is required for archiving:
    // $session = $opentok->createSession(array( 'mediaMode' => MediaMode::ROUTED ));

    // A session with a location hint:
    // $session = $opentok->createSession(array( 'location' => '77.77.77.77' ));

    // An automatically archived session:
    // $sessionOptions = array(
    //     'archiveMode' => ArchiveMode::ALWAYS,
    //     'mediaMode' => MediaMode::ROUTED
    // );

    // $session = $opentok->createSession($sessionOptions);

    // Store this sessionId in the database for later use
    // $sessionId = $session->getSessionId();

    // print_r($sessionId);


// print_r(create_session());

// function create_session(){

//     // Create a session that attempts to use peer-to-peer streaming:
//     $session = $opentok->createSession();

//     // A session that uses the OpenTok Media Router, which is required for archiving:
//     $session = $opentok->createSession(array( 'mediaMode' => MediaMode::ROUTED ));

//     // A session with a location hint:
//     $session = $opentok->createSession(array( 'location' => '77.77.77.77' ));

//     // An automatically archived session:
//     $sessionOptions = array(
//         'archiveMode' => ArchiveMode::ALWAYS,
//         'mediaMode' => MediaMode::ROUTED
//     );

//     $session = $opentok->createSession($sessionOptions);

//     // Store this sessionId in the database for later use
//     return $sessionId = $session->getSessionId();
// }

// function generate_token($sessionId){


//     // Generate a Token from just a sessionId (fetched from a database)
//     $token = $opentok->generateToken($sessionId);
//     // Generate a Token by calling the method on the Session (returned from createSession)
//     $token = $session->generateToken();

//     // Set some options in a token
//     return $token = $session->generateToken(array(
//         'role'       => Role::MODERATOR,
//         'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
//         'data'       => 'name=Johnny',
//         'initialLayoutClassList' => array('focus')
//     ));

// }

// function get_stream($sessionId,$streamId){

//     // Get stream info from just a sessionId (fetched from a database)
//     $stream = $opentok->getStream($sessionId, $streamId);

//     // Stream properties
//     $stream->id; // string with the stream ID
//     $stream->videoType; // string with the video type
//     $stream->name; // string with the name
//     $stream->layoutClassList; // array with the layout class list

//     return $stream;

// }

// function get_stream_list($sessionId){


//     // Get list of streams from just a sessionId (fetched from a database)
//     $streamList = $opentok->listStreams($sessionId);

//     return $streamList->totalCount(); // total count
// }

// function start_live_stream($sessionId){
//     // Start a live streaming broadcast of a session
//     $broadcast = $opentok->startBroadcast($sessionId);


//     // Start a live streaming broadcast of a session, using broadcast options
//     $options = array(
//         'layout' => Layout::getBestFit(),
//         'maxDuration' => 5400,
//         'resolution' => '1280x720'
//     );
//     $broadcast = $opentok->startBroadcast($sessionId, $options);

//     // Store the broadcast ID in the database for later use
//     $broadcastId = $broadcast->id;    
// }

// function stop_live_stream($broadcastId){
//     // Stop a broadcast from an broadcast ID (fetched from database)
//     $opentok->stopBroadcast($broadcastId);

//     // Stop a broadcast from an Broadcast instance (returned from startBroadcast)
//     $broadcast = $opentok->getBroadcast($broadcastId);
//     $broadcast->stop();   
// }

// function layout_change($archiveId){
//     $layoutType = Layout::getHorizontalPresentation();
//     $opentok->setArchiveLayout($archiveId, $layoutType);
    
//     // For custom Layouts, you can do the following
//     $options = array(
//         'stylesheet' => 'stream.instructor {position: absolute; width: 100%;  height:50%;}'
//     );
    
//     $layoutType = Layout::createCustom($options);
//     $opentok->setArchiveLayout($archiveId, $layoutType);
// }



?>