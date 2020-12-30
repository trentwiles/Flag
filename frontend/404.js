function check()
{
    $.get("/api/v1/videos?id="+video, function(data, status){
        if(data == null)
        {
            window.location = "/404";
        }
        console.log("status");
    });
}

check();