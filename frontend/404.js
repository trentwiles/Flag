function check()
{
    $.get("/api/v1/videos?id="+video, function(data, status){
        if(data == null)
        {
            window.location = "/404";
        }
        if(data.details.isBanned == "true")
        {
            window.location = "/videobanned";
        }
        console.log("status");
    });
}

check();