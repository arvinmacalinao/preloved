function setup_grid_delete_btns() {
    // grid delete buttons
    if ($('.row-delete-btn').length) {
      $('.row-delete-btn').click(function (event) {
        event.preventDefault();
        msg = 'Delete this item?';
        text = '';
        if (typeof $(this).data('msg') != 'undefined') {
          msg = $(this).attr('data-msg');
        }
        if (typeof $(this).data('text') != 'undefined') {
          text = $(this).attr('data-text');
        }
        $('#confirm-modal-msg').html(msg);
        $('#confirm-modal-text').html(text);
        $('#confirm-modal').attr('data-url', $(this).attr('href'));
        $('#confirm-modal').modal('show');
      });
    }
  }