<script>
$(function(){
  $(document).on('click', '#follow_btn', function(e){
    e.preventDefault();
    var u_id = $('.u_id').val(),
        p_id = $('.p_id').val();
        
      $('#follow_btn').toggleClass('<?=$else_class?>');
      $('#follow_btn').toggleClass('<?=$class?>');
      if($(this).text() === 'フォロー') {
        $(this).text('フォロー中');
      } else {
        $(this).text('フォロー');
      }

      $.ajax({
          type: 'POST',
          url: '../follow_method.php',
          dataType: 'text',
          data: { u_id: u_id,
                  p_id: p_id }
      }).done(function(data){
      // location.reload();
      }).fail(function(){
      //  location.reload();
      window.alert('処理に失敗しました');
      });
  });
});
</script>
