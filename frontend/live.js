function live(username)
{
    $.get("https://rtc.riverside.rocks/version", function(data, status){
        console.log(status+data);
    });
    $.get("https://rtc.riverside.rocks/version", function(data, status){
        if(status == "success")
        {
            document.getElementById("status").innerHTML = "Streaming server is online... ("+ data +")"
        }
    });
    
}