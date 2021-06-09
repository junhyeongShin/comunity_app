
<html>
<body>
<!-- OpenTok.js library -->
<script src="https://static.opentok.com/v2/js/opentok.js"></script>
<script>

// credentials
var apiKey = '45828062';
var sessionId = '1_MX40NTgyODA2Mn5-MTYyMzEzNzk3MzA1MH54YmZFUEIva1JHNXQyN0M1end2QmFvT3J-UH4';
var token = 'T1==cGFydG5lcl9pZD00NTgyODA2MiZzaWc9ZWJmOTExNTc0NWE3OWM3ODdhYTdmYWQ5NGYwNWUwNTgzZDAxOTM0MTpzZXNzaW9uX2lkPTFfTVg0ME5UZ3lPREEyTW41LU1UWXlNekV6TnprM016QTFNSDU0WW1aRlVFSXZhMUpITlhReU4wTTFlbmQyUW1GdlQzSi1VSDQmY3JlYXRlX3RpbWU9MTYyMzE0MjM1MCZub25jZT0wLjc0MjE2ODg1MDI4MTA4NDgmcm9sZT1wdWJsaXNoZXImZXhwaXJlX3RpbWU9MTYyMzIyODc1MA==';
// connect to session
var session = OT.initSession(apiKey, sessionId);

// create publisher
var publisher = OT.initPublisher();
session.connect(token, function(err) {
   // publish publisher
  //  This code publishes the audio-video stream to the session using your webcam and microphone.
   session.publish(publisher);
});
  
// create subscriber
//This code allows you to subscribe to new streams published by other clients in the session.
session.on('streamCreated', function(event) {
   session.subscribe(event.stream);
});

</script>
</body>
</html>