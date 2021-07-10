import Isotope from 'isotope-layout';
import imagesLoaded from 'imagesloaded'
import fslightbox from 'fslightbox'

const gallery = document.getElementById('gallery-img');
imagesLoaded(gallery, function () {
  // init Isotope after all images have loaded
  const iso = new Isotope(gallery, {
    percentPosition: true,
    itemSelector: '.img-item',
    horizontalOrder: true,

  });
  const btn_filter = document.querySelector('.filter-images');
  if (btn_filter) {
    btn_filter.addEventListener("click", function (e) {

      if (!e.target.matches('.img-filter')) {
        return;
      }
      let filter_data = e.target.getAttribute('data-filter')
      iso.arrange({ filter: filter_data });
      refreshFsLightbox();
    })
  }
});




