<form role="search" method="get" class="form-search" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<input type="text" value="<?php echo get_search_query( 'true' ); ?>" name="s" id="s" class="input-medium search-query" />
	<input type="submit" id="searchsubmit" class="btn btn-primary" value="<?php _e( 'Search', 'make-mini-mf' ); ?>" />
</form>
