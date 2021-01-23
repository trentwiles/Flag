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
          console.log(data);
          if(data.success !== "true")
          {
            Swal.fire(
              'Please Sign In',
              'To vote, comment, and upload, you will need to sign in.',
              'error'
            )
          }else{
            document.getElementById("like_count").innerHTML = data.count
          }
          
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
          if(data.success !== "true")
          {
            Swal.fire(
              'Please Sign In',
              'To vote, comment, and upload, you will need to sign in.',
              'error'
            )
          }else{
            document.getElementById("dislike_count").innerHTML = data.count
          }
        });

      });
  });