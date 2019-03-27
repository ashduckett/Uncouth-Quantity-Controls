<?php
    class UQCPluginOptions {
        /* A single instance of this class */
        private static $instance = null;

        /* Saved options */
        public $options;

        /*-----------------------------------------*
         * Constructor
         *----------------------------------------*/

         /**
          * Creates or returns an instance of this class.
          *
          * @return UQCPluginOptions A single instance of this class.
          */
          public static function get_instance() {
              if (null == self::$instance) {
                  self::$instance = new self;
              }
              return self::$instance;
          }

          /**
           * Initialises the plugin by setting localisation, filters and adminstrative functions.
           */
          private function __construct() { 
              // Add page to the admin menu
              add_action('admin_menu', array(&$this, 'add_page'));

              // Register page options
              add_action('admin_init', array(&$this, 'register_page_options'));

              // CSS rules for colour picker
              wp_enqueue_style('wp-color-picker');

              // Register javascript
              add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_js'));

              // Get registered options
              $this->options = get_option('uqc_settings_options');
          }

          /*-----------------------------------------*
           * Functions
           *-----------------------------------------*

           /**
            * Function that will add the options page under Settings Menu.
            */
            public function add_page() { 
                add_options_page('Uncouth Minicart Quantity Control Options', 
                    'Uncouth Minicart Quantity Control', 
                    'manage_options', 
                    'uncouth-minicart-quantity-options', 
                    array($this, 'display_page')
                );
            }

            /**
             * Function that will display the options page.
             */
            public function display_page() { 
                ?>
                <div class="wrap">
                    <!-- <h2>Theme Options</h2> -->
                    <form method="post" action="options.php">     
                    <?php 
                        settings_fields(__FILE__);      
                        do_settings_sections(__FILE__);
                        submit_button();
                    ?>
                    </form>
                </div>
                <?php    
            }

            /**
             * Function that will register admin page options.
             */
            public function register_page_options() { 
                // Add section for options
                add_settings_section('uqc_section', 'Uncouth Quantity Control Options', array($this, 'display_section'), __FILE__);

                // Add title field. We don't want this.
                add_settings_field('uqc_enabled_field', 'Enabled', array($this, 'enabled_settings_field'), __FILE__, 'uqc_section');
                add_settings_field('uqc_show_subtotal_field', 'Show Subtotal', array($this, 'show_subtotal_settings_field'), __FILE__, 'uqc_section');
                add_settings_field('uqc_circular_field', 'Circular Quantity Buttons', array($this, 'circular_settings_field'), __FILE__, 'uqc_section');
                add_settings_field('uqc_btn_bgcol_field', 'Qty Change Button Background Color', array( $this, 'bg_settings_field' ), __FILE__, 'uqc_section' );
                add_settings_field('uqc_btn_forecol_field', 'Qty Change Button Text Color', array( $this, 'forecolour_settings_field' ), __FILE__, 'uqc_section' );

                register_setting(__FILE__, 'uqc_settings_options', array($this, 'validate_options'));
            }

            /**
             * Function that will add javascript file for colour picker.
             */
            public function enqueue_admin_js() { 
                wp_enqueue_script( 'uqc_custom_js', plugins_url( '/uncouth-quantity-controls/js/uqc_custom.js'), array( 'jquery', 'wp-color-picker' ), '', true  );
            }

            /**
             * Function that will validate all fields.
             */
            public function validate_options($fields) { 
                $valid_fields = array();
                 
                $enabled = $fields['enabled'];
                $showSubtotal = $fields['show_subtotal'];
                $circular = $fields['circular'];
                 
                // Validate Background Color
                $background = trim( $fields['background']);
                $background = strip_tags( stripslashes( $background ) );

                $forecolour = trim($fields['forecolour']);
                $forecolour = strip_tags(stripslashes($forecolour));

                // Check if is a valid hex color
                if( FALSE === $this->check_colour( $background ) ) {
                 
                    // Set the error message
                    add_settings_error( 'uqc_settings_options', 'uqc_bg_error', 'Insert a valid color for Background', 'error' ); // $setting, $code, $message, $type
                     
                    // Get the previous valid value
                    $valid_fields['background'] = $this->options['background'];
                } else {
                    $valid_fields['background'] = $background;  
                }

                // Check if is a valid hex color
                if( FALSE === $this->check_colour( $forecolour ) ) {
                 
                    // Set the error message
                    add_settings_error( 'uqc_settings_options', 'uqc_forecolour_error', 'Insert a valid color for Forecolour', 'error' ); // $setting, $code, $message, $type
                     
                    // Get the previous valid value
                    $valid_fields['forecolour'] = $this->options['forecolour'];
                } else {
                    $valid_fields['forecolour'] = $background;  
                }
                 
                $valid_fields['enabled'] = $enabled;
                $valid_fields['show_subtotal'] = $showSubtotal;
                $valid_fields['circular'] = $circular;
                $valid_fields['background'] = $background;
                $valid_fields['forecolour'] = $forecolour;

                return apply_filters('validate_options', $valid_fields, $fields);
            }



            /**
             * Function that will check if value is a valid HEX colour.
             */
            public static function check_colour($value) { 
                if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
                    return true;
                }
                 
                return false;
            }

            /**
             * Callback function for settings section
             */
            public function display_section() { }
            
            /**
             * Functions that display the fields.
             */
            public function enabled_settings_field() { 
                echo '<input type="checkbox" name="uqc_settings_options[enabled]" value="1" ' . checked('1', isset($this->options['enabled']), false);
            }

            public function show_subtotal_settings_field() {
                echo '<input type="checkbox" name="uqc_settings_options[show_subtotal]" value="1" ' . checked('1', isset($this->options['show_subtotal']), false);
            }

            public function circular_settings_field() { 
                echo '<input type="checkbox" name="uqc_settings_options[circular]" value="1" ' . checked('1', isset($this->options['circular']), false);
            }
            
            public function bg_settings_field() { 
                $val = ( isset( $this->options['background'])) ? $this->options['background'] : '';
                echo '<input type="text" name="uqc_settings_options[background]" value="' . $val . '" class="uqc-color-picker" >';
            }

            public function forecolour_settings_field() { 
                $val = ( isset( $this->options['forecolour'])) ? $this->options['forecolour'] : '';
                echo '<input type="text" name="uqc_settings_options[forecolour]" value="' . $val . '" class="uqc-color-picker" >';
            }
    }

    UQCPluginOptions::get_instance();