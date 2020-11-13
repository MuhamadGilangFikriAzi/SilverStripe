//Pagination

(function($) {
    var applyChosen = function (selector) {
      if ($(selector).length) {
        $(selector).chosen({
          allow_single_deselect: true,
          disable_search_threshold: 12
        });
      }
    };
    $(function () {

        applyChosen('select');

if ($('.pagination').length) {
    var paginate = function (url) {
        var param = '&ajax=1',
            ajaxUrl = (url.indexOf(param) === -1) ?
                       url + '&ajax=1' :
                       url,
            cleanUrl = url.replace(new RegExp(param + '$'), '');

        $.ajax(ajaxUrl)
            .done(function (response) {
                $('.main').html(response);
                applyChosen('.main select');
                $('html, body').animate({
                    scroollTop: $('.main').offset.top
                });
                window.history.pushState(
                    { url: cleanUrl },
                    document.title,
                    cleanUrl
                );
            })
            .fail(function (xhr) {
                alert('Error: ' + xhr.responseText);
            });
};

    $('.main').on('click', '.pagination a', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        paginate(url);
    });

window.onpopstate = function (e) {
    if (e.state.url) {
        paginate(e.state.url);
    }
    else {
        e.preventDefault();
    }
    }
}
