<form class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<input type="text" name="s" class="s rad p-border" size="30" value="<?php esc_attr_e('Search...','dotorg'); ?>" onfocus="if (this.value = '') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php esc_attr_e('Search...','dotorg'); ?>';}" />
<button class='searchSubmit ribbon' ><?php esc_attr_e('Search','dotorg'); ?></button>
</form>