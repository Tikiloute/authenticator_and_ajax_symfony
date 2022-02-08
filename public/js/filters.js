

window.onload = function () {

    /// Ici c'est les pouces j'aime/j'aime pas --------------------------------

    function onClickBtnLike(event) {
        event.preventDefault();
        const Number = this.querySelector('.js-likes');
        const Image = this.querySelector('.js-img');
        const TextLike = this.querySelector('.js-p-like');
        const Urls = this.href;
        console.log(Urls);
        fetch(Urls)
            .then(function (response) {
                //console.log(response);
                return response.json();

            }).then(function(data){
                //console.log(data)
                Number.textContent = data.likes
                Image.src = data.image
                TextLike.textContent = data.text
            })

    }
    let likes = document.querySelectorAll('a.js-like');
    likes.forEach(function (link) {
        link.addEventListener('click', onClickBtnLike);
    })


    /// Ici c'est l'ajax du filtre des fruits/légumes -------------------------------


    const FiltersForm = document.querySelector("#filters");

    document.querySelectorAll("#filters input").forEach(input => {
        //console.log(input);
        input.addEventListener("change", () => {
            //intereception des clics checkbox
            //on doit recup les données du formulaire
            const Form = new FormData(FiltersForm);

            //on fabrique la query string (ce qu'il y a apres le ? dans l'url)
            const Params = new URLSearchParams();

            Form.forEach((value, key) => {
                Params.append(key, value);

            });

            //on recup l'url active
            const Url = new URL(window.location.href)

            //on lance la requete ajax
            //fetch demande l'url complete
            console.log(likes);
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(function (response) {

                return response.json();
            }).then(function (data) {

                const Content = document.querySelector('#contents');
                Content.innerHTML = data.content;
                likes = document.querySelectorAll('a.js-like');
                likes.forEach(function (link) {
                    link.addEventListener('click', onClickBtnLike);
                })
            }).catch(e => alert(e))
        });
    });

} 