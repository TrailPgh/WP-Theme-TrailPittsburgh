<?php

    if ( ! class_exists( 'dotorg_redux_config' ) ) {

        class dotorg_redux_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                $this->initSettings();

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo esc_html__( 'The compiler hook has run!','dotorg' );
                echo "<pre>";
                print_r( esc_html($changed_values )); // Values that have changed since the last save
                echo "</pre>";
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => esc_html__( 'Section via hook','dotorg' ),
                    'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>','dotorg' ),
                    'icon'   => 'el el-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;','dotorg' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview','dotorg' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview','dotorg' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo esc_html($this->theme->display( 'Name' )); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( esc_html__( 'By %s','dotorg' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( esc_html__( 'Version %s','dotorg' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . esc_html__( 'Tags','dotorg' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . esc_html__( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.','dotorg' ) . '</p>', esc_html__( 'http://codex.wordpress.org/Child_Themes','dotorg' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';

                // ACTUAL DECLARATION OF SECTIONS
                $this->sections[] = array(
                    'title'  => esc_html__( 'General Settings','dotorg' ),
                    'desc'   => esc_html__( '','dotorg' ),
                    'icon'   => 'el el-cogs',
                    'fields' => array( // header end
					

                        array(
                            'id'       => 'tmnf-main-logo',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
							'url'      => true,
                            'title'    => esc_html__( 'Main Logo','dotorg' ),
                            'desc'     => esc_html__( 'Upload a logo for your theme','dotorg' ),
                        ),
						
						array(
                            'id'       => 'tmnf-header-image',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
							'url'      => true,
                            'title'    => esc_html__( 'Header image', 'dotorg' ),
                            'subtitle'     => esc_html__( 'Upload a "header" image for blog and archives. Recommended size 1800x400px', 'dotorg' ),
                        ),
						
                        array(
                            'id'       => 'tmnf-uppercase',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Uppercase Fonts','dotorg' ),
                            'subtitle' => esc_html__( 'You can enable general uppercase here.','dotorg' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
					
					// section end
                    )
                );
				// General Layout THE END
				
				
				




                $this->sections[] = array(
                    'type' => 'divide',
                );




                $this->sections[] = array(
                    'title'  => esc_html__( 'Primary Styling','dotorg' ),
                    'desc'   => esc_html__( '','dotorg' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end



						array(
                            'id'          => 'tmnf-body-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Typography','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'body,input,button' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as general text.','dotorg' ),
                            'default'     => array(
                                'color'       => '#232323',
                                'font-style'  => '400',
                                'font-family' => 'Libre Franklin',
                                'google'      => true,
                                'font-size'   => '17px',
                                'line-height' => '30px'
                            ),
                        ),

                        array(
                            'id'       => 'tmnf-background',
                            'type'     => 'background',
                            'title'    => esc_html__( 'Main Body Background','dotorg' ),
                            'subtitle' => esc_html__( 'Body background with image, color, etc.','dotorg' ),
                            'output'   => array('body,.postbar,.give-archive-item .raised span:first-child' ),
                            'default'     => array(
                                'background-color'       => '#ffffff',
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-ghost',
							'type'      => 'color',
							'title'     => esc_html__('Ghost Background Color','dotorg'),
							'subtitle'  => esc_html__('Pick a alternative background color (similar to Main Body Background)','dotorg'),
							'default'   => '#fcfaf9',
							'output'    => array(
								'background-color' => '.ghost,.sidebar_item,.social-menu li a,#comments .navigation a,a.page-numbers,.page-numbers.dots,.events-table tbody tr:nth-child(2n+1)'
							)
						),

                        array(
                            'id'       => 'tmnf-link-color',
                            'type'     => 'link_color',
                            'title'    => esc_html__( 'Links Color Option','dotorg' ),
                            'subtitle' => esc_html__( 'Pick a link color','dotorg' ),
							'output'   => array( 'a' ),
                            'default'  => array(
                                'regular' => '#000',
                                'hover'   => '#84715C',
                                'active'  => '#000',
                            )
                        ),
						

						
						array(
							'id'        => 'tmnf-color-entry-link',
							'type'      => 'color',
							'title'     => esc_html__('Entry Links (in post texts)','dotorg'),
							'subtitle'  => esc_html__('Pick a custom color for post links.','dotorg'),
							'default'   => '#84715c',
							'output'    => array(
								'color' => '.entry p a',
							)
						),
						
                        array(
                            'id'       => 'tmnf-primary-border',
							'type'      => 'color',
							'title'     => esc_html__('Borders Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for primary borders','dotorg'),
							'default'   => '#efeeed',
							'output'    => array(
								'border-color' => '.p-border,.sidebar_item,.meta,h3#reply-title,.tagcloud a,.page-numbers,ul.menu>li>a,input,textarea,select,.nav_item a,.tp_recent_tweets ul li,.widgetable li.cat-item',
							)
						),
						
                        array(
                            'id'       => 'tmnf-secondary-border',
							'type'      => 'color',
							'title'     => esc_html__('Secondary Borders Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for primary borders','dotorg'),
							'default'   => '#000',
							'output'    => array(
								'background-color' => 'h2.widget:after',
							)
						),
						
						array(
							'id'        => 'tmnf-text-sidebar',
							'type'      => 'color',
							'title'     => esc_html__('Sidebar Text Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for sidebar text.','dotorg'),
							'default'   => '#000',
							'output'    => array(
								'color' => '#sidebar,.post-pagination span',
							)
						),
						
						array(
							'id'        => 'tmnf-links-sidebar',
							'type'      => 'color',
							'title'     => esc_html__('Sidebar Link Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for sidebar links.','dotorg'),
							'default'   => '#000',
							'output'    => array(
								'color' => '.widgetable a',
							)
						),


					// section end
                    )
                );
				// Primary styling THE END
				




                $this->sections[] = array(
                    'title'  => esc_html__( 'Header Styling','dotorg' ),
                    'desc'   => esc_html__( '','dotorg' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end
						
						array(
							'id'        => 'tmnf-bg-myheader',
							'type'      => 'color',
							'title'     => esc_html__('(Fallback) Header Background Color','dotorg'),
							'subtitle'  => esc_html__('Pick a bg color for header. On mobile devices is transparent header disabled.','dotorg'),
							'default'   => '#111',
							'output'    => array(
								'background-color' => '#header',
							)
						),

						array(
                            'id'          => 'tmnf-header-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Navigation Typography','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.nav>li>a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as navigation text.','dotorg' ),
                            'default'     => array(
                                'color'       => '#fff',
                                'font-weight'  => '600',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '15px'
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-links-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Header Link Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for header links.','dotorg'),
							'default'   => '#fff',
							'output'    => array(
								'color' => '#header h1 a,a.searchOpen,.topnav ul.social-menu li a',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Navigation Links: Hover Color','dotorg'),
							'subtitle'  => esc_html__('Pick a hover color for header links.','dotorg'),
							'default'   => '#ccc',
							'output'    => array(
								'color' => 'li.current-menu-item>a,#header .headcol a:hover,.nav>li>a:hover',
							)
						),
						
						array(
							'id'   => 'info_normal',
							'type' => 'info',
							'title' => esc_html__('Sub-menu + Special menu button','dotorg'),
							'style' => 'success',
						),
						
						
						
						array(
							'id'        => 'tmnf-sub-bg-myheader',
							'type'      => 'color',
							'title'     => esc_html__('Sub-menu Background Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for header text.','dotorg'),
							'default'   => '#f96939',
							'output'    => array(
								'background-color' => '.nav li ul',
								'border-bottom-color' => '.nav>li>ul:after',
							)
						),


						array(
                            'id'          => 'tmnf-sub-header-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Sub-menu Typography','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.nav ul li>a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as navigation text.','dotorg' ),
                            'default'     => array(
                                'color'       => '#fff',
                                'font-weight'  => '400',
                                'font-family' => 'Libre Franklin',
                                'google'      => true,
                                'font-size'   => '13px',
                                'line-height' => '18px'
                            ),
                        ),
						

						
						
						array(
							'id'        => 'tmnf-special-bg',
							'type'      => 'color',
							'title'     => esc_html__('Menu Button: Background Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for header text.','dotorg'),
							'default'   => '#f2bd54',
							'output'    => array(
								'background-color' => '#main-nav>li.special>a',
							)
						),
						
						
						array(
							'id'        => 'tmnf-special-text',
							'type'      => 'color',
							'title'     => esc_html__('Menu Button: Text Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for header text.','dotorg'),
							'default'   => '#000',
							'output'    => array(
								'color' => '#main-nav>li.special>a',
							)
						),


						array(
							'id'   => 'info_normal',
							'type' => 'info',
							'title' => esc_html__('Spacing of the Header','dotorg'),
							'style' => 'success',
						),

                        array(
                            'id'             => 'tmnf-width-header',
                            'type'           => 'dimensions',
                            'output'   => array( '#titles' ),
                            'units'          => 'px', 
                            'units_extended' => 'true',  
                            'height'          => false, 
                            'title'          => esc_html__( 'Header Title/Logo Width Option','dotorg' ),
                            'subtitle'       => esc_html__( 'Choose the width limitation for header logo.','dotorg' ),
                            'default'        => array(
                                'width'  => 250,
                            )
                        ),

                        array(
                            'id'       => 'tmnf-spacing-header',
                            'type'     => 'spacing',
                            'output'   => array( '#titles,.header_fix' ),
                            'mode'     => 'padding',
                            'all'      => false,
                            'right'         => false,    
                            'left'          => false,     
                            'units'         => 'px',      
                            'title'    => esc_html__( 'Header Title/Logo Spacing','dotorg' ),
                            'subtitle' => esc_html__( 'Choose the margin for header logo.','dotorg' ),
                            'default'  => array(
                                'padding-top'    => '30px',
                                'padding-bottom' => '29px',
                            )
                        ),
						

                        array(
                            'id'       => 'tmnf-spacing-nav',
                            'type'     => 'spacing',
                            'output'   => array( '#main-nav>li' ),
                            'mode'     => 'padding',
                            'all'      => false,
                            'right'         => false,    
                            'left'          => false,     
                            'units'         => 'px',      
                            'title'    => esc_html__( 'Header Navigation Spacing','dotorg' ),
                            'subtitle' => esc_html__( 'Choose the margin for header navigation.','dotorg' ),
                            'default'  => array(
                                'padding-top'    => '18px',
                                'padding-bottom' => '16px',
                            )
                        ),


					// section end
                    )
                );
				// header styling THE END






                $this->sections[] = array(
                    'title'  => esc_html__( 'Footer Styling','dotorg' ),
                    'desc'   => esc_html__( '','dotorg' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end

			
					

                        array(
                            'id'       => 'tmnf-footer-logo',
                            'type'     => 'media',
							'default'  => '',
							'readonly' => false,
                            'preview'  => true,
                            'title'    => esc_html__( 'Footer Logo','dotorg' ),
                            'desc'     => esc_html__( 'Upload a footer logo for your theme.','dotorg' ),
                        ),
						
						
						array(
                            'id'       => 'tmnf-footer-editor',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Footer Text','dotorg' ),
                            'subtitle' => esc_html__( 'Just like a text box widget.','dotorg' ),
                            'desc'     => esc_html__( 'This field is HTML validated!','dotorg' ),
							'default'  => '',
                            'validate' => 'html',
						),

						array(
                            'id'          => 'tmnf-footer-typography',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Footer Typography','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '#footer,#footer input,#footer .bottom-menu li a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography used as footer text.','dotorg' ),
                            'default'     => array(
                                'color'       => '#000',
                                'font-style'  => '400',
                                'font-family' => 'Libre Franklin',
                                'google'      => true,
                                'font-size'   => '15px',
                                'line-height' => '34px'
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-myfooter',
							'type'      => 'background',
							'title'     => esc_html__('Footer Background Color','dotorg'),
							'subtitle'  => esc_html__('Pick a background color for footer.','dotorg'),
							
                            'output'   => array('#footer,#footer .searchform input.s' ),
                            'default'     => array(
                                'background-color'       => '#f2bd54',
                            ),
						),
						
						array(
							'id'        => 'tmnf-links-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Links - Color','dotorg'),
							'subtitle'  => esc_html__('Pick a color for footer links.','dotorg'),
							'default'   => '#000000',
							'output'    => array(
								'color' => '#footer a,#footer h2,#footer h3,#footer #serinfo-nav li a,#footer .meta,#footer .meta a,#footer .searchform input.s',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-myfooter',
							'type'      => 'color',
							'title'     => esc_html__('Footer Links - Hover Color','dotorg'),
							'subtitle'  => esc_html__('Pick a hover color for footer links.','dotorg'),
							'default'   => '#f96939',
							'output'    => array(
								'color' => '#footer a:hover',
							)
						),
						
						
                        array(
                            'id'       => 'tmnf-footer-border',
							'type'      => 'color',
							'title'     => esc_html__('Footer Borders','dotorg'),
							'subtitle'  => esc_html__('Pick a color for footer borders.','dotorg'),
							'default'   => '#f2c771',
							'output'    => array(
								'border-color' => '#footer li.cat-item,.footer-logo,#copyright,#footer .tagcloud a,#footer ul.menu>li>a,#footer .tp_recent_tweets ul li,#footer .p-border,#footer .searchform input.s,#footer input,#footer .landing-section',
                                'background-color'       => '#footer h2.widget:after',
							)
						),


					// section end
                    )
                );
				// footer styling THE END









                $this->sections[] = array(
                    'title'  => esc_html__( 'Typography','dotorg' ),
                    'desc'   => esc_html__( '','dotorg' ),
                    'icon'   => 'el el-bold',
                    'fields' => array( // header end


						array(
                            'id'          => 'tmnf-h1',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H1 Font Style','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h1,.header_fix p' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H1.','dotorg' ),
                            'default'     => array(
                                'color'       => '#000',
                                'font-weight'  => '700',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '20px',
                                'line-height' => '20px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2-large',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Post Titles','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h1.entry-title,h2.archiv,.slideinside h2' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H2.','dotorg' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '40px',
                                'line-height' => '48px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2-list',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Lists: Post Titles','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.small_post h2' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H2.','dotorg' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '28px',
                                'line-height' => '36px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h2',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H2 Font Style','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h2,.entry h1,.entry h2,.entry h3,.entry h4,.entry h5,.entry h6' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H2.','dotorg' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '22px',
                                'line-height' => '28px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h3',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H3 Font Style','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h3,.comment-author cite,td.date' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H3.','dotorg' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '20px',
                                'line-height' => '30px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h4',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H4 Font Style','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h4,.tptn_posts_widget li::before' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H4.','dotorg' ),
                            'default'     => array(
                                'color'       => '#222',
                                'font-weight'  => '700',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '18px',
                                'line-height' => '28px'
                            ),
                        ),
						
						array(
                            'id'          => 'tmnf-h5',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H5 Font Style + Buttons','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h5,.tab-post h4,.tptn_title,ul.menu>li>a,#serinfo-nav li a,a.mainbutton,.give-btn,.submit,.nav-previous a,#comments .reply a,.post-pagination,.mc4wp-form input,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.tmnf_events_widget a,.eleslideinside .su-button span' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H5.','dotorg' ),
                            'default'     => array(
                                'color'       => '#000',
                                'font-weight'  => '700',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '14px',
                                'line-height' => '18px'
                            ),
                        ),	
						
						array(
                            'id'          => 'tmnf-h6',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'H6 Font Style','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( 'h6,.social-menu a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for heading H6.','dotorg' ),
                            'default'     => array(
                                'color'       => '#a5a5a5',
                                'font-weight'  => '500',
                                'font-family' => 'Poppins',
                                'google'      => true,
                                'font-size'   => '11px',
                                'line-height' => '20px'
                            ),
                        ),
						


					// section end
                    )
                );
				// typography styling THE END










                $this->sections[] = array(
                    'title'  => esc_html__( 'Other Styling','dotorg' ),
                    'desc'   => esc_html__( '','dotorg' ),
                    'icon'   => 'el el-tint',
                    'fields' => array( // header end
						
	
						
						array(
                            'id'          => 'tmnf-meta',
                            'type'        => 'typography',
                            'title'       => esc_html__( 'Meta Sections - Font Style','dotorg' ),
                            'google'      => true,
                            'font-backup' => true,
                            'all_styles'  => true,
                            'output'      => array( '.meta,.meta a' ),
                            'units'       => 'px',
                            'subtitle'    => esc_html__( 'Select the typography for meta sections.','dotorg' ),
                            'default'     => array(
                                'color'       => '#84715c',
                                'font-weight'  => '500',
                                'font-family' => 'Libre Franklin',
                                'google'      => true,
                                'font-size'   => '13px',
                                'line-height' => '18px'
                            ),
                        ),
						
						array(
							'id'        => 'tmnf-color-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Background Color','dotorg'),
							'subtitle'  => esc_html__('Pick a custom background color for main buttons, special sections etc.','dotorg'),
							'default'   => '#f96939',
							'output'    => array(
								'background-color' => 'a.searchSubmit,.ribbon,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button.alt, .woocommerce button.button, .woocommerce input.button,#respond #submit,li.current a,.page-numbers.current,a.mainbutton,button.give-btn-reveal,.give-submit.give-btn,#submit,#comments .navigation a,.tagssingle a,.contact-form .submit,.wpcf7-submit,a.comment-reply-link,ul.social-menu li a:hover,.owl-nav>div',
								'border-color' => 'input.button,button.submit',
								'color' => 'ul.menu>li.current-menu-item>a,.meta_more a',
							)
						),
						
						array(
							'id'        => 'tmnf-text-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Links/Texts - Color','dotorg'),
							'subtitle'  => esc_html__('Pick a custom text color for main buttons, special sections etc.','dotorg'),
							'default'   => '#fff',
							'output'    => array(
								'color' => 'a.searchSubmit,.ribbon,.ribbon a,.ribbon p,#footer .ribbon,.woocommerce #respond input#submit, .woocommerce a.button,.woocommerce button.button.alt, .woocommerce button.button, .woocommerce input.button,#comments .reply a,#respond #submit,#footer a.mainbutton,a.mainbutton,button.give-btn-reveal,.give-submit.give-btn,.tmnf_icon,a.mainbutton,#submit,#comments .navigation a,.tagssingle a,.wpcf7-submit,.mc4wp-form input[type="submit"],a.comment-reply-link,#footer #hometab li.current a,.page-numbers.current,.owl-nav>div',
							)
						),
						
						array(
							'id'        => 'tmnf-hover-color-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Background Hover Color','dotorg'),
							'subtitle'  => esc_html__('Pick a custom background color for main buttons, special sections etc.','dotorg'),
							'default'   => '#f2bd54',
							'output'    => array(
								'background-color' => 'a.searchSubmit:hover,.ribbon:hover,a.mainbutton:hover,button.give-btn-reveal:hover,.give-submit.give-btn:hover,.entry a.ribbon:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover',
								'border-color' => 'input.button:hover,button.submit:hover'
							)
						),
						
						array(
							'id'        => 'tmnf-hover-text-elements',
							'type'      => 'color',
							'title'     => esc_html__('Elements Links/Texts - Hover Color','dotorg'),
							'subtitle'  => esc_html__('Pick a custom text color for main buttons, special sections etc.','dotorg'),
							'default'   => '#000',
							'output'    => array(
								'color' => '#footer a.mainbutton:hover,.ribbon:hover,.ribbon:hover a,.ribbon a:hover,.entry a.ribbon:hover,a.mainbutton:hover,button.give-btn-reveal:hover,.give-submit.give-btn:hover,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover',
							)
						),
						
						
						array(
							'id'        => 'tmnf-images-bg',
							'type'      => 'color',
							'title'     => esc_html__('Images Background Color','dotorg'),
							'subtitle'  => esc_html__('Pick a custom background color for theme images.','dotorg'),
							'default'   => '#000',
							'output'    => array(
								'background-color' => '.imgwrap,.post-nav-image,.entryhead,.page-header',
							)
						),
						
						
						
						array(
							'id'        => 'tmnf-images-text',
							'type'      => 'color',
							'title'     => esc_html__('Images Text/Link Color','dotorg'),
							'subtitle'  => esc_html__('Pick a custom text color for image texts (overlay)','dotorg'),
							'default'   => '#fff',
							'output'    => array(
								'color' => '.slideinside,.slideinside p,.slideinside a,.page-header,.page-header a,.page-header h1,.page-header h2,.page-header p',
							)
						),




					// section end
                    )
                );
				// other styling THE END









                $this->sections[] = array(
                    'type' => 'divide',
                );	



                
                $this->sections[] = array(
                    'title'  => esc_html__( 'Post Settings','dotorg' ),
                    'desc'   => esc_html__( '','dotorg' ),
                    'icon'   => 'el el-edit',
                    'fields' => array( // header end


                        array(
                            'id'       => 'tmnf-post-image-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable Featured Image','dotorg' ),
                            'subtitle' => esc_html__( 'Tick to disable featured image in single post page.','dotorg' ),
                            'desc'     => esc_html__( '','dotorg' ),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
					

						
                        array(
                            'id'       => 'tmnf-post-meta-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Disable "Meta" sections','dotorg' ),
                            'subtitle' => esc_html__( 'Tick to disable post "inforamtions" - date, category etc. below post titles','dotorg' ),
                            'desc'     => esc_html__( '','dotorg' ),
                            'default'  => '0'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-author-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Author Info Section','dotorg' ),
                            'subtitle' => esc_html__( 'Tick to disable author section in single post page.','dotorg' ),
                            'desc'     => esc_html__( '','dotorg' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-nextprev-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Next/Previous Post Section','dotorg' ),
                            'subtitle' => esc_html__( 'Tick to disable Next/Previous section in single post page.','dotorg' ),
                            'desc'     => esc_html__( '','dotorg' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-likes-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Tags Section','dotorg' ),
                            'subtitle' => esc_html__( 'Tick to disable likes/tags section in single post page.','dotorg' ),
                            'desc'     => esc_html__( '','dotorg' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
						array(
                            'id'       => 'tmnf-post-related-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Related posts Section','dotorg' ),
                            'subtitle' => esc_html__( 'Tick to disable related section in single post page.','dotorg' ),
                            'desc'     => esc_html__( '','dotorg' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),
						
					
					
					// section end
                    )
                );
				// post settings THE END





                
          $this->sections[] = array(
                    'title'  => esc_html__( 'Social Networks','dotorg'),
                    'icon'   => 'el el-share',
                    'fields' => array( // header end
				
					

						
						array(
                            'id'       => 'tmnf-search-bottom-dis',
                            'type'     => 'checkbox',
                            'title'    => esc_html__( 'Enable Social Networks Section (above footer)','dotorg' ),
                            'subtitle' => esc_html__( 'You can enable section here.','dotorg' ),
                            'default'  => '1'// 1 = on | 0 = off
                        ),

                        array(
                            'id'       => 'tmnf-social-rss',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Rss Feed','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
                        array(
                            'id'       => 'tmnf-social-facebook',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Facebook','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-twitter',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Twitter','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-google',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Google+','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-pinterest',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Pinterest','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-instagram',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Instagram','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-youtube',
                            'type'     => 'text',
                            'title'    => esc_html__( 'You Tube','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-vimeo',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Vimeo','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-tumblr',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Tumblr','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-500',
                            'type'     => 'text',
                            'title'    => esc_html__( '500px','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-flickr',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Flickr','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-linkedin',
                            'type'     => 'text',
                            'title'    => esc_html__( 'LinkedIn','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'tmnf-social-foursquare',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Foursquare','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-dribbble',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Dribbble','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-skype',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Skype','dotorg'),
                            'subtitle' => esc_html__( 'Enter skype URL','dotorg'),
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-stumbleupon',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Stumbleupon','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-github',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Github','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
												
                        array(
                            'id'       => 'tmnf-social-soundcloud',
                            'type'     => 'text',
                            'title'    => esc_html__( 'SoundCloud','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
												
                        array(
                            'id'       => 'tmnf-social-spotify',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Spotify','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-xing',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Xing','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-whatsapp',
                            'type'     => 'text',
                            'title'    => esc_html__( 'WhatsApp','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-vk',
                            'type'     => 'text',
                            'title'    => esc_html__( 'VK','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
												
                        array(
                            'id'       => 'tmnf-social-snapchat',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Snapchat','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						

					// section end
                    )
                );
				// social networks THE END	


             $this->sections[] = array(
                    'title'  => esc_html__( 'Static Ads','dotorg'),
                    'icon'   => 'el el-website',
                    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                    'fields' => array(
						
						
						array(
                            'id'       => 'postad-script',
                            'type'     => 'textarea',
                            'title'    => esc_html__( 'Post Script Code','dotorg'),
                            'desc'     => esc_html__( 'Put your code here','dotorg'),
							'default'  => '',
						),

                        array(
                            'id'       => 'postad-image',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Post Ad - image','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL of your ad image (banner)','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
						
						
                        array(
                            'id'       => 'postad-target',
                            'type'     => 'text',
                            'title'    => esc_html__( 'Post Ad - target URL','dotorg'),
                            'subtitle' => esc_html__( 'Enter full URL','dotorg'),
                            'validate' => 'url',
                            //                        'text_hint' => array(
                            //                            'title'     => '',
                            //                            'content'   => 'Please enter a valid <strong>URL</strong> in this field.'
                            //                        )
                        ),
				
				
				
				
					// section end
                    )
                );
				// custom footer THE END	



				

                $this->sections[] = array(
                    'type' => 'divide',
                );		

                

                $this->sections[] = array(
                    'title'  => esc_html__( 'Import / Export','dotorg' ),
                    'desc'   => esc_html__( 'Import and Export your Redux Framework settings from file, text or URL.','dotorg' ),
                    'icon'   => 'el el-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your Redux options',
                            'full_width' => false,
                        ),
                    ),
                );


            }
			
			

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => esc_html__( 'Theme Information 1','dotorg' ),
                    'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>','dotorg' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => esc_html__( 'Theme Information 2','dotorg' ),
                    'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>','dotorg' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>','dotorg' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'themnific_redux',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => esc_html__( 'TrailPGH Admin','dotorg' ),
                    'page_title'           => esc_html__( 'TrailPGH Admin Panel','dotorg' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => false,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'themnific-options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'el el-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.


                

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( esc_html__( 'Hello in theme admin panel','dotorg' ), $v );
                } else {
                    $this->args['intro_text'] = esc_html__( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>','dotorg' );
                }

                // Add content after the form.
                $this->args['footer_text'] = esc_html__( 'Redux & Dannci & Themnific','dotorg' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public static function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new dotorg_redux_config();
    } else {
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            $return['warning'] = $field;

            return $return;
        }
    endif;


// TMNF admin panel styling	
function dotorg__add_css() {
    wp_register_style(
        'redux-tmnf-css',
        get_template_directory_uri() .'/redux-framework/assets/redux-themnific.css',
        array( 'redux-admin-css' ),
        time(),
        'all'
    ); 
    wp_enqueue_style('redux-tmnf-css');
}
add_action( 'redux/page/themnific_redux/enqueue', 'dotorg__add_css' );


// remove redux notices
function dotorg_remove_redux_notices() { 
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'dotorg_remove_redux_notices');