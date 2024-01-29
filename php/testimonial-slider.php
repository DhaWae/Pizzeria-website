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
        /*<div class="testimonial-card card-1">
            <div class="testimonial-name">
                <h2><?php echo $cards['card_1']['first_name'] . '. ' . substr($cards['card_1']['last_name'], 0, 1); ?></h2>
            </div>
            <div class="testimonial-review">
                <div class="testimonial-stars">
                    <div class="stars filled">
                        <img src="../assets/menu/star-filled.png">
                        <img src="../assets/menu/star-filled.png">
                        <img src="../assets/menu/star-filled.png">
                        <img src="../assets/menu/star-filled.png">
                        <img src="../assets/menu/star-filled.png">
                    </div>
                    <div class="stars empty">
                        <img src="../assets/menu/star-empty.png">
                        <img src="../assets/menu/star-empty.png">
                        <img src="../assets/menu/star-empty.png">
                        <img src="../assets/menu/star-empty.png">
                        <img src="../assets/menu/star-empty.png">
                    </div>
                </div>

                <div class="testimonial-text">
                    <p><?php echo $cards['card_1']['comment']?></p>
                </div>
            </div>
            
            
            <div class="testimonial-dish">
                <h3><?php echo $cards['card_1']['pizza_name']?></h3>
            </div>
        </div>*/
    ?>
    
    <!--<div class="testimonial-card card-2">
        <div class="testimonial-name">
            <h2>John. D</h2>
        </div>
        <div class="testimonial-review">
            <div class="testimonial-stars">
                <div class="stars filled">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                </div>
                <div class="stars empty">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                </div>
            </div>

            <div class="testimonial-text">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum. Quisquam, voluptatum. Quisquam, voluptatum.</p>
            </div>
        </div>
        
        
        <div class="testimonial-dish">
            <h3>3. Vegetariana</h3>
        </div>
    </div>

    <div class="testimonial-card card-3">
        <div class="testimonial-name">
            <h2>John. D</h2>
        </div>
        <div class="testimonial-review">
            <div class="testimonial-stars">
                <div class="stars filled">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                    <img src="../assets/menu/star-filled.png">
                </div>
                <div class="stars empty">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                    <img src="../assets/menu/star-empty.png">
                </div>
            </div>

            <div class="testimonial-text">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum. Quisquam, voluptatum. Quisquam, voluptatum.</p>
            </div>
        </div>
        
        
        <div class="testimonial-dish">
            <h3>3. Vegetariana</h3>
        </div>
    </div>-->
  
</div>
