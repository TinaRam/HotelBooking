<?php  if (count($feilmelding) > 0) : ?>
  <div class="feil" id="feilmelding">
  	<?php foreach ($feilmelding as $feil) : ?>
  	  <p><?php echo $feil ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>
