<div class="container-fluid footer">
		<div class="row">
			<?php if ( ! dynamic_sidebar( 'find_by_type' )) : ?>
			<?php endif; ?>
   		</div>
			<div id="footer" class="col-sm-12 columns" >
				<?php if ( ! dynamic_sidebar( 'footer' )) : ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="container-fluid hidden-xs">S
		<div class="row">
			<div class="bottom-bar-wrapper">
				<div class="bottom-bar">
					<p><?php _e('Gariweza by ','AA Kenya');?>
					<a href="https://www.aakenya.co.ke"><?php echo('AA Kenya');?></a>
					</p>
				</div>
			</div>
				</div>
				</div>
<?php wp_footer(); ?>
</body>
</html>