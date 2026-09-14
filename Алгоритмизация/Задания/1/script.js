const images = ["image1.jpg", "image2.jpg", "image3.jpg"];
let currentImageIndex = 0;

const prevButton = document.querySelector("#prev-btn");
const nextButton = document.querySelector("#next-btn");
const mainImage = document.querySelector("#main-image");
const image_list = document.querySelector("#image-list");

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
    thumbnail.width = 100;

    thumbnail.addEventListener("click", () => {
        currentImageIndex = index;
        updateMainImage();
    });

    listItem.append(thumbnail);
    image_list.append(listItem);
});