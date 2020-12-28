$(document).ready(function(){
    $("#like").click(function(){

        $.post("action",
        {
          name: "Donald Duck",
          city: "Duckburg"
        },
        function(data,status){
          alert("Data: " + data + "\nStatus: " + status);
        });

    });
    $("#dislike").click(function(){

        $.post("demo_test_post.asp",
        {
            name: "Donald Duck",
            city: "Duckburg"
        },
        function(data,status){
            alert("Data: " + data + "\nStatus: " + status);
        });

      });


  });