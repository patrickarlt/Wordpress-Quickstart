
  <footer>
		<p>Copyright &copy; <?php echo date("Y") ?> <?php bloginfo('name'); ?> - A <a href="http://patrickarlt.com">Patrick Arlt</a></p>
  </footer>

</div> <!--! end of #container -->
	
 	<!--	<?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
	
	<!-- Wordpress Footer Items-->
  <?php wp_footer(); ?>

  <!-- Javascript at the bottom for fast page loading -->
  <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."js/plugins.js") ?>
  <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."js/script.js") ?>

</body>
</html>
