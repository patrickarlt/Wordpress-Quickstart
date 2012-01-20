<?php
/*
Plugin Name: Awesome Facebook Plugin
Plugin URI: http://developers.facebook.com/docs/reference/plugins/like
Description: Show Latest Facebook Updates.
Author: Patrick Arlt
Version: 0.01
Author URI: http://patrickarlt.com
*/

function facebookStream($userid, $limit){
  //delete_transient('awesome_facebook');

  if (false === ($raw_statuses = get_transient('awesome_facebook'))){

    $raw_statuses = wp_remote_fopen('http://graph.facebook.com/'.$userid.'/feed');

    set_transient('awesome_facebook', $raw_statuses, 0);

  }

  $statuses = json_decode($raw_statuses);

  $count = $limit;
  echo('<div class="awesome-facebook">');
    echo("<a href='http://www.facebook.com/pages/Edris-Salon/123041211184' id='header-facebook-link' class='ir'>Facebook</a>");

  echo('<ul>');
  
  $printed_statuses = 0;
  
    foreach($statuses->data as $status){

      if($printed_statuses < $limit){        

      $created_ago = human_time_diff(strtotime($status->created_time));
            
      echo('<li class="fb-status-'.$status->type.'">');

        switch ($status->type) {
          case 'status':
            echo('<p>'.$status->message);
            echo('<br /><time datetime="'.$status->created_time.'">'.$created_ago.' ago.</time> <a href="http://www.facebook.com/pages/Edris-Salon/123041211184">Like Us On Facebook</a></p>');
            $printed_statuses++;
            break;
       
          case 'link':
            echo('<figure class="clearfix"><a href="'.$status->link.'" class="left"><img src="'.$status->picture.'" alt="'.$status->name.'" /></a>');
            echo('<figcaption class="left">');
            echo('<p>'.$status->message);
            if($status->name){echo('<br><strong>'.$status->name.'</strong>');};
           if($status->link){ echo('<br /><a href='.$status->link.'>'.$status->link.'</a>');};
            echo('<br /><time datetime="'.$status->created_time.'">'.$created_ago.' ago.</time> <a href="http://www.facebook.com/pages/Edris-Salon/123041211184">Like Us On Facebook</a></p>');
            echo('</figcaption>');
            echo('</figure>');
            $printed_statuses++;            
            break;

          case 'photo':
            if($status->name || $status->message){
              echo('<figure class="clearfix"><a href="'.$status->link.'" class="left"><img src="'.$status->picture.'" alt="'.$status->name.'" /></a><figcaption class="left"><strong>'.$status->name.'</strong><p>'.$status->message.'<br /><time datetime="'.$status->created_time.'">'.$created_ago.' ago.</time> <a href="http://www.facebook.com/pages/Edris-Salon/123041211184">Like Us On Facebook</a></p></figcaption></figure>');
              echo('');
              $printed_statuses++;
            }
            break;
          
          default:
            //$printed_statuses++;
            break;
        }
      
      echo('</li>');
      } else {
        break;
      }    

    }
  
  echo('</ul>');
    echo('</div>');

}

?>