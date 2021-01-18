function getViews(id)
{
    $.get("/api/v1/stats?id="+id, function(data, status){
        document.getElementById(id).innerHTML = data.details.views
    });
}