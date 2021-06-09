var session;

// location.pathname 현재 페이지의 위치를 나타내줌
fetch(location.pathname, { method: "POST" })
  .then(res => {
    return res.json();
  })
  .then(res => {
    const apiKey = res.apiKey;
    const sessionId = res.sessionId;
    const token = res.token;

    initializeSession(apiKey, sessionId, token);
  })
  .catch(handleCallback);

  
function initializeSession(apiKey, sessionId, token) {
  // Create a session object with the sessionId
  session = OT.initSession(apiKey, sessionId);

  // Create a publisher
  const publisher = OT.initPublisher(
    "publisher",
    {
      insertMode: "append",
      width: "100%",
      height: "100%"
    },
    handleCallback
  );
  
  // Connect to the session
  session.connect(token, error => {
    // If the connection is successful, initialize the publisher and publish to the session
    console.log('session.connect')
    if (error) {
      handleCallback(error);
    } else {
      session.publish(publisher, handleCallback);
    }
  });

  // Subscribe to a newly created stream
  session.on("streamCreated", event => {
    const streamContainer =
      event.stream.videoType === "screen" ? "screen" : "subscriber";
      session.subscribe(
      event.stream,
      streamContainer,
      {
        insertMode: "append",
        width: "100%",
        height: "100%"
      },
      handleScreenShare(event.stream.videoType,event.reason)
    );
  });
  session.on("streamDestroyed", event => {
    document.getElementById("screen").classList.remove("sub-active");
  });
}

// Function to handle screenshare layout
function handleScreenShare(streamType, error) {
  if (error) {
    console.log("error: " + error.message);
  } else {
    if (streamType === "screen") {
      document.getElementById("screen").classList.add("sub-active");
    }
  }
}

// Callback handler
function handleCallback(error) {
  if (error) {
    console.log("error: " + error.message);
  } else {
    console.log("callback success");
  }
}

var screenSharePublisher;
const startShareBtn = document.getElementById("startScreenShare");

startShareBtn.addEventListener("click", event => {
  OT.checkScreenSharingCapability(response => {
    console.log("startShareBtn click");

    if (!response.supported || response.extensionRegistered === false) {
      alert("Screen sharing not supported");
    } else if (response.extensionInstalled === false) {
      alert("Browser requires extension");
    } else {
      // session = OT.initSession(apiKey, sessionId);
      screenSharePublisher = OT.initPublisher(
        "screen",
        {
          insertMode: "append",
          width: "100%",
          height: "100%",
          videoSource: "screen",
          publishAudio: true
        },
        handleCallback
      );
      console.log('session',session)
      session.publish(screenSharePublisher, handleCallback);
      // startShareBtn.classList.toggle("hidden");
      // stopShareBtn.classList.toggle("hidden");
      document.getElementById("screen").classList.add("pub-active");
    }
  });
});
const stopShareBtn = document.getElementById("stopScreenShare");
stopShareBtn.addEventListener("click", event => {
  screenSharePublisher.destroy();
  // startShareBtn.classList.toggle("hidden");
  // stopShareBtn.classList.toggle("hidden");
  document.getElementById("screen").classList.remove("pub-active");
});