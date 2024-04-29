<!DOCTYPE html>
<div class="testimonial-wrapper">
    
    <?php
        for($i = 1; $i < 4; $i++) {
            echo '<div class="testimonial-card card-' . $i . '">';
            echo '<div class="testimonial-name">';
            echo '<h2>' . $cards['card_' . $i]['first_name'] . '. ' . substr($cards['card_' . $i]['last_name'], 0, 1) . '</h2>';
            echo '<div class="testimonial-review">';
            echo '<div class="testimonial-stars">';
            echo '<div class="stars filled" style="width: '.$cards["card_" . $i]["rating_percentage"].'%">';
            echo '<img src="../assets/menu/star-filled.png">';
            echo '<img src="../assets/menu/star-filled.png">';
            echo '<img src="../assets/menu/star-filled.png">';
            echo '<img src="../assets/menu/star-filled.png">';
            echo '<img src="../assets/menu/star-filled.png">';
            echo '</div>';
            echo '<div class="stars empty">';
            echo '<img src="../assets/menu/star-empty.png">';
            echo '<img src="../assets/menu/star-empty.png">';
            echo '<img src="../assets/menu/star-empty.png">';
            echo '<img src="../assets/menu/star-empty.png">';
            echo '<img src="../assets/menu/star-empty.png">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="testimonial-text">';
            echo '<p>' . $cards['card_' . $i]['comment'] . '</p>';
            echo '</div>';
            
            echo '<div class="testimonial-dish">';
            echo '<h3>' . $cards['card_' . $i]['pizza_name'] . '</h3>';
            echo '</div>';
            echo '</div>';

            
            
        }
    ?>
</div>
