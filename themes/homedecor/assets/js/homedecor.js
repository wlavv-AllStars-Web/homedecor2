function toggleSearchbar() {
  const searchbar = document.querySelectorAll("#search_widget");
  const body = document.querySelector("#wrapper")
  if(window.screen.width > 992){
  searchbar[1].classList.toggle("search-hidden");
  }else{
  searchbar[0].classList.toggle("search-hidden");
  }

    body.addEventListener("click", clickOutsideHandler);

}

function clickOutsideHandler(event) {
  const searchbar = document.querySelector("#search_widget");
  const body = document.querySelector("#wrapper")
  // Check if the clicked element is not the search bar or its descendant
  if (!searchbar.contains(event.target)) {
  //     // If the search bar is visible, hide it
      searchbar.classList.toggle("search-hidden");
  //     // Remove the event listener after hiding the search bar
      body.removeEventListener("click", clickOutsideHandler);
  }
}



function toggleMyaccount() {
    const myaccount = document.querySelector("#block_myaccount_infos");
    myaccount.classList.toggle("myaccount-hidden")
}

document.addEventListener("DOMContentLoaded", () => {
  if(window.screen.width > 992){
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
          if(screen.width > 992) {
            hoverButton.addEventListener('mouseover', function() {
              loadImages();
            });
          }else{
            hoverButton.addEventListener('click', function() {
              loadImages();
            });
          }
        }
      }
  
      handleImageLoadingOnHover();
    });
  });
  


  document.addEventListener("DOMContentLoaded", function() {
    const lazyImages = document.querySelectorAll(".lazy");

    const observer = new IntersectionObserver(function(entries, observer) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          // Replace the src attribute with the data-src attribute value
          img.setAttribute("src", img.getAttribute("data-src"));
          // Remove the 'lazy' class to prevent loading it again
          img.classList.remove("lazy");
          // Stop observing the image
          observer.unobserve(img);
        }
      });
    });

    // Observe each lazy image
    lazyImages.forEach(image => {
      observer.observe(image);
    });
  });