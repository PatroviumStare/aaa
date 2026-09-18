
let currentImageIndex = 0;

const prevButton = document.querySelector("#prev-btn");
const nextButton = document.querySelector("#next-btn");

const images = ["image1.jpg", "image2.jpg", "image3.jpg"];
const mainImage = document.querySelector("#main-image");
const image_list = document.querySelector("#image-list");

const form = document.querySelector("#feedback-form");
const emailPattern = /.+@.+\..+/i;




function updateMainImage() {
  mainImage.src = images[currentImageIndex];
}


prevButton.addEventListener("click", () => {
  if (currentImageIndex > 0) {
    currentImageIndex--;
  } else {
    currentImageIndex = images.length - 1;
  }

  updateMainImage();
});


nextButton.addEventListener("click", () => {
    if (currentImageIndex < images.length - 1) {
        currentImageIndex++;
    } else {
        currentImageIndex = 0;
    }
    
    updateMainImage();
});


images.forEach((image, index) => {
    const listItem = document.createElement("li");
    const thumbnail = document.createElement("img");

    thumbnail.src = image;
    thumbnail.width = 75;

    thumbnail.addEventListener("click", () => {
        currentImageIndex = index;
        updateMainImage();
    });

    listItem.append(thumbnail);
    image_list.append(listItem);
});


function showMessage(message) {
  $("#message-box")
    .text(message)
    .stop(true, true)
    .slideDown(400);
  
    setTimeout(function () {
      $("#message-box").slideUp(400);
    }, 3000);
}

function formSubmit(event) {
  event.preventDefault();

  const name  = $("#name").val().trim();
  const email = $("#email").val().trim();
  const formMessage = $("#message").val().trim();


  if (name === "" || email === "" || formMessage === "") {
    showMessage("Заполните все поля!");
    return;
  }
  else if (!emailPattern.test(email)) {
    showMessage("Неверный формат email-адреса!");
    return;
  }

  $("#feedback-form")[0].reset();

  showMessage("Сообщение отправлено!")

}


form.addEventListener("submit", formSubmit);


function loadArticles() {
    const articleList = $("#article-list");

    $.getJSON("data.json", function (articles) {
        $.each(articles, function (index, article) {

            const listItem = $("<li>");

            listItem.attr("id", article.id);

            const title = $("<h2>")
                .text(article.title);

            const description = $("<p>")
                .text(article.description);

            listItem.append(title, description);
            articleList.append(listItem);
        });
    });
};

document.addEventListener("dragstart", function (event) {
    event.preventDefault();
});


window.onload = loadArticles;