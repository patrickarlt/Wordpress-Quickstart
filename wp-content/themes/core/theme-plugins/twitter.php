<?php
/*
Plugin Name: Awesome Twitter Plugin
Plugin URI: http://developers.facebook.com/docs/reference/plugins/like#
Description: Pulls Down Latest Tweets (With Caching).
Author: Patrick Arlt
Version: 0.01
Author URI: http://patrickarlt.com
*/

function parse_tweet($t) {	
  $t = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" rel=\"external\">\\2</a>", $t);
  $t = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" rel=\"external\">\\2</a>", $t);
  $t = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" rel=\"external\">@\\1</a>", $t);
  $t = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" rel=\"external\">#\\1</a>", $t);
	return trim($t);
}

function tweetStream($username, $limit){
  if (false === ($raw_tweets = get_transient('awesome_twitter'))){
    $raw_tweets = wp_remote_fopen('http://api.twitter.com/1/statuses/user_timeline/'.$username.'.json?include_rts=1');
    set_transient('awesome_twitter', $raw_tweets, 60*15);
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