// replace these values with those generated in your TokBox Account
var apiKey = '45828062';
var sessionId = '1_MX40NTgyODA2Mn5-MTYyMzEzNzk3MzA1MH54YmZFUEIva1JHNXQyN0M1end2QmFvT3J-UH4';
var token = 'T1==cGFydG5lcl9pZD00NTgyODA2MiZzaWc9ZWJmOTExNTc0NWE3OWM3ODdhYTdmYWQ5NGYwNWUwNTgzZDAxOTM0MTpzZXNzaW9uX2lkPTFfTVg0ME5UZ3lPREEyTW41LU1UWXlNekV6TnprM016QTFNSDU0WW1aRlVFSXZhMUpITlhReU4wTTFlbmQyUW1GdlQzSi1VSDQmY3JlYXRlX3RpbWU9MTYyMzE0MjM1MCZub25jZT0wLjc0MjE2ODg1MDI4MTA4NDgmcm9sZT1wdWJsaXNoZXImZXhwaXJlX3RpbWU9MTYyMzIyODc1MA==';

var session;
var publisher;

if (session.capabilities.publish == 1) {
  // The client can publish. See the next section.
} else {
  // The client cannot publish.
  // You may want to notify the user.
}

// Replace with the replacement element ID:
publisher = OT.initPublisher(replacementElementId);
publisher.on({
  streamCreated: function (event) {
    console.log("Publisher started streaming.");
  },
  streamDestroyed: function (event) {
    console.log("Publisher stopped streaming. Reason: "
      + event.reason);
  }
});

// Replace apiKey and sessionID with your own values:
session = OT.initSession(apiKey, sessionID);
// Replace token with your own value:
session.connect(token, function (error) {
  if (session.capabilities.publish == 1) {
    session.publish(publisher);
  } else {
    console.log("You cannot publish an audio-video stream.");
  }
});