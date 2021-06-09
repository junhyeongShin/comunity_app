// replace these values with those generated in your TokBox Account
// var apiKey = '45828062';
// var sessionId = '1_MX40NTgyODA2Mn5-MTYyMzEzNzk3MzA1MH54YmZFUEIva1JHNXQyN0M1end2QmFvT3J-UH4';
// var token = 'T1==cGFydG5lcl9pZD00NTgyODA2MiZzaWc9ZWJmOTExNTc0NWE3OWM3ODdhYTdmYWQ5NGYwNWUwNTgzZDAxOTM0MTpzZXNzaW9uX2lkPTFfTVg0ME5UZ3lPREEyTW41LU1UWXlNekV6TnprM016QTFNSDU0WW1aRlVFSXZhMUpITlhReU4wTTFlbmQyUW1GdlQzSi1VSDQmY3JlYXRlX3RpbWU9MTYyMzE0MjM1MCZub25jZT0wLjc0MjE2ODg1MDI4MTA4NDgmcm9sZT1wdWJsaXNoZXImZXhwaXJlX3RpbWU9MTYyMzIyODc1MA==';
var apiKey ;
var sessionId ;
var token ;
// (optional) add server code here
var SERVER_BASE_URL = 'http://localhost/Broadcast/Vonage/server.php';
fetch('/session').then(function(res) {
    return res.json()
  }).then(function(res) {
    apiKey = res.apiKey;
    sessionId = res.sessionId;
    token = res.token;
    initializeSession();
  }).catch(handleError);
initializeSession();

// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

function initializeSession() {
  var session = OT.initSession(apiKey, sessionId);
  // Subscribe to a newly created stream

  // Create a publisher
  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);

  // Replace with the replacement element ID:
  publisher.on({
    streamCreated: function (event) {
      console.log("Publisher started streaming.");
    },
    streamDestroyed: function (event) {
      console.log("Publisher stopped streaming. Reason: "
        + event.reason);
    }
  });

  // Connect to the session
  session.connect(token, function(error) {
    // If the connection is successful, publish to the session
    if (error) {
      handleError(error);
    } else {
      session.publish(publisher, handleError);
    }
  });

  session.on('streamCreated', function(event) {
    session.subscribe(event.stream, 'subscriber', {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    }, handleError);
  });
}

var session;
var connectionCount = 0;

function connect() {
  // Replace apiKey and sessionId with your own values:
  session = OT.initSession(apiKey, sessionId);
  session.on({
    connectionCreated: function (event) {
      connectionCount++;
      console.log(connectionCount + ' connections.');
    },
    connectionDestroyed: function (event) {
      connectionCount--;
      console.log(connectionCount + ' connections.');
    },
    sessionDisconnected: function sessionDisconnectHandler(event) {
      // The event is defined by the SessionDisconnectEvent class
      console.log('Disconnected from the session.');
      document.getElementById('disconnectBtn').style.display = 'none';
      if (event.reason == 'networkDisconnected') {
        alert('Your network connection terminated.')
      }
    }
  });
  // Replace token with your own value:
  session.connect(token, function(error) {
    if (error) {
      console.log('Unable to connect: ', error.message);
    } else {
      document.getElementById('disconnectBtn').style.display = 'block';
      console.log('Connected to the session.');
      connectionCount = 1;
    }
  });
}

function disconnect() {
  session.disconnect();
}

connect();