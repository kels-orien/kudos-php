(function($, window, document) {
  $(function(){
    
    // nav
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
      var state = $('#wrapper').hasClass('toggled') ;
      $.post( "/admin/remember", { toggled: state } );
    });
    
    // shop
    $("#select-shops").change(function() {
      var id = $(this).val() ;
      var token = $(this).prev().val() ;
      $.post( "/admin/remember", { 'shop': id, '_token': token }, function() {
        window.location.replace("/admin"); 
      });
    }); 
    
    // lang
    $("#select-language").change(function() {
      var id = $(this).val() ;
      var token = $(this).prev().val() ;
      $.post( "/admin/remember", { 'language': id, '_token': token }, function() {
        location.reload() ; 
      });
    });
    
    // are you sure?, when danger is present
    $(document).on('click', '.btn-danger:not(.no-submit), a.text-danger', function(e){
      e.preventDefault() ;
      if (window.confirm("Are you sure?")) {
        $(this).closest('form').submit() ; 
      }
    }) ;
    
    // wysiwyg
    $('.wysiwyg').summernote({
      height: 300,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'hr']],
        ['view', ['fullscreen', 'codeview']]
      ],
      disableDragAndDrop: true
    });
  
  });
}(window.jQuery, window, document)); 