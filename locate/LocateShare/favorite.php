<script>
$(function(){
  $(document).on('click', '#favorite_btn', function(fav_e){
    fav_e.preventDefault();
    var fav_u_id = $('.fav_u_id').val(),
        fav_p_id = $('.fav_p_id').val();

      $('#favorite_btn').toggleClass('<?=$fav_class?>');
      $('#favorite_btn').toggleClass('<?=$fav_else?>');

      $.ajax({
          type: 'POST',
          url: '../favorite_method.php',
          dataType: 'text',
          data: { fav_u_id: fav_u_id,
                  fav_p_id: fav_p_id }
      }).done(function(data){
      //location.reload();
      }).fail(function(){
      //  location.reload();
      window.alert('処理に失敗しました');
      });
  });
});
</script>
