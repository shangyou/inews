~function (doc, win) {

  var title, url, content;

  title = doc.title;
  url = win.location.href;
  content = doc.selection ? doc.selection : '';

  // apple store
  if (win.jQuery && window.location.host === 'itunes.apple.com') {
    var imgs = $(".image-wrapper img:visible")
    title = $('h1:first').text();

    imgs.each(function (i) {
      3 > i && (content += "![" + title + "](" + $(this).attr("src") + ")");
    });
  }

  title = encodeURIComponent(title);
  url = encodeURIComponent(url);
  content = encodeURIComponent(content);

  window.location.href = (window.site_url || 'http://inews.io') + '/submit?title=' + title +
    '&link=' + url +
    '&content=' + content;

}(document, window);