
const swiper = new SwiperCore("#gallery-img", { 
    slidesPerView: "auto",
    
    spaceBetween:50,
    centeredSlides: true,
    navigation: {
        nextEl: "#btn-back",
        prevEl: "#btn-next",
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    
 });