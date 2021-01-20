document.getElementById("ann").addEventListener("click", updateAnn);
document.getElementById("comm").addEventListener("click", updateComm);


function updateAnn() {
    var val0 = document.getElementById("ann").value
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
    var val = document.getElementById("comm").value
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