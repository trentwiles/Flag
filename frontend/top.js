function array_to_top()
{
    videos.forEach(create)
    function create(number, id)
    {
        console.log(number)
        $.get("/api/v1/videos?id="+id, function(data, status){
            console.log(status)
            var meta = data;
        });
        document.write('<div class="w-400 mw-full">')
        document.write('<div class="card p-0">')
        document.write(`<a href="/watch/${id}"><img src="${meta.details.thumbnail}" class="img-fluid rounded-top" alt="thumbnail"></a>`)
        document.write('<div class="content"><h2 class="content-title">')
        document.write(`${meta.details.title}</h2>`)
        document.write(`<p class="text-muted">${meta.details.description}</p></div></div></div>`)
    }
}