<?php

if (get_transient("has_post_thumbnail") == "no") {
    echo "<div id='message' class='error'><p><strong>You must select Featured Image. Your Post is saved but it can not be published.</strong></p></div>";
    delete_transient("has_post_thumbnail");
  }