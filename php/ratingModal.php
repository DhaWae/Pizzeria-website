<dialog id="rating-modal">
  <div class="close-modal"><img src="../assets/close.svg"></div>
  <form method="post" action="../includes/rate.inc.php" id="rating-form">

    <div class="inputs rating-inputs">
      <?php
      echo '<div class="star-wrapper-rating"><div class="stars filled rating-stars" id = "rating-stars-filled">' . getStars() . '</div><div class="stars empty rating-stars">' . getEmptyStars() . '</div></div>';
      ?>
      <textarea data-limit-rows="true" name= "comment" id="comment" cols="40" rows="4" maxlength="120" placeholder="Comment (optional)"></textarea>
      <input type="hidden" name="rating" id="rating">
      <input type="hidden" name="pizza_id" id="pizza_id">
      <!-- byt till input type hidden sen-->
      <button type="submit" name="submit" id="rating-submit-button">Submit</button>
    </div>
    
    
  </form>
</dialog>