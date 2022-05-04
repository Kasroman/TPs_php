// Requêtes AJAX

// Url de la page actuelle
const urlCurrent = document.location.href;

function ajaxGetCommentsRequest(idArticle){
    const req = new XMLHttpRequest();

    req.open('GET',`http://localhost/tp_mythologie/public/commentaires/read/${idArticle}`, false);
    req.onload = function(){
        const commentsDiv = document.querySelector('#comments-div')

        // On supprime les elements dans la div si il y en a deja de présent
        let child = commentsDiv.lastElementChild;
        while(child){
            commentsDiv.removeChild(child);
            child = commentsDiv.lastElementChild;
        }

        if(req.response){
            // On la remplie avec les commentaires
            commentsDiv.removeChid
            const data = JSON.parse(req.responseText);
            data.forEach(comment => {
                const div1 = document.createElement('div');
                div1.classList.add('border', 'm-2');

                const div2 = document.createElement('div');
                div2.classList.add('m-3');

                const h5 = document.createElement('h5');

                const pContent = document.createElement('p');
                pContent.classList.add('m-0', 'fs-5');

                const pDate = document.createElement('p');
                pDate.classList.add('text-muted');
                
                const pDateSpan = document.createElement('span');
                pDateSpan.classList.add('fst-italic');

                const btnAdmin = document.querySelector('#admin-btn').cloneNode([true]);
                btnAdmin.classList.remove('d-none');
                btnAdmin.setAttribute('onclick', `ajaxDeleteCommentRequest(${comment.id_commentaire})`);

                pDateSpan.textContent = comment.date_commentaire;
                pDate.textContent = 'le ';
                pContent.textContent = comment.contenu_commentaire;
                h5.textContent = comment.pseudo_user;

                pDate.append(pDateSpan);
                div2.append(h5, pContent, pDate, btnAdmin);
                div1.append(div2);
                commentsDiv.append(div1);
            });
        }else{
            const div1 = document.createElement('div');
            div1.classList.add('border', 'm-2');

            const div2 = document.createElement('div');
            div2.classList.add('m-3');

            const h5 = document.createElement('h5');

            h5.textContent = 'Soyez le premier à commenter !';

            div2.append(h5);
            div1.append(div2);
            commentsDiv.append(div1);
        }
    }
    req.send();
}

function ajaxPostCommentRequest(event){

    // On stop le submit du formulaire
    event.preventDefault();

    const content = document.querySelector('#content');
    const idArticle = document.querySelector('#id-article');

    const data = new FormData();
    data.append('content', content.value);

    const req = new XMLHttpRequest();
    req.open('POST', `http://localhost/tp_mythologie/public/commentaires/add/${idArticle.value}`, false);

    req.onload = function(){
        // On récupère l'id de l'article en utilisant l'url de la page actuelle
        ajaxGetCommentsRequest(urlCurrent.split("/").pop());
    }
    req.send(data);

    content.value = '';
}

function ajaxDeleteCommentRequest(idComment){

    const req = new XMLHttpRequest();
    req.open('POST', `http://localhost/tp_mythologie/public/commentaires/remove/${idComment}`, false);

    req.onload = function(){
        // On récupère l'id de l'article en utilisant l'url de la page actuelle
        ajaxGetCommentsRequest(urlCurrent.split("/").pop());
    }
    req.send();
}

// On récupère l'id de l'article en utilisant l'url de la page actuelle
ajaxGetCommentsRequest(urlCurrent.split("/").pop());

if(document.querySelector('#comment-form')){
    document.querySelector('#comment-form').addEventListener('submit', ajaxPostCommentRequest);
}
