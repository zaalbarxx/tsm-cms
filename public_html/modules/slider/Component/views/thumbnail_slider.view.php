<div id="sliderWrapper">
  <div id="sliderContent">
    <?php
    $i = 1;
    foreach($slides as $slide){ ?>
      <div class="slide" id="slide-<?php echo $slide['slide_id']; ?>" style="background-image: url('<?php echo $slide['background_image']; ?>'); <?php if($i != 1){ echo "display: none;"; } ?>">
        <?php echo $slide['html']; ?>
      </div>
    <?php
    $i++;
    } ?>
  </div>
  <div id="sliderThumbs">
    <div class="inside">
      <span id="thumbs-pointer" style="left: 280.5px;"></span>
      <ul style="text-align: center;">
        <?php foreach($slides as $slide){ ?>
          <li>
            <a href="#" rel="<?php echo $slide['slide_id']; ?>" class="sliderThumb"><img src="<?php echo $slide['thumbnail_image']; ?>" /><?php echo $slide['thumbnail_caption']; ?></a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <script type="text/javascript">
    var stopRotation = false;

    var player;
    function floaded(){
      player = new YT.Player('rowwVideo', {
        videoId: 'ZiGCqsq9aCE',
        events:
        {
          'onStateChange': function (event)
          {
            if (event.data == YT.PlayerState.PLAYING){
              stopRotation = true;
              currentThumb = $(".sliderThumb").children().eq(0);
              $(".slide").hide();
              $("#slide-1").show();
              var thumbPositionLeft = $(currentThumb).position().left, // get current li position
                thumbWidth = $(currentThumb).outerWidth(), // get current li width
                pointerWidth = $("#thumbs-pointer").outerWidth(),
                left = thumbPositionLeft + (thumbWidth/2) - (pointerWidth/2); // get current li width
              $("#thumbs-pointer").animate({ 'left': left });
            }
          }
        }

      });
    }

    $(".sliderThumb").click( function(){
      currentThumb = $(this);
      $(".slide").fadeOut();
      $("#slide-" + $(this).attr("rel")).fadeIn();
      var thumbPositionLeft = $(currentThumb).position().left, // get current li position
        thumbWidth = $(currentThumb).outerWidth(), // get current li width
        pointerWidth = $("#thumbs-pointer").outerWidth(),
        left = thumbPositionLeft + (thumbWidth/2) - (pointerWidth/2); // get current li width
      $("#thumbs-pointer").animate({ 'left': left });

      stopRotation = true;
      return false;
    });
    $(document).ready(function() {
      var itemInterval = 5000;
      var fadeTime = 500;
      var numberOfItems = $('#sliderContent').children().length;
      var currentThumb = $(".sliderThumb").children().eq(0);
      var currentItem = 0;
      var infiniteLoop = setInterval(function(){
        if(stopRotation == false){
          $('#sliderContent').children().eq(currentItem).fadeOut();
          if(currentItem == numberOfItems-1){
            currentItem = 0;
          }else{
            currentItem++;
          }
          currentThumb = $(".sliderThumb").children().eq(currentItem);
          var thumbPositionLeft = $(currentThumb).position().left, // get current li position
            thumbWidth = $(currentThumb).outerWidth(), // get current li width
            pointerWidth = $("#thumbs-pointer").outerWidth(),
            left = thumbPositionLeft + (thumbWidth/2) - (pointerWidth/2); // get current li width
          $("#thumbs-pointer").animate({ 'left': left });
          $('#sliderContent').children().eq(currentItem).fadeIn();
        }
      }, itemInterval);

    });
  </script>
</div>