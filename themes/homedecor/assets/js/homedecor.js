
document.addEventListener("DOMContentLoaded", function() {
  var lazyloadImages = document.querySelectorAll("img.lazy");
  var lazyloadThrottleTimeout;
  
  function lazyload() {
    if (lazyloadThrottleTimeout) {
      clearTimeout(lazyloadThrottleTimeout);
    }
    
    lazyloadThrottleTimeout = setTimeout(function() {
      var scrollTop = window.pageYOffset;
      lazyloadImages.forEach(function(img) {
        if (img.offsetTop < (window.innerHeight + scrollTop)) {
          img.src = img.dataset.src;
          img.classList.remove('lazy');
        }
      });
      
      
      lazyloadImages = document.querySelectorAll("img.lazy"); 
      if (lazyloadImages.length == 0) {
        document.removeEventListener("scroll", lazyload);
        window.removeEventListener("resize", lazyload);
        window.removeEventListener("orientationChange", lazyload);
      }
    }, 0);
  }
  
  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);

});




function toggleSearchbar() {
  const searchbar = document.querySelectorAll("#search_widget");
  const Body = document.querySelector("#wrapper")
  

  if(window.screen.width > 992){
  searchbar[1].classList.toggle("search-hidden");
  const btnsubmit = searchbar[1].querySelector('i.search')
  btnsubmit.addEventListener("click", () => {
    searchbar[1].querySelector("form").submit();
  });
  }else{
  searchbar[0].classList.toggle("search-hidden");
  }


  Body.addEventListener("click", clickOutsideHandler);

}


function clickOutsideHandler(event) {
  const searchbar = document.querySelectorAll("#search_widget");
  const Body = document.querySelector("#wrapper")
  // Check if the clicked element is not the search bar or its descendant

  if(window.screen.width > 992){
    if (!searchbar[1].contains(event.target)) {
        searchbar[1].classList.add("search-hidden");
    }
  }else{
    if (!searchbar[0].contains(event.target)) {
        searchbar[0].classList.add("search-hidden");
    }
  }
Body.removeEventListener("click", clickOutsideHandler);
}



function toggleMyaccount() {
    const myaccount = document.querySelector("#block_myaccount_infos");
    const Body = document.querySelector("#wrapper")
    myaccount.classList.toggle("myaccount-hidden")

    Body.addEventListener("click", clickOutsideHandlerMyaccount);
}

function clickOutsideHandlerMyaccount(event) {
  const myaccount = document.querySelector("#block_myaccount_infos");
  const Body = document.querySelector("#wrapper")
  if (!myaccount.contains(event.target)) {
    myaccount.classList.toggle("myaccount-hidden")
  }
  Body.removeEventListener("click", clickOutsideHandlerMyaccount);
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

// document.addEventListener("DOMContentLoaded", () => {
// let prependNumber = 1;
//     const swiper = new Swiper('.list-blog-slick-carousel', {
//       slidesPerView: 2,
//       centeredSlides: false,
//       spaceBetween: 0,
//       loop: true,
//       pagination: {
//         el: '.swiper-pagination',
//         type: 'fraction',
//       },
//       navigation: {
//         nextEl: '.swiper-button-next',
//         prevEl: '.swiper-button-prev',
//       },
//       breakpoints: {
//         640: {
//           slidesPerView: 2,
//           spaceBetween: 0,
//         },
//         768: {
//           slidesPerView: 3,
//           spaceBetween: 40,
//         },
//         1024: {
//           slidesPerView: 4,
//           spaceBetween: 50,
//         },
//       },
//     });
// });
document.addEventListener("DOMContentLoaded", () => {
let prependNumber = 1;
    const swiper = new Swiper('.swiper', {
      slidesPerView: 1,
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
        480: {
          slidesPerView: 2,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        1270: {
          slidesPerView: 4,
          spaceBetween: 10,
        },
        1600: {
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


  
document.addEventListener("scroll", () => {
  scrollFunction()
});


function scrollFunction() {
  const btnTop = document.querySelector(".btn-back-top");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btnTop.style.display = "flex";
  } else {
    btnTop.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 