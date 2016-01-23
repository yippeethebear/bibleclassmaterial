<?php $theme_options = pcomm_get_theme_options(); ?>

		<div role="contentinfo" class="container">
			<div class="layout">
				<footer>
					<p class="copyright">
						<?php echo stripcslashes($theme_options['pcomm_company_name']); ?> &copy; <?php echo date('Y');?> All rights reserved.
					</p>

				</footer>
			</div> <!-- end .layout -->
		</div> <!-- end .container -->

		<script>
			// loading these polyfills only where necessary
			// see registered_scripts() in functions file
			Modernizr.load([
			/*{
				test : window.JSON,
				nope : ['<?php registered_scripts( array("json2") ); ?>']
			},*/
			{
				test : Modernizr.input.placeholder,
				nope : ['<?php registered_scripts( array("placeholder") ); ?>'],
				callback : function() {
					pcomm.placeholder();
				}
			}/*,
			{
				test : Modernizr.mq('only all'),
				nope : ['<?php registered_scripts( array("respond") ); ?>']
			}*/
			]);
			</script>
			
		<!--[if lt IE 7 ]>
			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
			<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
		<![endif]-->
		
		<?php wp_footer(); ?>


	</body>

</html>