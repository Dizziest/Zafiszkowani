<?php

echo "<h2>Witamy,".$this->session->userdata('login')."</h2> <br/>"; ?>

<a class="button" href="<?php echo site_url('page/logout')?>">Wyloguj!</a>