function live(username)
{   

    const server = "https://rtc.riverside.rocks/";


    $.get(server, function(data, status){
        console.log(status+data);
    });
    $.get(`${server}/version`, function(data, status){
        if(status == "success")
        {
            document.getElementById("status").innerHTML = "Streaming server is online... ("+ data +")"
        }
    });
    setTimeout(function(){ 
        console.log("wait")
    }, 3000);
    setTimeout(function(){ 
        document.getElementById("status").innerHTML = "Preparing to send data to RTC server..."
     }, 3000);
     async function connect(ev) {
        // Disable inputs
        window.your_id.disabled = window.peer_id.disabled = ev.disabled = true;
        // Synchronize
        await Promise.all([
          fetch(`${server}/wait/${username}`, { method: 'POST' })
        ]);
        window.message.innerText = "Started!";
        // Get camera and voice
        const mediaStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: { echoCancellation: true } });
        // Convert MediaStream to ReadableStream
        const readableStream = mediaStreamToReadableStream(mediaStream, 100);
        // Send to peer
        fetch(`${server}/${username}`, {
          method: 'POST',
          body: readableStream,
          allowHTTP1ForStreamingUpload: true,
        });
      }
      
      function mediaStreamToReadableStream(mediaStream, timeslice) {
        return new ReadableStream({
          start(ctrl){
            const recorder = new MediaRecorder(mediaStream);
            recorder.ondataavailable = async (e) => {
              ctrl.enqueue(new Uint8Array(await e.data.arrayBuffer()));
            };
            recorder.start(timeslice);
          }
        });
      }
}