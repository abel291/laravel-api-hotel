
 // import Swiper bundle with all modules installed
 import SwiperCore, { Navigation } from 'swiper/core';

 // configure Swiper to use modules
 SwiperCore.use([Navigation]);

// import Swiper styles
import 'swiper/swiper-bundle.css';

const swiper = new SwiperCore("#carousel-list", {        
    spaceBetween:20,
    centeredSlides:true,       
    autoHeight:true,
    navigation: {
        nextEl: "#btn-back",
        prevEl: "#btn-next",
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: true,
    },
    // breakpoints: {
    //   640: {
    //     slidesPerView: 1,           
    //   },
    //   768: {
    //     slidesPerView: 1,          
    //   }
    // }
});