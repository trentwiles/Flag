$(document).ready(function(){
    $("#like").click(function(){

        $.post("/action",
        {
          video: video,
          action: "Like"
        },
        function(data,status){
          console.log(status);
          console.log(data)
          json = JSON.parse(data)
          document.getElementById("like_count").innerHTML = json.likes
        });

    });
    $("#dislike").click(function(){

        $.post("/action",
        {
          video: video,
          action: "Dislike"
        },
        function(data,status){
          console.log(status);
        });

      });


  });