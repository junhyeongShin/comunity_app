

var canvasCtx = canvas.getContext('2d');

let classifier;

let faceDetectionModel;
async function loadFaceDetectionModel() {
  console.log("loading face detection model");
  await blazeface.load().then(m => {
    faceDetectionModel = m;
    console.log("face detection model loaded");
  });
}

let maskDetectionModel;
async function loadMaskDetectionModel() {
  console.log("loading mask detection model");

  console.log("using pre-trained model")
  await tf.loadLayersModel(web_url_for_model+'model_face.json').then(m => {
    maskDetectionModel = m;
    console.log("Pre trained mask detection model loaded");
  });
}

let new_maskDetectionModel;
async function loadMaskDetectionModel_2() {
  console.log("새로운 마스크 모델 로딩");
  console.log("web_url_for_model",web_url_for_model);

  // new_maskDetectionModel = ml5.featureExtractor('MobileNet', modelReady);
  // classifier = mobilenet.classification(img, videoReady);
  await tf.loadLayersModel(web_url_for_model+'model_face.json').then(m => {
  // await mobilenet.load(web_url_for_model+'model_mask.json').then(m => {
  // await mobilenet.load().then(m => {
    new_maskDetectionModel = m;
    console.log("Pre trained mask detection model loaded");
  });
}

// mobilenet = ml5.featureExtractor('MobileNet', modelReady);
// classifier = mobilenet.classification(video, videoReady);

// function modelReady() {
//   console.log('Model is ready!!!');
//   classifier.load('model.json', customModelReady);
// }

const returnTensors = false;
const flipHorizontal = false;
const annotateBoxes = true;

const offset = tf.scalar(127.5);

const decisionThreshold = 0.9;

// const loadingModel = document.getElementById('loading-model');

async function renderPrediction() {
  // Get image from webcame
  let img = tf.tidy(() => tf.browser.fromPixels(vid));
  // console.log(img);
  
  // Detect faces
  let faces = [];
  try {
    faces = await faceDetectionModel.estimateFaces(img, returnTensors, flipHorizontal, annotateBoxes);
    // console.log('faces');
    // console.log(faces[0])
  } catch (e) {
    console.error("estimateFaces:", e);
    return;
  }

  if (faces.length > 0&& is_mask) {
    // TODO: Loop through all predicted faces and detect if mask used or not.
    // RIght now, it only highlights the fisrt face into the live view. (See the break command below)
    for (let i = 0; i < faces.length; i++) {
      let predictions = [];
      let predictions_mask;
      var is_check = true;

      // let face = tf.tidy(() => img.resizeNearestNeighbor([224, 224])
      //   .toFloat().sub(offset).div(offset).expandDims(0));
            /*
    `predictions` is an array of objects describing each detected face, for example:

    [
      {
        topLeft: [232.28, 145.26],
        bottomRight: [449.75, 308.36],
        probability: [0.998],
        landmarks: [
          [295.13, 177.64], // right eye
          [382.32, 175.56], // left eye
          [341.18, 205.03], // nose
          [345.12, 250.61], // mouth
          [252.76, 211.37], // right ear
          [431.20, 204.93] // left ear
        ]
      }
    ]
    */


      const start = faces[i].topLeft;
      const end = faces[i].bottomRight;

      const left_eye = faces[i].landmarks[0];
      const right_eye = faces[i].landmarks[1];
      const nose = faces[i].landmarks[2];
      const mouth = faces[i].landmarks[3];
      // console.log('nose');
      // console.log(nose);

      // const size = [end[0] - start[0], end[1] - start[1]];
      const size = [end[0] - start[0], end[1] - start[1]];

      canvasCtx.clearRect(0, 0, canvas.width, canvas.height);

      let faceBoxStyle = "rgba(255, 0, 0, 0.25)";
      let label = "without mask";

      canvasCtx.drawImage(vid, 0, 0, canvas.width, canvas.height);

      var eye;
      if(left_eye[1] >= right_eye[1] ){
        eye = left_eye[1];
      }else{
        eye = right_eye[1];
      }
      var eyes = left_eye[1] + right_eye[1];
      var height_eye_nose = nose[1] - eye ;
      var height_mouth = mouth[1] - end[1] ;


      var imageData = canvasCtx.getImageData(start[0], eye, end[0] - start[0], height_eye_nose);

      var img_part = tf.tidy(() => tf.browser.fromPixels(imageData));

      var face_part = tf.tidy(() => img_part.resizeNearestNeighbor([224, 224])
        .toFloat().sub(offset).div(offset).expandDims(0));

      // var imageData_mouth = canvasCtx.getImageData(start[0], mouth[1], end[0] - start[0], height_mouth);

      // var img_part_mouth = tf.tidy(() => tf.browser.fromPixels(imageData_mouth));
  
      // var face_part_mouth = tf.tidy(() => img_part_mouth.resizeNearestNeighbor([224, 224])
      //     .toFloat().sub(offset).div(offset).expandDims(0));

        // console.log("right_eye[1]",right_eye[1])
        // console.log("left_eye[1]",left_eye[1])
        // console.log("nose[1]",nose[1])

      try {
        predictions_mask = await new_maskDetectionModel.predict(face_part).data();
        // predictions = await new_maskDetectionModel.predict(face_part_mouth).data();
        // console.log("maskDetection:", predictions_mask[0]);
        // console.log("maskDetection:", predictions_mask[0]['probability']);
      } catch (e){
        console.error("maskDetection:", e);
        return;
      }

      // face.dispose();
      face_part.dispose();


      if (predictions_mask.length > 0) {
        // if (predictions[0] > decisionThreshold && predictions_mask[0]>0.65) {

        // if (predictions_mask[0] > decisionThreshold&&predictions[0]> decisionThreshold) {
        if (predictions_mask[0] > decisionThreshold) {
          faceBoxStyle = "rgba(0, 255, 0, 0.25)";
          label = `Mask: ${Math.floor(predictions_mask[0] * 1000) / 10}%`;
        } else {
          label = `No Mask: ${Math.floor(predictions_mask[1] * 1000) / 10}%`;
        }

        if(end[0] - start[0]<450){
          label = '좀더 가까이 와 주세요';
          is_check = false;
        }else{
          if(eye+50>nose[1]) {
            label = '정면을 바라봐 주세요';
            is_check = false;
          } else if(eye+50>nose[1]) {
            label = '정면을 바라봐 주세요';
            is_check = false;
          }
        }

          // Render label and its box
          canvasCtx.fillStyle = "rgba(255, 111, 0, 0.85)";
          canvasCtx.fillRect(start[0], start[1] - 23, size[0], 23);
          canvasCtx.font = "30px Raleway";
          canvasCtx.fillStyle = "rgba(255, 255, 255, 1)";
          canvasCtx.fillText(label, end[0] + 5, start[1] - 5);
          
          if(!is_check){
            break;
          }
          
          canvasCtx.fillStyle = faceBoxStyle;
          canvasCtx.fillRect(start[0], start[1], size[0], size[1]);
          canvasCtx.fillStyle = "rgba(0, 0, 255, 0.85)";
          // canvasCtx.fillRect(nose[0], nose[1], size[0]/100, size[1]/100);
          // canvasCtx.fillRect(left_eye[0], left_eye[1], size[0]/100, size[1]/100); 
          // canvasCtx.fillRect(right_eye[0], right_eye[1], size[0]/100, size[1]/100);
          // canvasCtx.fillRect(mouth[0], mouth[1], size[0]/100, size[1]/100);
          // canvasCtx.fillStyle = "rgba(255, 0, 0, 0.2)";
          // var eye;
          // if(left_eye[1] >= right_eye[1] ){
          //   eye = left_eye[1];
          // }else{
          //   eye = right_eye[1];
          // }
          // var height_eye_nose = nose[1] - eye ; 
          // canvasCtx.fillRect(start[0], eye, end[0] - start[0], height_eye_nose);
          // canvasCtx.fillRect(start[0], left_eye[1], end[0] - start[0], end[1] - start[1]);
          // end[1] - start[1]
          

        
      }

      
      // TODO: Loop through all detected faces instead of the first one.
      break;  
    }
  }else{
    canvasCtx.clearRect(0, 0, canvas.width, canvas.height);
    canvasCtx.drawImage(vid, 0, 0, canvas.width, canvas.height);
  }

  img.dispose();

  requestAnimationFrame(renderPrediction);

  // if (loadingModel.innerHTML !== "") {
  //   loadingModel.innerHTML = "";
  // }
}

