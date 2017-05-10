$(function () {
  var $featuredImageWrapper = $('#featured-image');
  var $selectedImage = $featuredImageWrapper.find('.selected-image');
  var $selectImage = $featuredImageWrapper.find('.select-image');
  var $featuredImageThumbnail = $featuredImageWrapper.find('.thumbnail');
  var $featuredImageId = $('#featured-image-id');
  var $imageChooser = $('#image-chooser');

  $('.remove-image').on('click', function (e) {
    e.preventDefault();
    $selectedImage.removeClass('show');
    $selectImage.addClass('show');
    $featuredImageId.val('');
  });

  $('.choose-image').on('click', function (e) {
    e.preventDefault();

    $imageChooser
      .modal('show')
      .find('.modal-body')
      .html('Loading...')
      .load($(this).attr('href'));
  });

  $imageChooser
    .on('click', '.item-choose', function (e) {
      var $this = $(this);
      var imageId = $this.data('chooserId');
      var thumbnail = $this.find('.thumbnail').attr('src');

      $featuredImageId.val(imageId);
      $featuredImageThumbnail.attr('src', thumbnail);
      $selectedImage.addClass('show');
      $selectImage.removeClass('show');

      $imageChooser.modal('hide');
    });
});
