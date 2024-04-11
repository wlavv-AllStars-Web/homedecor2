function toggleSearchbar() {
    const searchbar = document.querySelector("#search_widget");
    searchbar.classList.toggle("search-hidden")
}
function toggleMyaccount() {
    const myaccount = document.querySelector("#block_myaccount_infos");
    myaccount.classList.toggle("myaccount-hidden")
}
document.addEventListener("DOMContentLoaded", () => {
    const linkDropdowns = document.querySelectorAll(".menu-item.dropdown");
    if(linkDropdowns) {
    linkDropdowns.forEach(linkDropdown => {
        const dropdown = linkDropdown.querySelector(".dropdown-menu")
        let timeoutId = null;

        linkDropdown.addEventListener("mouseover", (event) => {
            event.target.classList.add("open");
            dropdown.style.display = "flex";
        });
        linkDropdown.addEventListener("mouseout", (event) => {
            // timeoutId = setTimeout(() => {
            event.target.classList.remove("open");
            dropdown.style.display = "none";
            // }, 500);
        });
        linkDropdown.addEventListener("mouseenter", () => {
            clearTimeout(timeoutId);
        });
    });
    }
});

document.addEventListener("DOMContentLoaded", () => {
let prependNumber = 1;
    const swiper = new Swiper('.swiper', {
      slidesPerView: 2,
      centeredSlides: false,
      spaceBetween: 0,
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        type: 'fraction',
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 40,
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 50,
        },
      },
    });
});
   

function activateLink(link) {
    // Remove 'active' class from all links
    var links = document.querySelectorAll('.menu-list a');
    links.forEach(function(item) {
      item.classList.remove('activeMenu');
      var parentLi = item.closest('.menu-item');
      if (parentLi) {
        var button = parentLi.querySelector('button');
        if (button) {
          button.classList.remove('activeMenu');
        }
      }
    });
  
    // Add 'active' class to the clicked link
    link.classList.add('activeMenu');
    var parentLi = link.closest('.menu-item');
    if (parentLi) {
        var button = parentLi.querySelector('button');
        if (button) {
        button.classList.add('activeMenu');
        }
    }
  }
  
  document.addEventListener("DOMContentLoaded", function() {
    var dropdownMenus = document.querySelectorAll('[class^="drop"]');
    
    dropdownMenus.forEach(function(dropdownMenu) {
      var imagesToLoad = dropdownMenu.querySelectorAll('img[data-src]');
      var hoverButton = dropdownMenu.previousElementSibling;
  
      function loadImages() {
        imagesToLoad.forEach(function(img) {
          if (!img.getAttribute('src')) {
            img.setAttribute('src', img.getAttribute('data-src'));
          }
        });
      }
  
      function handleImageLoadingOnHover() {
        if(hoverButton) {
        hoverButton.addEventListener('mouseover', function() {
          console.log("Hover detected on", dropdownMenu.className);
  
          loadImages();
        });
        }
      }
  
      handleImageLoadingOnHover();
    });
  });
  