/*
          Get these from WowzaStreamingEngine WebRTC Application
        */
        let applicationName = "";
        let streamName      = "";
        let wssUrl          = "";
        let selected_stream ;
        var is_send = false;
        var is_camera = false;
        var is_display = false;

        // aName,sName,wUrl을 셋팅해준다.
        // 파라미터 값들은 웹소켓 연결에 사용된다.

        function set(aName,sName,wUrl) {
          applicationName = aName;
          streamName      = sName;
          wssUrl          = wUrl;

          console.log('setting_wowza');
          console.log(applicationName);
          console.log(streamName);
          console.log(wssUrl);
        };
  
          /*
            information associated with the browser media and WebSocket Connection
            비디오와 오디오 설정을 해주는 부분 but, webrtc에서는 안먹혀서
            따로 설정을 해준상태.
          */
          let constraints     = {
                                video: {
                                  width: { min: "640", ideal: "1280", max: "1920" },
                                  height: { min: "360", ideal: "720", max: "1080" },
                                  frameRate: "30"
                                  },
                                audio: true,
                              }
  
          /*
            Info for SDP munging
          */
          let browserDetails = window.adapter.browserDetails;

          /*
            미디어 정보부분
            Bitrate * 1000 의 값을 해주기 때문에 KB 단위로 적어주면 된다.
          */
          let mediaInfo = {
            videoBitrate: "3500",
            audioBitrate: "64",
            videoFrameRate: "30",
            videoCodec: "42e01f",
            audioCodec: "opus"
          }

          let SDPOutput;
          let videoChoice;
          let audioChoice;
          let videoIndex;
          let audioIndex;
  
          /*
            Client connection and media details
          */
          let cameras         = [];
          let microphones     = [];
          let wsConnection,localStream,peerConnection,peerConnectionConfig,videoElement,streamInfo,userData = null;
          let iceCandidates;
          var state;
          // (function(i, s, o, g, r, a, m) {
          //   i['GoogleAnalyticsObject']=r; i[r]=i[r]||function() {
          //     (i[r].q=i[r].q||[]).push(arguments);
          //   }, i[r].l=1*new Date(); a=s.createElement(o),
          //     m=s.getElementsByTagName(o)[0]; a.async=1; a.src=g; m.parentNode.insertBefore(a, m);
          //   })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            
            // ga('create', 'UA-48530561-1', 'auto');
            // ga('send', 'pageview');
            
            if (adapter.browserDetails.browser == 'firefox') {
              adapter.browserShim.shimGetDisplayMedia(window, 'screen');
            }
            
            // function handleSuccess(stream) {
            //   const video = document.querySelector('video');
            //   video.srcObject = stream;
            //   console.log(stream);
            //   // demonstrates how to detect that the user has stopped
            //   // sharing the screen via the browser UI.
            //   stream.getVideoTracks()[0].addEventListener('ended', () => {
            //     errorMsg('The user has ended sharing the screen');
            //   });
            // }
            
            function handleError(error) {
              errorMsg(error);
            }
            
            function errorMsg(error) {
                console.error(error);
            }
            
            const startButton = document.getElementById('startButton');
            startButton.addEventListener('click', () => {
              // if(wsConnection!==null){
              //    wsConnection.close();
              // }
              is_display = true;
              is_camera = false;
              console.log('startButton');

              start_streaming();
            });

            const camButton = document.getElementById('camButton');
            camButton.addEventListener('click', () => {
              // if(wsConnection!==null){
              //    wsConnection.close();
              // }
              is_display = false;
              is_camera = true;
              console.log('camButton');

              start_streaming();
            });
            
            const sendButton = document.getElementById('sendButton');
            sendButton.addEventListener('click', () => {

              wsConnect();
          
            });

            const top_img = document.getElementById('publish_top_img');
            

            const closeButton = document.getElementById('closeButton');
            closeButton.addEventListener('click', () => {
              console.log('closeButton');
              peerConnection.close();
              top_img.src = './img_live_ready.GIF';
              is_send = false;
            });
            
            if ((navigator.mediaDevices && 'getDisplayMedia' in navigator.mediaDevices)) {
              startButton.disabled = false;
            } else {
              errorMsg('getDisplayMedia is not supported');
            }
            
          /*
            Munging
          */
  
          const gotDescription = (description) =>
          {
            // console.log("gotDescription: SDP:");
            // console.log(description.sdp+'');
  
            let mungeData = new Object();
  
            if (mediaInfo.audioBitrate != null)
              mungeData.audioBitrate = mediaInfo.audioBitrate;
            if (mediaInfo.videoBitrate != null)
              mungeData.videoBitrate = mediaInfo.videoBitrate;
            if (mediaInfo.videoFrameRate != null)
              mungeData.videoFrameRate = mediaInfo.videoFrameRate;
            if (mediaInfo.videoCodec != null)
              mungeData.videoCodec = mediaInfo.videoCodec;
            if (mediaInfo.audioCodec != null)
              mungeData.audioCodec = mediaInfo.audioCodec;
  
            if (mungeSDP != null)
            {
              description.sdp = mungeSDP(description.sdp, mungeData);
            }
  
            // console.log("gotDescription: Setting local description SDP: ");
            // console.log(description.sdp);
  
  
            peerConnection
              .setLocalDescription(description)
              .then(() => wsConnection.send('{"direction":"publish", "command":"sendOffer", "streamInfo":' + JSON.stringify(streamInfo) + ', "sdp":' + JSON.stringify(description) + ', "userData":' + JSON.stringify(userData) + '}'))
              .catch((error)=>{
                console.log("Peer connection failed: "+error);
              });
          }
  
          const addAudio = (sdpStr, audioLine) =>
          {
            let sdpLines = sdpStr.split(/\r\n/);
            let sdpSection = 'header';
            let hitMID = false;
            let sdpStrRet = '';
            let done = false;
  
            for (let sdpIndex in sdpLines) {
              let sdpLine = sdpLines[sdpIndex];
  
              if (sdpLine.length <= 0)
                continue;
  
              sdpStrRet += sdpLine;
              sdpStrRet += '\r\n';
  
              if ('a=rtcp-mux'.localeCompare(sdpLine) == 0 && done == false) {
                sdpStrRet += audioLine;
                done = true;
              }
            }
            return sdpStrRet;
          }
  
          const addVideo = (sdpStr, videoLine) =>
          {
            let sdpLines = sdpStr.split(/\r\n/);
            let sdpSection = 'header';
            let hitMID = false;
            let sdpStrRet = '';
            let done = false;
  
            let rtcpSize = false;
            let rtcpMux = false;
  
            for (let sdpIndex in sdpLines) {
              let sdpLine = sdpLines[sdpIndex];
  
              if (sdpLine.length <= 0)
                continue;
  
              if (sdpLine.includes("a=rtcp-rsize")) {
                rtcpSize = true;
              }
  
              if (sdpLine.includes("a=rtcp-mux")) {
                rtcpMux = true;
              }
  
            }
  
            for (let sdpIndex in sdpLines) {
              let sdpLine = sdpLines[sdpIndex];
  
              sdpStrRet += sdpLine;
              sdpStrRet += '\r\n';
  
              if (('a=rtcp-rsize'.localeCompare(sdpLine) == 0) && done == false && rtcpSize == true) {
                sdpStrRet += videoLine;
                done = true;
              }
  
              if ('a=rtcp-mux'.localeCompare(sdpLine) == 0 && done == true && rtcpSize == false) {
                sdpStrRet += videoLine;
                done = true;
              }
  
              if ('a=rtcp-mux'.localeCompare(sdpLine) == 0 && done == false && rtcpSize == false) {
                done = true;
              }
  
            }

            return sdpStrRet;
          }
  
          // Filter codec offerings
          const deliverCheckLine = (profile, type) =>
          {
            for (let line in SDPOutput) {
              let lineInUse = SDPOutput[line];
              if (lineInUse.includes(profile)) {
                if (profile.includes("VP9") || profile.includes("VP8")) {
                  let output = "";
                  let outputs = lineInUse.split(/\r\n/);
                  for (let position in outputs) {
                    let transport = outputs[position];
                    // NOTE: This block of code is needed for WSE versions older than 4.8.5
                    // if (transport.indexOf("a=extmap") !== -1 ||
                    //   transport.indexOf("transport-cc") !== -1 ||
                    //   transport.indexOf("goog-remb") !== -1 ||
                    //   transport.indexOf("nack") !== -1) {
                    //   continue;
                    // }
                    output += transport;
                    output += "\r\n";
                  }
  
                  if (type.includes("audio")) {
                    audioIndex = line;
                  }
  
                  if (type.includes("video")) {
                    videoIndex = line;
                  }
  
                  return output;
                }
                if (type.includes("audio")) {
                  audioIndex = line;
                }
  
                if (type.includes("video")) {
                  videoIndex = line;
                }
  
                return lineInUse;
              }
            }
            return '';
          }
  
          const checkLine = (line) =>
          {
            if (line.startsWith("a=rtpmap") || line.startsWith("a=rtcp-fb") || line.startsWith("a=fmtp")) {
              let res = line.split(":");
  
              if (res.length > 1) {
                let number = res[1].split(" ");
                if (!isNaN(number[0])) {
                  if (!number[1].startsWith("http") && !number[1].startsWith("ur")) {
                    let currentString = SDPOutput[number[0]];
                    if (!currentString) {
                      currentString = "";
                    }
                    currentString += line + "\r\n";
                    SDPOutput[number[0]] = currentString;
                    return false;
                  }
                }
              }
            }
  
            return true;
          }
  
          const getrtpMapID = (line) =>
          {
            let findid = new RegExp('a=rtpmap:(\\d+) (\\w+)/(\\d+)');
            let found = line.match(findid);
            return (found && found.length >= 3) ? found : null;
          }
  
          const mungeSDP = (sdpStr, mungeData) =>
          {
  
            SDPOutput = new Object();
            videoChoice = "42e01f";
            audioChoice = "opus";
            videoIndex = -1;
            audioIndex = -1;
  
            let sdpLines = sdpStr.split(/\r\n/);
  
            let sdpSection = 'header';
            let hitMID = false;
            let sdpStrRet = '';
  
            if (mungeData.videoCodec != null && mungeData.videoCodec !== '')
              videoChoice = mungeData.videoCodec;
            if (mungeData.audioCodec != null && mungeData.audioCodec !== '')
              audioChoice = mungeData.audioCodec;
  
            // Deliver the requested codecs
            for (let sdpIndex in sdpLines) {
              let sdpLine = sdpLines[sdpIndex];
  
              if (sdpLine.length <= 0)
                continue;
  
              let doneCheck = checkLine(sdpLine);
              if (!doneCheck)
                continue;
  
              sdpStrRet += sdpLine;
              sdpStrRet += '\r\n';
  
            }

            sdpStrRet = addAudio(sdpStrRet, deliverCheckLine(audioChoice, "audio"));
            sdpStrRet = addVideo(sdpStrRet, deliverCheckLine(videoChoice, "video"));
            sdpStr = sdpStrRet;
            sdpLines = sdpStr.split(/\r\n/);
            sdpStrRet = '';
  
            for (let sdpIndex in sdpLines) {
              let sdpLine = sdpLines[sdpIndex];
  
              if (sdpLine.length <= 0)
                continue;
  
              if (browserDetails.browser === 'chrome') {
                let audioMLines;
                if (sdpLine.indexOf("m=audio") == 0 && audioIndex !== -1) {
                  audioMLines = sdpLine.split(" ");
                  sdpStrRet += audioMLines[0] + " " + audioMLines[1] + " " + audioMLines[2] + " " + audioIndex + "\r\n";
                  continue;
                }
  
                if (sdpLine.indexOf("m=video") == 0 && videoIndex !== -1) {
                  audioMLines = sdpLine.split(" ");
                  sdpStrRet += audioMLines[0] + " " + audioMLines[1] + " " + audioMLines[2] + " " + videoIndex + "\r\n";
                  continue;
                }
              }
  
              sdpStrRet += sdpLine;
  
              if (sdpLine.indexOf("m=audio") === 0) {
                sdpSection = 'audio';
                hitMID = false;
              }
              else if (sdpLine.indexOf("m=video") === 0) {
                sdpSection = 'video';
                hitMID = false;
              }
              else if (sdpLine.indexOf("a=rtpmap") == 0) {
                sdpSection = 'bandwidth';
                hitMID = false;
              }
  
              if (browserDetails.browser === 'chrome') {
                if (sdpLine.indexOf("a=mid:") === 0 || sdpLine.indexOf("a=rtpmap") == 0) {
                  if (!hitMID) {
                    if ('audio'.localeCompare(sdpSection) == 0) {
                      if (mungeData.audioBitrate !== undefined) {
                        sdpStrRet += '\r\nb=CT:' + (mungeData.audioBitrate);
                        sdpStrRet += '\r\nb=AS:' + (mungeData.audioBitrate);
                      }
                      hitMID = true;
                    }
                    else if ('video'.localeCompare(sdpSection) == 0) {
                      if (mungeData.videoBitrate !== undefined) {
                        sdpStrRet += '\r\nb=CT:' + (mungeData.videoBitrate);
                        sdpStrRet += '\r\nb=AS:' + (mungeData.videoBitrate);
                        if (mungeData.videoFrameRate !== undefined) {
                          sdpStrRet += '\r\na=framerate:' + mungeData.videoFrameRate;
                        }
                      }
                      hitMID = true;
                    }
                    else if ('bandwidth'.localeCompare(sdpSection) == 0) {
                      let rtpmapID;
                      rtpmapID = getrtpMapID(sdpLine);
                      if (rtpmapID !== null) {
                        let match = rtpmapID[2].toLowerCase();
                        if (('vp9'.localeCompare(match) == 0) || ('vp8'.localeCompare(match) == 0) || ('h264'.localeCompare(match) == 0) ||
                          ('red'.localeCompare(match) == 0) || ('ulpfec'.localeCompare(match) == 0) || ('rtx'.localeCompare(match) == 0)) {
                          if (mungeData.videoBitrate !== undefined) {
                            sdpStrRet += '\r\na=fmtp:' + rtpmapID[1] + ' x-google-min-bitrate=' + (mungeData.videoBitrate) + ';x-google-max-bitrate=' + (mungeData.videoBitrate);
                          }
                        }
  
                        if (('opus'.localeCompare(match) == 0) || ('isac'.localeCompare(match) == 0) || ('g722'.localeCompare(match) == 0) || ('pcmu'.localeCompare(match) == 0) ||
                          ('pcma'.localeCompare(match) == 0) || ('cn'.localeCompare(match) == 0)) {
                          if (mungeData.audioBitrate !== undefined) {
                            sdpStrRet += '\r\na=fmtp:' + rtpmapID[1] + ' x-google-min-bitrate=' + (mungeData.audioBitrate) + ';x-google-max-bitrate=' + (mungeData.audioBitrate);
                          }
                        }
                      }
                    }
                  }
                }
              }
  
              if (browserDetails.browser === 'firefox' || browserDetails.browser === 'safari') {
                if ( sdpLine.indexOf("c=IN") ==0 )
                {
                  if ('audio'.localeCompare(sdpSection) == 0)
                  {
                    if (mungeData.audioBitrate !== '') {
                      sdpStrRet += "\r\nb=TIAS:"+(Number(mungeData.audioBitrate)*1000)+"\r\n";
                      sdpStrRet += "b=AS:"+(Number(mungeData.audioBitrate)*1000)+"\r\n";
                      sdpStrRet += "b=CT:"+(Number(mungeData.audioBitrate)*1000)+"\r\n";
                    }
                    continue;
                  }
                  if ('video'.localeCompare(sdpSection) == 0)
                  {
                    if (mungeData.videoBitrate !== '') {
                      sdpStrRet += "\r\nb=TIAS:"+(Number(mungeData.videoBitrate)*1000)+"\r\n";
                      sdpStrRet += "b=AS:"+(Number(mungeData.videoBitrate)*1000)+"\r\n";
                      sdpStrRet += "b=CT:"+(Number(mungeData.videoBitrate)*1000)+"\r\n";
                    }
                    continue;
                  }
                }
              }
  
              sdpStrRet += '\r\n';
            }
            return sdpStrRet;
          }
  
          /*
            Peer Connection
          */
  
          /*
            Web Socket Connection
            첫 시도이면 웹소켓을 생성하여 연결한다.
             peerconection도 생성하여 스트림을 적용시킴
             sdp를 생성하여 적용
             
            만약 현재 연결중이라면 송출하는 스트림을 변경하여준다.
          */
          const wsConnect = () =>
          {
            if(!is_send){
              console.log("wsConnect start");
              let _this = this;
              let repeaterRetryCount;
    
              userData = { 'iceServers': [] };
              streamInfo = { applicationName, streamName };
              peerConnection = new RTCPeerConnection(userData);

              try
              {
                wsConnection = new WebSocket(wssUrl);
              }
              catch(e)
              {
                console.log(e);
                return;
              }
    
              wsConnection.binaryType = 'arraybuffer';
    
              wsConnection.onopen = () => {
                console.log("wsConnection.onopen");

    
                videoSender = undefined;
                audioSender = undefined;
    
                peerConnection.onicecandidate = (event) => {
                  if (event.candidate != null) {
                    console.log('gotIceCandidate: ' + JSON.stringify({ 'ice': event.candidate }));
                  }
                }

                peerConnection.onnegotiationneeded = (event) => {
                  peerConnection.createOffer(gotDescription, (e) => (console.log(e)));
                }
                

                if(localStream===undefined){
                  console.log('undefined')
                  alert('송출할 방송이 없습니다.')
                  return
                }

                peerConnection.addStream(localStream);
                selected_stream = localStream;

                //   let localTracks = localStream.getTracks();
                //   console.log('localStream : ',localStream)
  
                // for (let localTrack in localTracks) {
                //   let sender = peerConnection.addTrack(localTracks[localTrack], localStream);
                //   if (localTracks[localTrack].type === 'audio')
                //   {
                //     audioSender = sender;
                //     console.log(localTracks[localTrack].type)
                //   }
                //   else if (localTracks[localTrack].type === 'video')
                //   {
                //     videoSender = sender;
                //     console.log(localTracks[localTrack].type)
                //   }
                // }
              }
    
              wsConnection.onmessage = (evt) => {
                console.log("wsConnection.onmessage: " + evt.data);

    
                var msgJSON = JSON.parse(evt.data);
                var msgStatus = Number(msgJSON['status']);
                var msgCommand = msgJSON['command'];
  
                if (msgStatus != 200) {
                  stop();
                  // console.log({message:msgJSON['statusDescription']});
                  console.log(msgJSON);
                }
                else {
                  var sdpData = msgJSON['sdp'];
                  if (sdpData !== undefined) {
    
                    var mungeData = new Object();
    
                    if (mediaInfo.audioBitrate !== undefined)
                      mungeData.audioBitrate = mediaInfo.audioBitrate;
                    if (mediaInfo.videoBitrate !== undefined)
                      mungeData.videoBitrate = mediaInfo.videoBitrate;
                    // console.log(sdpData.sdp);
                    // console.log('mungeData : ',mungeData);

                    //응답받은 sdp를 등록하여준다.
                    //등록 완료되면 연결 완료
                    peerConnection
                      .setRemoteDescription(new RTCSessionDescription(sdpData),
                        () => { },
                        (e) => console.log(e)
                      );


                  }
    
                  iceCandidates = msgJSON['iceCandidates'];
                  if (iceCandidates !== undefined) {
                    for (var index in iceCandidates) {
                      console.log('wsConnection.iceCandidates: ' + iceCandidates[index]);
                      peerConnection.addIceCandidate(new RTCIceCandidate(iceCandidates[index]));
                    }
                  }


  
                  top_img.src = './img_live_on.GIF';
                  is_send = true;
  
                }
              }
                
              wsConnection.onerror = (error) => {
                console.log('wsConnection.onerror');
                console.log(error);
                let message = "Websocket connection failed: " + wssUrl;
                console.log(message);
              }

              wsConnection.onclose = () => {
                console.log('wsConnection.onclose');
              }
            }else{
              console.log("wsConnect change");

              // peerConnection.onicecandidate = (event) => {
              //   if (event.candidate != null) {
              //     console.log('gotIceCandidate: ' + JSON.stringify({ 'ice': event.candidate }));
              //   }
              // }
              // console.log('onicecandidate end state : ',state);


              // peerConnection.onnegotiationneeded = (event) => {
              //   peerConnection.createOffer(gotDescription, (e) => (console.log(e)));
              // }

              // peerConnection.addStream(localStream);
              if(is_mask){
                replaceStream(peerConnection,canvas_stream);
              }else{
                replaceStream(peerConnection,localStream);
              }


            }
            


          }

          /*
            replaceStream Media Streams
          */

          function replaceStream(peerConnection, localStream) {
            for(sender of peerConnection.getSenders()){
                if(sender.track.kind == "audio") {
                    if(localStream.getAudioTracks().length > 0){
                        sender.replaceTrack(localStream.getAudioTracks()[0]);
                    }
                }
                if(sender.track.kind == "video") {
                    if(localStream.getVideoTracks().length > 0){
                        sender.replaceTrack(localStream.getVideoTracks()[0]);
                    }
                }
            }
          }

          /*
            Client Media Streams
            Returns Promise
            Sets localStream with result of getUserMedia
          */
  
          const getUserMedia = () =>
          {
            return new Promise((resolve,reject) => {
  
              console.log('getUserMedia');

              if (videoElement == null)
              {
                reject({message:"videoElementPublish not set"});
              }
  
              const getUserMediaSuccess = (stream) =>
              {
                console.log('getUserMediaSuccess');

                localStream = stream;
                // localStream = canvas_stream;
                try
                {
                  videoElement.srcObject = stream;
                }
                catch (error)
                {
                  console.log('getUserMediaSuccess: error connecting stream to videoElement, trying createObjectURL');
                  console.log(error);
                  videoElement.src = window.URL.createObjectURL(stream);
                }
                resolve();
              }
  
              if (navigator.mediaDevices.getUserMedia&&is_camera)
              {
              navigator.mediaDevices.getUserMedia(
                {
                  video:
                    { 
                      width: 1280, 
                      height: 720 
                    },
                  audio: true
                  })
                  .then(getUserMediaSuccess, handleError);
              }
              else if (navigator.mediaDevices.getUserMedia&&is_display)
              {
                navigator.mediaDevices.getDisplayMedia(
                  {
                    video:
                      { 
                        width: 1280, 
                        height: 720 
                      },
                    audio: true
                    })
                  .then(getUserMediaSuccess, handleError);
              }
              

              else if (navigator.getUserMedia)
              {
                navigator.getUserMedia(currentState.constraints, getUserMediaSuccess, (error) => {
                  errorHandler(error);
                  reject(error);
                });
              }
              else
              {
                errorHandler({message:"Your browser does not support WebRTC"});
                reject();
              }
            });
          }
  
          /*
            Client Devices
            Returns Promise
            sets the camera and microphone variables ( in this example we just grab the first ones off the list but you can impliment some sort of form element to select which AV inputs to use)
          */
          const getDevices = () =>
          {
            console.log('getDevices');
            return new Promise((resolve,reject) =>
            {
              navigator.mediaDevices.enumerateDevices().then((devices) =>
              {
                console.log(JSON.stringify(devices));
                for(var i = 0; i < devices.length; i++){
                  if(devices[i].kind === 'videoinput'){
                    cameras.push(devices[i]);
                  }else if (devices[i].kind === 'audioinput') {
                    microphones.push(devices[i]);
                  }
                }
                resolve();
              }).catch(
                (e) => {
                  console.log("unable to detect AV devices: " + e);
                  reject(e);
                }
              );
            });
          }
  
          /*
            initialize and publish, wire in publish button here
          */
          function start_streaming() {
            
            console.log('start_streaming');

            if((applicationName == "") || (streamName == "" || wssUrl == "")){
              alert("송출할 방송이 없습니다.");
            }else {
              // getDevices().then(() => {
                /*
                Wire in selection of client microphone and camera here or in other initialize step of your choice
                */
               //마이크의 경우 선택할 수 있게 보여주기
               //비디오의 경우 2가지 화면 모두 보이게.
               
               //  constraints.video = Object.assign({},constraints.video,{deviceId: cameras[0].deviceId});
               //  constraints.audio = Object.assign({},constraints.audio,{deviceId: microphones[0].deviceId});
               
              videoElement = document.getElementById("publish-video");
                // videoElement = document.getElementById("canvas");
              getUserMedia().then(() => {
                  //  console.log('getUserMedia().then(() => {');
                  // wsConnect();

                  if(is_send){
                    wsConnect();
                  }

              });
              // })
            }
          }