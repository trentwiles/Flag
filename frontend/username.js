document.getElementById("username").addEventListener("input", () => {
    $.get("/api/v1/username?username="+document.getElementById("write").value, function(data, status){
        if(data.username == "")
        {
            document.getElementById("taken").innerHTML = "Username is taken."
        }else{
            document.getElementById("taken").innerHTML = "That username looks good!"
        }
    })
});