<form method="get" id="searchform" action="<?php bloginfo('url'); ?>"
	<span><input type="text" class="field" name="s"  value='<?php _e('Enter keywords...','language');?>' onfocus="if (this.value == '<?php _e('Enter keywords...','language');?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter keywords...','language');?>';}" /></span>
<div class="searchsub"><input class="search-button" type="submit"  name="submit" value="<?php _e('Search','language');?>" /></div>
    <div style="clear:both"></div>
</form>

