$(document).ready(function(){
  $.get("/api/v1/votes?id="+video,
  function(data,status){
    document.getElementById("like_count").innerHTML = data.Likes
    document.getElementById("dislike_count").innerHTML = data.Dislikes
  });
    $("#like").click(function(){

        $.post("/api/v1/vote",
        {
          id: video,
          action: "Like"
        },
        function(data,status){
          console.log(status);
          console.log(data)
          document.getElementById("like_count").innerHTML = data.count
        });

    });
    $("#dislike").click(function(){

        $.post("/api/v1/vote",
        {
          id: video,
          action: "Dislike"
        },
        function(data,status){
          console.log(status);
          console.log(data)
          document.getElementById("dislike_count").innerHTML = data.count
        });

      });


  });