<?php $themnific_redux = get_option( 'themnific_redux' ); ?>


<span>
	<ul class="social-menu tranz">
            
		<?php if (empty($themnific_redux['tmnf-social-rss'])) {} else { ?>
		<li class="sprite-rss"><a title="Rss Feed" href="<?php echo esc_url($themnific_redux['tmnf-social-rss']);?>"><i class="fas fa-rss"></i><span>RSS Feed</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-facebook'])) {} else { ?>
		<li class="sprite-facebook"><a class="mk-social-facebook" title="Facebook" href="<?php echo esc_url($themnific_redux['tmnf-social-facebook']);?>"><i class="fab fa-facebook-f"></i><span>Facebook</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-twitter'])) {} else { ?>
		<li class="sprite-twitter"><a class="mk-social-twitter-alt" title="Twitter" href="<?php echo esc_url($themnific_redux['tmnf-social-twitter']);?>"><i class="fab fa-twitter"></i><span>Twitter</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-google'])) {} else { ?>
		<li class="sprite-google"><a class="mk-social-googleplus" title="Google+" href="<?php echo esc_url($themnific_redux['tmnf-social-google']);?>"><i class="fab fa-google-plus-square"></i><span>Google+</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-flickr'])) {} else { ?>
		<li class="sprite-flickr"><a class="mk-social-flickr" title="Flickr" href="<?php echo esc_url($themnific_redux['tmnf-social-flickr']);?>"><i class="fab fa-flickr"></i><span>Flickr</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-500'])) {} else { ?>
		<li class="sprite-px"><a class="differ2" title="500px" href="<?php echo esc_url($themnific_redux['tmnf-social-500']);?>"><i class="fab fa-500px"></i><span>500px</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-instagram'])) {} else { ?>
		<li class="sprite-instagram"><a class="mk-social-photobucket" title="Instagram" href="<?php echo esc_url($themnific_redux['tmnf-social-instagram']);?>"><i class="fab fa-instagram"></i><span>Instagram</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-pinterest'])) {} else { ?>
		<li class="sprite-pinterest"><a class="mk-social-pinterest" title="Pinterest" href="<?php echo esc_url($themnific_redux['tmnf-social-pinterest']);?>"><i class="fab fa-pinterest"></i><span>Pinterest</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-youtube'])) {} else { ?>
		<li class="sprite-youtube"><a class="mk-social-youtube" title="You Tube" href="<?php echo esc_url($themnific_redux['tmnf-social-youtube']);?>"><i class="fab fa-youtube"></i><span>You Tube</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-vimeo'])) {} else { ?>
		<li class="sprite-vimeo"><a class="mk-social-vimeo" title="Vimeo" href="<?php echo esc_url($themnific_redux['tmnf-social-vimeo']);?>"><i class="fab fa-vimeo-square"></i><span>Vimeo</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-github'])) {} else { ?>
		<li class="sprite-github"><a class="" title="Github" href="<?php echo esc_url($themnific_redux['tmnf-social-github']);?>"><i class="fab fa-github"></i><span>Github</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-linkedin'])) {} else { ?>
		<li class="sprite-linkedin"><a class="mk-social-linkedin" title="LinkedIn" href="<?php echo esc_url($themnific_redux['tmnf-social-linkedin']);?>"><i class="fab fa-linkedin-in"></i><span>LinkedIn</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-skype'])) {} else { ?>
		<li class="sprite-skype"><a class="mk-social-skype" title="Skype" href="<?php echo esc_url($themnific_redux['tmnf-social-skype']);?>"><i class="fab fa-skype"></i><span>Skype</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-tumblr'])) {} else { ?>
		<li class="sprite-tumblr"><a class="mk-social-tumblr" title="Tumblr" href="<?php echo esc_url($themnific_redux['tmnf-social-tumblr']);?>"><i class="fab fa-tumblr"></i><span>Tumblr</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-foursquare'])) {} else { ?>
		<li class="sprite-foursquare"><a class="" title="Foursquare" href="<?php echo esc_url($themnific_redux['tmnf-social-foursquare']);?>"><i class="fab fa-foursquare"></i><span>Foursquare</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-dribbble'])) {} else { ?>
		<li class="sprite-dribbble"><a class="mk-social-dribbble" title="Dribbble" href="<?php echo esc_url($themnific_redux['tmnf-social-dribbble']);?>"><i class="fab fa-dribbble"></i><span>Dribbble</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-stumbleupon'])) {} else { ?>
		<li class="sprite-stumbleupon"><a class="" title="Stumbleupon" href="<?php echo esc_url($themnific_redux['tmnf-social-stumbleupon']);?>"><i class="fab fa-stumbleupon"></i><span>Stumbleupon</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-soundcloud'])) {} else { ?>
		<li><a class="" title="SoundCloud" href="<?php echo esc_url($themnific_redux['tmnf-social-soundcloud']);?>"><i class="fab fa-soundcloud"></i><span>SoundCloud</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-spotify'])) {} else { ?>
		<li class="sprite-spotify"><a class="" title="Spotify" href="<?php echo esc_url($themnific_redux['tmnf-social-spotify']);?>"><i class="fab fa-spotify"></i><span>Spotify</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-xing'])) {} else { ?>
		<li class="sprite-xing"><a class="" title="Xing" href="<?php echo esc_url($themnific_redux['tmnf-social-xing']);?>"><i class="fab fa-xing"></i><span>Xing</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-whatsapp'])) {} else { ?>
		<li class="sprite-whatsapp"><a class="" title="WhatsApp" href="<?php echo esc_url($themnific_redux['tmnf-social-whatsapp']);?>"><i class="fab fa-whatsapp"></i><span>WhatsApp</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-vk'])) {} else { ?>
		<li class="sprite-vk"><a class="" title="VK" href="<?php echo esc_url($themnific_redux['tmnf-social-vk']);?>"><i class="fab fa-vk"></i><span>VKontakte</span></a></li><?php } ?>

		<?php if (empty($themnific_redux['tmnf-social-snapchat'])) {} else { ?>
		<li><a class="" title="Snapchat" href="<?php echo esc_url($themnific_redux['tmnf-social-snapchat']);?>"><i class="fab fa-snapchat-ghost"></i><span>Snapchat</span></a></li><?php } ?>
	</ul>
</span>

	
<span>
	<ul class="social-menu tranz">
		<li><a class="" title="News" href="/news/">News</a></li>
		<li><a class="" title="Events" href="/events/">Events</a></li>
		<li class="search-item">
			<a class="searchOpen" href="#" ><i class="fa fa-search"></i><span><?php esc_html_e('Search the site','dotorg');?></span></a>
		</li>
	</ul>
</span>
