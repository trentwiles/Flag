function check()
{
    $.get("/api/v1/videos?id="+id, function(data, status){
        if(data.details.title == "")
        {
            window.location = "/404";
        }
        console.log("status");
    });
}