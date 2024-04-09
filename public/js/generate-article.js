document.getElementById("generate-article").addEventListener("click", function () {
    var articleInput = document.getElementById("article");
    var article = generateArticle();
    articleInput.value = article;
});

function generateArticle() {
    var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    var article = "";
    for (var i = 0; i < 10; i++) {
        article += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return article;
}