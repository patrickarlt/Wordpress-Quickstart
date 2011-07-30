<?php
/*
Plugin Name: Awesome Twitter Plugin
Plugin URI: http://developers.facebook.com/docs/reference/plugins/like#
Description: Pulls tweets and caches.
Author: Patrick Arlt
Version: 0.01
Author URI: http://patrickarlt.com
*/

//http://saturnboy.com/2010/02/parsing-twitter-with-regexp/
function parse_tweet($t) {
	
	// link URLs
	//$t = preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a href="$1">$1</a>', $t);
	
	//link twitter users
  //$t = preg_replace('/@(\w+)/', '<a href="http://twitter.com/$1">@$1</a>',$t);
	
	//link twitter arguments
  //$t = preg_replace('/\s+#(\w+)/',' <a href="http://search.twitter.com/search?q=%23$1">#$1</a>', $t);

  $t = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" rel=\"external\">\\2</a>", $t);
  $t = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" rel=\"external\">\\2</a>", $t);
  $t = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" rel=\"external\">@\\1</a>", $t);
  $t = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" rel=\"external\">#\\1</a>", $t);

	return trim($t);

}

function tweetStream($username, $limit){

    //delete_transient('awesome_twitter');


  if (false === ($raw_tweets = get_transient('awesome_twitter'))){

    $raw_tweets = wp_remote_fopen('http://api.twitter.com/1/statuses/user_timeline/'.$username.'.json?include_rts=1');

    set_transient('awesome_twitter', $raw_tweets, 60*5);

  }

  $tweets = json_decode($raw_tweets);

  $count = $limit;

  echo('<ul class="awesome-twitter">');

    for($i = 0; $i <= ($count - 1); $i++){
      
      $tweet = parse_tweet($tweets[$i]->text);
      $trimmed_tweet = trim($tweets[$i]->text);
      $created_at = $tweets[$i]->created_at;
      $created_ago = human_time_diff(strtotime($tweets[$i]->created_at));
      
      ?><li><?php echo($tweet);?><br /><small><time datetime="<?php echo($created_ago); ?>"><?php echo($created_ago); ?> ago. </time></small></li>
    <?php };

  echo('</ul>');
}

?>