
var btn = document.querySelector('#sidemenu'),
    view = document.querySelector('#Sidenav'),
    body = document.body;

btn.addEventListener('click', function (e) {
    e.stopPropagation();
    view.classList.toggle('show');
});


body.addEventListener('click', function () {
    if (view.classList.contains('show')) {
        view.classList.remove('show');
    }
});
