jQuery(document).ready(function($) {

    $('.reply').click(function(e){
        e.preventDefault();
        var $form = $('#form_comment');
        var $this = $(this);
        var parent_id = $this.attr('data-id');
        var comment = $('#comment-' + parent_id);
        comment.after($form);
    })
});