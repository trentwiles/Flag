$(document).ready(function(){
    $("#like").click(function(){

        $.post("/action",
        {
          video: video,
          action: "Like"
        },
        function(data,status){
          console.log(status);
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