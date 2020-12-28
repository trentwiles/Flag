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
          document.getElementById("like_count").innerHTML = data.likes
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