async function user_model(){
  const modelfile = document.getElementById('modelUpload').files[0];

if (modelfile) {
        console.log("Using User Uploaded Model")
        var link=web_url_for_model+modelfile.name
        console.log(link)
       await tf.loadLayersModel(link).then(m => {
    maskDetectionModel = m;
    console.log("User's mask detection model loaded");
  }); 
    }

  else{
    alert("Seems like you didn't upload a model")
  }
}

//If user uploads a model
async function main_user() {
  await setupCamera();
  video.play();

  videoWidth = video.videoWidth;
  videoHeight = video.videoHeight;
  video.width = videoWidth;
  video.height = videoHeight;

  setupCanvas();

  await loadFaceDetectionModel();
  await user_model();

  renderPrediction();
}

//for pretrained model
async function main() {

  await loadFaceDetectionModel();
  await loadMaskDetectionModel();
  await loadMaskDetectionModel_2();
  

  renderPrediction();
}

// function clearmodel(){
  
//   button_value=document.getElementById('change_upload').value
//   if(button_value=="Uploaded"){
//     document.getElementById("modelUpload").value = "";
//   document.getElementById('change_upload').value="Upload Model"
  
// }
// var buto = document.querySelector('.Uploadyourmodel');
//   buto.style.display = 'none';

// }

// function upload_model(){
//   const modelfile2 = document.getElementById('modelUpload').files[0];
//   if (modelfile2){
//   // document.getElementById('change_upload').value="Uploaded"
//   loadingModel.innerHTML=""
//   loadingModel.innerHTML="Using User's Model"
//   main_user ();
// }
//   else{
//     alert("Please Select a model First :)")
//     console.log("You didn't upload the model")
//   }
// }
// const upl_btn=document.getElementById('user-upload')
// const realfile = document.getElementById('modelUpload');


// // async function uploadedmodel() {
// upl_btn.addEventListener('click',function(){
// realfile.click();

// });


// realfile.addEventListener('change',function(){
// console.log("model Selected")
// upload_model();

// })
// // }

// function pretrainedmodel(){
//   main();
// }

function gotResults_test(error, result) {
  if (error) {
    console.error(error);
  } else {
    // updated to work with newer version of ml5
    // label = result;
    label = result[0].label;
    classifier.classify(gotResults_test);
  }
}

function modelReady() {
  console.log('Model is ready!!!');
  classifier.load('model_mask.json', customModelReady);
}

function customModelReady() {
  console.log('Custom Model is ready!!!');
  label = 'model ready';
  classifier.classify(gotResults_test);
}