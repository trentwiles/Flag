$(document).ready(function(){
    $("#comment").click(function(){
        var comment = document.getElementById("box").innerHTML
        $.post("/comment",
        {
          video: video,
          comment: comment
        },
        function(data,status){
          console.log(status);
          console.log(data)
          document.getElementById("new_comment").innerHTML = data.comment
        });

    });
});