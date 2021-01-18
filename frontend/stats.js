function getViews(id)
{
    $.get("/api/v1/", function(data, status){
        alert("Data: " + data + "\nStatus: " + status);
      });
}