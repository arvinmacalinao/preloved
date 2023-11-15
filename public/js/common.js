$(document).ready(function () {
    setup_grid_delete_btns();
    setup_confirm_modal_btns();

    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });

    $('#page-select').change(function() {
        window.location.href = $(this).val();
    });
});