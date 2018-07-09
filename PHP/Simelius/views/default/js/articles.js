/////////////Afficher les réponses liées à un article//////////////////
$('.post').find('.showAnswers').click(function () {
        if ($(this).parent().parent().find('.showComments').is(":visible") === false) {
            $(this).parent().parent().find('.showComments').slideDown(400);
            $(this).parent().parent().find('.showAnswersContent').text('Masquer les réponses')
        }
        else if
        ($(this).parent().parent().find('.showComments').is(":visible") === true) {
            $(this).parent().parent().find('.showComments').slideUp(400);
            $(this).parent().parent().find('.showAnswersContent').text('Afficher les réponses')
        }
    });

////////////Animations pour la mise à jour/suppression des articles/commentaires/////////////////
$('.post').find('.updateArticle').click(function() {
        $(this).parent().parent().find('.articleContent').slideUp(500);
        $(this).parent().parent().find('.updateArticleContent').show(900);
        $(this).parent().parent().find('.updateArticleContent').focus();
    }
);

$('.post').find('.updateArticleContent').blur(function() {
    $(this).hide(300);
    $(this).parent().parent().find('.articleContent').show(900);
});

$('.post').find('.updateComment').click(function () {
    $(this).parent().parent().parent().parent().find('.commentcontent').slideUp(500);
    $(this).parent().parent().parent().parent().find('.updateCommentContent').show(900);
    $(this).parent().parent().parent().parent().find('.updateCommentContent').focus();
});

$('.post').find('.updateCommentContent').blur(function() {
    $(this).hide(300);
    $(this).parent().parent().parent().parent().find('.commentcontent').show(900);
});

$('.commentForm').find('.writeAnswer').keyup(function (e) {
    var e = e || window.event;
    var k = e.keyCode || e.which;
    if (k == 13 && !e.shiftKey) {
        this.form.submit();
    }
});


/////////////////////Textarea : validation à la touche entrée + Autosize ///////////////////
$('.updateArticleForm').find('.updateArticleContent').keyup(function (e) {
    var e = e || window.event;
    var k = e.keyCode || e.which;
    if (k == 13 && !e.shiftKey) {
        this.form.submit();
    }
});

$('.updateCommentForm').find('.updateCommentContent').keyup(function (e) {
    var e = e || window.event;
    var k = e.keyCode || e.which;
    if (k == 13 && !e.shiftKey) {
        this.form.submit();
    }
});

function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight) + "px";
};


////////////////////////////////////Fonction scroll//////////////////////////////////
/*
    rowPrincipale = $('#principale');// à renomer pour indiquer l'emplacement de la div ou il y a les articles
    comptage = 0;

    chargement(); //chargement des 10 premieres post

    function chargement(){ //charge 10 post

        for(i=0;i<=9;i++){
            getArticle(comptage);
            comptage++;
        }
    };

    function getArticle(number) {
        var xhttp;
        xhttp = new XMLHttpRequest();
        alert(number);
        xhttp.open("GET",  "/Simelius/homepage.php?n="+number, true);//changer le lien pour accedder à getarticles.php
        rowPrincipale.innerHTML = xhttp.send();
    }

    $(window).scroll(function() {//verifie qu'on est en bas de page
        if($(window).scrollTop() + $(window).height() == $(document).height()) {

            chargement();
        }
    });
    */

/*   $(document).ready(function(){
       $(".commentForm").submit(function(e) {
           e.preventDefault();
           var answer= $(this).find('.writeAnswer').val();
           var article_id = $(this).find('#article_id').val();
           $.post(
               '/Simelius/comment.php', {
                   article_id: article_id,
                   content : answer,
               },
               function(data){
                   if(data === 'Success'){
                       $("#comments"+article_id).append().html("<p>answer</p>");
                   }
                   else{
                       $("#resultat").html("<p>Erreur...</p>");
                   }
               },
               'text'
           );
       });
   }); */
