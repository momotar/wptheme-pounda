					<?php
						$prev_post = get_previous_post();
						$next_post = get_next_post();
					?>
					
					<div class="post-navigation">
						
						<div class="post-navigation-inner">
					
							<?php
							if (!empty( $prev_post )): ?>
							
								<div class="post-nav-prev">
									<p><?php _e('Previous', 'lovecraft'); ?></p>
									<h4>
										<a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php _e('Previous post', 'pounda'); echo ': ' . esc_attr( get_the_title($prev_post) ); ?>">
											<?php echo get_the_title($prev_post); ?>
										</a>
									</h4>
								</div>
							<?php endif; ?>
							
							<?php
							if (!empty( $next_post )): ?>
								
								<div class="post-nav-next">					
									<p><?php _e('Next', 'lovecraft'); ?></p>
									<h4>
										<a title="<?php _e('Next post', 'pounda'); echo ': ' . esc_attr( get_the_title($next_post) ); ?>" href="<?php echo get_permalink( $next_post->ID ); ?>">
											<?php echo get_the_title($next_post); ?>
										</a>
									</h4>
								</div>
						
							<?php endif; ?>
							
							<div class="clear"></div>
						
						</div> <!-- /post-navigation-inner -->
					
					</div> <!-- /post-navigation -->