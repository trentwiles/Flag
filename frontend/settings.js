$.post("/api/v1/settings",
{
    current: true,
},
function(data,status){
    if(data.settings.comments == "1")
    {
        document.getElementById("comm").checked = true
    }else{
        document.getElementById("comm").checked = false
    }
    if(data.settings.announce == "1")
    {
        document.getElementById("ann").checked = true
    }else{
        document.getElementById("ann").checked = false
    }
})

document.getElementById("ann").addEventListener("click", updateAnn);
document.getElementById("comm").addEventListener("click", updateComm);


function updateAnn() {
    var val0 = document.getElementById("ann").checked
    $.post("/api/v1/settings",
            {
              announce: val0,
            },
            function(data,status){
                if(status == "success")
                {
                    console.log("Updated + saved")
                }else{
                    console.log("Something went wrong...")
                }
            })
}

function updateComm() {
    var val = document.getElementById("comm").checked
    $.post("/api/v1/settings",
            {
              comments: val,
            },
            function(data,status){
                if(status == "success")
                {
                    console.log("Updated + saved")
                }else{
                    console.log("Something went wrong...")
                }
            })
}