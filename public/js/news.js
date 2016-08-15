function getNews()
{
    var url = basePath + '/news/getNews';
    $.get(url, {}, function(data)
    {
        $('#list-news').html(data);
    });
}

function getNewsItem(id)
{
    var url = basePath + '/news/getNewsItem/' + id;
    $.get(url, {}, function(data)
    {
        $('#leading-' + id).html(data);
    });
}