<?php
/**

 * File Type: Employer Ajax Templates

 */
if ( ! class_exists( 'cs_employer_ajax_templates' ) ) {



    class cs_employer_ajax_templates {

        /**

         * Start construct Functions

         */
        public function __construct() {

            // Profile

            add_action( 'wp_ajax_cs_employer_ajax_profile', array( &$this, 'cs_employer_ajax_profile' ) );

            add_action( 'wp_ajax_nopriv_cs_employer_ajax_profile', array( &$this, 'cs_employer_ajax_profile' ) );

            // Transactions

            add_action( 'wp_ajax_cs_ajax_trans_history', array( &$this, 'cs_ajax_trans_history' ) );

            add_action( 'wp_ajax_nopriv_cs_ajax_trans_history', array( &$this, 'cs_ajax_trans_history' ) );

            // Job Management

            add_action( 'wp_ajax_cs_ajax_manage_job', array( &$this, 'cs_ajax_manage_job' ) );

            add_action( 'wp_ajax_nopriv_cs_ajax_manage_job', array( &$this, 'cs_ajax_manage_job' ) );

            // Favourite Resumes

            add_action( 'wp_ajax_cs_ajax_fav_resumes', array( &$this, 'cs_ajax_fav_resumes' ) );

            add_action( 'wp_ajax_nopriv_cs_ajax_fav_resumes', array( &$this, 'cs_ajax_fav_resumes' ) );

            // Job Packages

            add_action( 'wp_ajax_cs_ajax_job_packages', array( &$this, 'cs_ajax_job_packages' ) );

            add_action( 'wp_ajax_nopriv_cs_ajax_job_packages', array( &$this, 'cs_ajax_job_packages' ) );

            // Change Password
            add_action( 'wp_ajax_cs_employer_change_password', array( &$this, 'cs_change_password' ) );
            add_action( 'wp_ajax_nopriv_cs_employer_change_password', array( &$this, 'cs_change_password' ) );
        }

        /**

         * End construct Functions



         * * Start Function for Creating of employer profile in Ajax

         */
        public function cs_employer_ajax_profile( $uid = '' ) {

            global $post, $current_user, $cs_form_fields2, $cs_form_fields_frontend;

            $cs_emp_funs = new cs_employer_functions();

            if ( $uid == '' ) {

                $uid = (isset( $_POST['cs_uid'] ) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : $current_user->ID;
            }

            if ( $uid != '' ) {

                $cs_user_data = get_userdata( $uid );

                $cs_comp_name = $cs_user_data->display_name;

                $cs_comp_detail = $cs_user_data->description;

                $cs_user_status = get_user_meta( $uid, 'cs_user_status', true );

                $cs_minimum_salary = get_user_meta( $uid, 'cs_minimum_salary', true );

                $cs_allow_search = get_user_meta( $uid, 'cs_allow_search', true );

                $cs_facebook = get_user_meta( $uid, 'cs_facebook', true );

                $cs_twitter = get_user_meta( $uid, 'cs_twitter', true );

                $cs_google_plus = get_user_meta( $uid, 'cs_google_plus', true );

                $cs_linkedin = get_user_meta( $uid, 'cs_linkedin', true );

                $cs_phone_number = get_user_meta( $uid, 'cs_phone_number', true );

                $cs_email = $cs_user_data->user_email;

                $cs_website = $cs_user_data->user_url;

                $cs_value = get_user_meta( $uid, 'user_img', true );

                $cs_cover_employer_img_value = get_user_meta( $uid, 'cover_user_img', true );

                $imagename_only = $cs_value;

                $cover_imagename_only = $cs_cover_employer_img_value;

                $cs_jobhunt = new wp_jobhunt();
                ?>

                <div class="cs-loader"></div>

                <?php if ( $cs_comp_name != '' ) { ?>

                    <h3 class="cs-candidate-title"><?php printf( __( 'Welcome %s', 'jobhunt' ), esc_html( $cs_comp_name ) ) ?></h3>

                <?php } ?>

                <form id="cs_employer_form" name="cs_employer_form"  enctype="multipart/form-data" method="post">

                    <div class="scetion-title">

                        <h4><?php _e( 'My Profile', 'jobhunt' ); ?></h4>

                    </div>

                    <div class="dashboard-content-holder">

                        <div class="cs-account-info">



                            <div class="cs-img-detail">

                                <div class="alert alert-dismissible user-img"> 

                                    <div class="page-wrap" id="cs_employer_img_box">

                                        <figure>

                                            <?php
                                            if ( $cs_value <> '' ) {



                                                $cs_value = cs_get_img_url( $cs_value, '' );
                                                ?>

                                                <img src="<?php echo esc_url( $cs_value ); ?>" id="cs_employer_img_img" width="100" alt="" />

                                                <div class="gal-edit-opts close"><a href="javascript:cs_del_media('cs_employer_img')" class="delete">

                                                        <span aria-hidden="true">×</span></a>

                                                </div>

                                            <?php } else { ?>

                                                <img src="<?php echo esc_url( $cs_jobhunt->plugin_url() ); ?>assets/images/upload-img.jpg" id="cs_employer_img_img" width="100" alt="" />

                                                <?php
                                            }
                                            ?>

                                        </figure>

                                    </div>

                                </div>

                                <div class="upload-btn-div">

                                    <div class="fileUpload uplaod-btn btn cs-color csborder-color">

                                        <span class="cs-color" ><?php _e( 'Browse', 'jobhunt' ); ?></span>

                                        <?php
                                        $cs_opt_array = array(
                                            'std' => $imagename_only,
                                            'id' => '',
                                            'return' => true,
                                            'cust_id' => 'cs_employer_img',
                                            'cust_name' => 'cs_employer_img',
                                            'prefix' => '',
                                        );

                                        echo force_balance_tags( $cs_form_fields2->cs_form_hidden_render( $cs_opt_array ) );

                                        $cs_opt_array = array(
                                            'std' => __( 'Browse', 'jobhunt' ),
                                            'id' => '',
                                            'force_std' => true,
                                            'return' => true,
                                            'cust_id' => '',
                                            'cust_name' => 'media_upload',
                                            'classes' => 'left cs-uploadimg upload',
                                            'cust_type' => 'file',
                                        );

                                        echo force_balance_tags( $cs_form_fields2->cs_form_text_render( $cs_opt_array ) );
                                        ?>

                                    </div>

                                    <br />

                                    <span id="cs_employer_profile_img_msg"><?php _e( 'Max file size is 1MB, Minimum dimension: 270x210 And Suitable files are .jpg & .png', 'jobhunt' ) ?></span>

                                </div>

                            </div>

                            <div class="cs-img-detail">

                                <div class="alert alert-dismissible user-img"> 

                                    <div class="page-wrap" id="cs_cover_employer_img_box">

                                        <figure>

                                            <?php
                                            if ( $cs_cover_employer_img_value <> '' ) {



                                                $cs_cover_employer_img_value = cs_get_img_url( $cs_cover_employer_img_value, 'cs_media_4' );
                                                ?>

                                                <img src="<?php echo esc_url( $cs_cover_employer_img_value ); ?>" id="cs_cover_employer_img_img" width="100" alt="" />

                                                <div class="gal-edit-opts close"><a href="javascript:cs_del_media('cs_cover_employer_img')" class="delete">

                                                        <span aria-hidden="true">×</span></a>

                                                </div>

                                            <?php } else { ?>

                                                <img src="<?php echo esc_url( $cs_jobhunt->plugin_url() ); ?>assets/images/upload-img.jpg" id="cs_cover_employer_img_img" width="100" alt="" />

                                                <?php
                                            }
                                            ?>

                                        </figure>

                                    </div>

                                </div>

                                <div class="upload-btn-div">

                                    <div class="fileUpload uplaod-btn btn cs-color csborder-color">

                                        <span class="cs-color" ><?php _e( 'Browse Cover', 'jobhunt' ); ?></span>

                                        <?php
                                        $cs_opt_array = array(
                                            'std' => $cover_imagename_only,
                                            'id' => '',
                                            'return' => true,
                                            'cust_id' => 'cs_cover_employer_img',
                                            'cust_name' => 'cs_cover_employer_img',
                                            'prefix' => '',
                                        );

                                        echo force_balance_tags( $cs_form_fields2->cs_form_hidden_render( $cs_opt_array ) );

                                        $cs_opt_array = array(
                                            'std' => __( 'Browse Cover', 'jobhunt' ),
                                            'id' => '',
                                            'return' => true,
                                            'force_std' => true,
                                            'cust_id' => '',
                                            'cust_name' => 'cover_media_upload',
                                            'classes' => 'left cs-cover-uploadimg upload',
                                            'cust_type' => 'file',
                                        );

                                        echo force_balance_tags( $cs_form_fields2->cs_form_text_render( $cs_opt_array ) );
                                        ?>

                                    </div>

                                    <br /> 

                                    <span id="cs_employer_profile_cover_msg"><?php _e( 'Max file size is 1MB, Minimum dimension: 1600x400 And Suitable files are .jpg & .png', 'jobhunt' ) ?></span>

                                </div>

                            </div>

                            <div class="input-info">

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <label><?php _e( 'Company name', 'jobhunt' ) ?></label>

                                        <?php
                                        $cs_opt_array = array(
                                            'cust_id' => 'display_name',
                                            'cust_name' => 'display_name',
                                            'std' => $cs_comp_name,
                                            'desc' => '',
                                            'classes' => 'form-control',
                                            'extra_atr' => ' placeholder="' . __( 'Company name', 'jobhunt' ) . '"',
                                            'hint_text' => '',
                                        );



                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                        ?>

                                    </div>

                                </div>



                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <label><?php _e( 'Allow In Search', 'jobhunt' ); ?></label>

                                        <div class="select-holder">

                                            <?php
                                            $cs_opt_array = array(
                                                'id' => 'allow_search',
                                                'std' => $cs_allow_search,
                                                'desc' => '',
                                                'extra_atr' => 'data-placeholder="' . __( "Please Select", "jobhunt" ) . '"',
                                                'classes' => 'form-control chosen-default chosen-select-no-single',
                                                'options' => array( '' => __( 'Please Select', 'jobhunt' ), 'yes' => __( 'Yes', 'jobhunt' ), 'no' => __( 'No', 'jobhunt' ) ),
                                                'hint_text' => '',
                                            );



                                            $cs_form_fields2->cs_form_select_render( $cs_opt_array );
                                            ?>

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <label><?php _e( 'Specialisms', 'jobhunt' ); ?></label>

                                        <div>

                                            <?php echo get_specialisms_dropdown( 'cs_specialisms', 'cs_specialisms', $uid, 'form-control chosen-select', true ) ?>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <label><?php _e( 'Description', 'jobhunt' ); ?> </label>

                                        <?php
                                        $cs_comp_detail = (isset( $cs_comp_detail )) ? $cs_comp_detail : '';
                                        echo $cs_form_fields2->cs_form_textarea_render(
                                                array( 'name' => __( 'Description', 'jobhunt' ),
                                                    'id' => 'comp_detail',
                                                    'classes' => 'col-md-12',
                                                    'cust_name' => 'comp_detail',
                                                    'std' => $cs_comp_detail,
                                                    'description' => '',
                                                    'return' => true,
                                                    'array' => true,
                                                    'cs_editor' => true,
                                                    'force_std' => true,
                                                    'hint' => ''
                                                )
                                        );
                                        ?>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="cs-social-network">

                            <div class="scetion-title">

                                <h4><?php _e( 'Social Network', 'jobhunt' ); ?></h4>

                            </div>

                            <div class="input-info">

                                <div class="row">

                                    <div class="social-media-info">

                                        <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                            <?php
                                            $cs_opt_array = array(
                                                'id' => 'facebook',
                                                'std' => $cs_facebook,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . __( 'Facebook', 'jobhunt' ) . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );

                                            $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                            ?>

                                            <i class="icon-facebook2"></i> 

                                        </div>

                                        <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                            <?php
                                            $cs_opt_array = array(
                                                'id' => 'twitter',
                                                'std' => $cs_twitter,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . __( 'Twitter', 'jobhunt' ) . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );



                                            $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                            ?>

                                            <i class="icon-twitter6"></i> </div>

                                        <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                            <?php
                                            $cs_opt_array = array(
                                                'id' => 'google_plus',
                                                'std' => $cs_google_plus,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . __( 'Google Plus', 'jobhunt' ) . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );



                                            $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                            ?>



                                            <i class="icon-googleplus7"></i> </div>

                                        <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                            <?php
                                            $cs_opt_array = array(
                                                'id' => 'linkedin',
                                                'std' => $cs_linkedin,
                                                'desc' => '',
                                                'extra_atr' => ' placeholder="' . __( 'Linkedin', 'jobhunt' ) . '"',
                                                'classes' => 'form-control',
                                                'hint_text' => '',
                                            );



                                            $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                            ?>

                                            <i class="icon-linkedin4"></i> </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="cs-contact-info">

                            <div class="scetion-title">

                                <h4><?php _e( 'Contact Information', 'jobhunt' ); ?></h4>

                            </div>

                            <div class="input-info">

                                <div class="row">

                                    <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <label><?php _e( 'Phone Number', 'jobhunt' ); ?></label>

                                        <?php
                                        $cs_opt_array = array(
                                            'id' => 'phone_number',
                                            'std' => $cs_phone_number,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . __( 'Phone Number', 'jobhunt' ) . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );

                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                        ?>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <label><?php _e( 'Email Address', 'jobhunt' ); ?></label>

                                        <?php
                                        $cs_opt_array = array(
                                            'cust_id' => 'user_email',
                                            'cust_name' => 'user_email',
                                            'std' => $cs_email,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . __( 'Email', 'jobhunt' ) . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );

                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                        ?>

                                    </div>

                                    <div class="social-input col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <label><?php _e( 'Website', 'jobhunt' ); ?></label>

                                        <?php
                                        $cs_opt_array = array(
                                            'cust_id' => 'user_url',
                                            'cust_name' => 'user_url',
                                            'std' => $cs_website,
                                            'desc' => '',
                                            'extra_atr' => ' placeholder="' . __( 'Website', 'jobhunt' ) . '"',
                                            'classes' => 'form-control',
                                            'hint_text' => '',
                                        );

                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                        ?>

                                    </div>

                                    <?php CS_FUNCTIONS()->cs_frontend_location_fields( $uid, 'employer_profile', $current_user ); ?>

                                </div>

                            </div>

                        </div>

                        <?php
                        $cs_job_cus_fields = get_option( "cs_employer_cus_fields" );

                        if ( is_array( $cs_job_cus_fields ) && sizeof( $cs_job_cus_fields ) > 0 ) {
                            ?>

                            <section class="cs-social-network">

                                <div class="scetion-title">

                                    <h4><?php _e( 'Extra Information', 'jobhunt' ); ?></h4>

                                </div>

                                <div class="input-info">

                                    <div class="row">

                                        <div class="social-media-info">

                                            <?php echo force_balance_tags( $cs_emp_funs->cs_employer_custom_fields( $uid ) ); ?>

                                        </div>

                                    </div>

                                </div>

                            </section>

                            <?php
                        }
                        ?>

                        <div class="cs-update-btn">

                            <?php
                            $cs_opt_array = array(
                                'std' => 'update_profile',
                                'id' => '',
                                'echo' => true,
                                'cust_id' => 'user_profile',
                                'cust_name' => 'user_profile',
                            );

                            $cs_form_fields2->cs_form_hidden_render( $cs_opt_array );



                            $cs_opt_array = array(
                                'std' => $uid,
                                'id' => '',
                                'echo' => true,
                                'cust_id' => 'cs_user',
                                'cust_name' => 'cs_user',
                            );

                            $cs_form_fields2->cs_form_hidden_render( $cs_opt_array );
                            ?>





                            <a href="javascript:void(0);" name="button_action" class="acc-submit cs-section-update cs-color csborder-color" onclick="javascript:ajax_employer_profile_form_save('<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', '<?php echo esc_js( wp_jobhunt::plugin_url() ); ?>', 'cs_employer_form')"><?php _e( 'Update', 'jobhunt' ); ?></a>

                            <?php
                            $cs_opt_array = array(
                                'std' => 'ajax_employer_form_save',
                                'id' => '',
                                'echo' => true,
                                'cust_name' => 'action',
                            );

                            $cs_form_fields2->cs_form_hidden_render( $cs_opt_array );



                            $cs_opt_array = array(
                                'std' => $uid,
                                'id' => '',
                                'echo' => true,
                                'cust_name' => 'post_id',
                            );

                            $cs_form_fields2->cs_form_hidden_render( $cs_opt_array );
                            ?>



                        </div>  

                    </div>

                </form>

                <script type="text/javascript">



                    /*
                     
                     * modern selection box function
                     
                     */

                    jQuery(document).ready(function ($) {

                        chosen_selectionbox();

                    });

                    /*
                     
                     * modern selection box function
                     
                     */

                    tinymce.init({
                        selector: "textarea#comp_detail",
                        menubar: false,
                        setup: function (editor) {

                            editor.on('change', function () {

                                editor.save();

                            });

                        }

                    });

                    tinymce.editors = [];

                </script>

                <?php
                die();
            }
        }

        /**

         * End Function for Creating of employer profile in Ajax

         */

        /**
         * Change Password funciton
         */
        public function cs_change_password() {

            $html = '
            <div class="scetion-title">
                <h3>' . __( 'Change Password', 'jobhunt' ) . '</h3>
            </div>
            <div class="change-pass-content-holder">
                <div class="input-info">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>' . __( 'Old Password', 'jobhunt' ) . '</label>
                            <input type="password" name="old_password" class="form-control" >
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>' . __( 'New Password', 'jobhunt' ) . '</label>
                            <input type="password" name="new_password" class="form-control" >
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>' . __( 'Confirm Password', 'jobhunt' ) . '</label>
                            <input type="password" name="confirm_password" class="form-control" >
                        </div>
                        <div class="col-md-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="button" value="' . __( 'Update', 'jobhunt' ) . '" id="employer-change-pass-trigger" class="acc-submit cs-section-update cs-color csborder-color">   
                        </div>
                    </div>
                </div>
            </div>';

            echo force_balance_tags( $html );
            die;
        }

        /**
         * Start Function how to manage job in ajax funciton
         */
        public function cs_ajax_manage_job() {

            global $post, $cs_plugin_options;

            if ( class_exists( 'cs_employer_functions' ) ) {

                $cs_emp_funs = new cs_employer_functions();
            }

            $uid = (isset( $_POST['cs_uid'] ) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : '';

            $cs_uri = (isset( $_POST['cs_uri'] ) and $_POST['cs_uri'] <> '') ? $_POST['cs_uri'] : '';

            if ( $uid != '' ) {
                ?>

                <div class="cs-manage-jobs">

                    <?php
                    $cs_emp_dashboard = isset( $cs_plugin_options['cs_emp_dashboard'] ) ? $cs_plugin_options['cs_emp_dashboard'] : '';

                    if ( $cs_emp_dashboard != '' ) {

                        $cs_employer_link = get_permalink( $cs_emp_dashboard );
                    } else {

                        $cs_employer_link = cs_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    }

                    $cs_blog_num_post = 10;

                    if ( empty( $_REQUEST['page_id_all'] ) )
                        $_REQUEST['page_id_all'] = 1;

                    $mypost = array( 'posts_per_page' => "-1", 'post_type' => 'jobs',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'cs_job_username',
                                'value' => $uid,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'cs_job_status',
                                'value' => 'delete',
                                'compare' => '!=',
                            ),
                        ),
                        'order' => "ASC" );

                    $loop_count = new WP_Query( $mypost );

                    $count_post = $loop_count->post_count;

                    $args = array(
                        'posts_per_page' => $cs_blog_num_post,
                        'paged' => $_REQUEST['page_id_all'],
                        'post_type' => 'jobs',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'cs_job_username',
                                'value' => $uid,
                                'compare' => '=',
                            ),
                            array(
                                'key' => 'cs_job_status',
                                'value' => 'delete',
                                'compare' => '!=',
                            ),
                        ),
                        'orderby' => 'ID',
                        'order' => 'DESC',
                    );

                    $custom_query = new WP_Query( $args );
                    ?>

                    <div class="scetion-title">

                        <h3><?php _e( 'Manage Jobs', 'jobhunt' ) ?></h3>

                    </div>

                    <?php
                    if ( $custom_query->have_posts() ) {



                        $get_uid = ( isset( $_GET['uid'] ) && $_GET['uid'] <> '' ) ? '&amp;uid=' . $_GET['uid'] : '';
                        ?>

                        <ul class="dashboard-list">

                            <li><span><span><?php echo absint( $cs_emp_funs->posted_jobs_num( $uid ) ) ?></span><em><?php _e( 'Job Posted', 'jobhunt' ) ?></em></span><i class="icon-suitcase5"></i></li>

                            <li><span><span><?php echo absint( $cs_emp_funs->all_jobs_apps( $uid ) ) ?></span><em><?php _e( 'Applications', 'jobhunt' ); ?></em></span><i class="icon-newspaper4"></i></li>

                            <li><span><span id="cs_user_total_active_job"><?php echo absint( $cs_emp_funs->active_jobs_num( $uid ) ) ?></span><em><?php _e( 'Active Jobs', 'jobhunt' ); ?></em></span><i class="icon-graph"></i></li>

                        </ul>

                        <div class="dashboard-content-holder">

                            <ul class = "managment-list">

                                <?php
                                while ( $custom_query->have_posts() ) : $custom_query->the_post();

                                    global $post;

                                    $job_title = $post->post_title;

                                    $job_id = $post->ID;

                                    $cs_job_package = get_post_meta( $job_id, "cs_job_package", true );

                                    $cs_job_status = get_post_meta( $job_id, "cs_job_status", true );

                                    $cs_job_expired = get_post_meta( $job_id, "cs_job_expired", true );

                                    $cs_job_status = get_post_meta( $job_id, "cs_job_status", true );

                                    $cs_job_featured = get_post_meta( $job_id, 'cs_job_featured', true );

                                    $cs_job_all_status = array( 'awaiting-activation' => __( 'Awaiting Activation', 'jobhunt' ), 'active' => __( 'Active', 'jobhunt' ), 'inactive' => __( 'Inactive', 'jobhunt' ) );

                                    $cs_shortlisted = count_usermeta( 'cs-user-jobs-wishlist', serialize( strval( $job_id ) ), 'LIKE' );

                                    if ( strpos( $cs_employer_link, "?" ) !== false ) {

                                        $cs_url = $cs_employer_link . "&profile_tab=editjob&job_id=" . $job_id . $get_uid . "&action=edit";
                                    } else {

                                        $cs_url = $cs_employer_link . "?profile_tab=editjob&job_id=" . $job_id . $get_uid . "&action=edit";
                                    }





                                    // job status link

                                    $current_status = 'active';

                                    $cs_eye_class = 'icon-eye-slash';

                                    $status_toot_tip_text = 'Active';

                                    if ( $cs_job_status == 'active' ) {

                                        $cs_eye_class = 'icon-eye3';

                                        $current_status = 'inactive';

                                        $status_toot_tip_text = 'Inactive';
                                    }

                                    //sataus link allow`

                                    $job_status_link_allow = 1;

                                    if ( $cs_job_status != 'active' && $cs_job_status != 'inactive' ) // check staus diffrent 
                                        $job_status_link_allow = 0;

                                    if ( $cs_job_expired < time() ) // check job expire
                                        $job_status_link_allow = 0;

                                    $cs_apps = 0;

                                    // Getting job application count

                                    $cs_applicants = count_usermeta( 'cs-user-jobs-applied-list', serialize( strval( $job_id ) ), 'LIKE', true );

                                    $cs_apps += count( $cs_applicants );
                                    ?>

                                    <li>

                                        <div class="manag-title">

                                            <h6><a href="<?php echo esc_url( get_permalink( $job_id ) ); ?>"><?php
                                                    if ( $cs_job_featured == 'yes' || $cs_job_featured == 'YES' || $cs_job_featured == 'on' ) {

                                                        echo '<span>featured</span>';
                                                    }
                                                    ?><?php if ( isset( $job_title ) ) echo esc_html( $job_title ); ?></a></h6>

                                            <?php
                                            if ( $cs_job_expired != '' ) {
                                                ?>

                                                <div class="expire-date <?php if ( $cs_job_expired < time() ) echo ' error-msg'; ?>"><?php echo __( 'Expire date:', 'jobhunt' ); ?> <span><?php echo date_i18n( get_option( 'date_format' ), $cs_job_expired ); ?></span></div>

                                                <?php
                                            }
                                            ?>

                                            <div class="last-update"><?php echo __( 'Last Update:', 'jobhunt' ) ?> <span><?php the_modified_date(); ?></span></div>

                                        </div>

                                        <div class="list-holder">

                                            <div class="shortlist">

                                                <a href="<?php echo esc_url( $cs_employer_link ) ?>?job_id=<?php echo esc_html( $job_id ) ?>&profile_tab=applicants&action=applicants" data-toggle="tooltip" data-placement="top" title="<?php echo absint( $cs_apps ) . " " . __( "Application(s)", 'jobhunt' ); ?>" >

                                                    <span><?php echo '<em>' . absint( $cs_apps ) . '</em> ' . __( 'Application(s)', 'jobhunt' ) ?></span>

                                                </a>

                                            </div>

                                            <div id="cs_job_status_html<?php echo esc_html( $job_id ); ?>" class="application"><?php
                                                if ( isset( $cs_job_all_status[$cs_job_status] ) )
                                                    echo esc_html( $cs_job_all_status[$cs_job_status] );
                                                else
                                                    echo __( "Awaiting Activation", "jobhunt" );
                                                ?></div>

                                            <div class="control">

                                                <?php if ( $job_status_link_allow == 1 ) { ?>

                                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo esc_html( $status_toot_tip_text ); ?>" id="cs_job_link<?php echo esc_html( $job_id ); ?>" href="javascript:void(0);" onclick="cs_job_status_update('<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', '<?php echo esc_html( $job_id ); ?>', '<?php echo esc_html( $current_status ); ?>')"><i class="<?php echo sanitize_html_class( $cs_eye_class ) ?>"></i></a>

                                                <?php } else {
                                                    ?><i class="<?php echo sanitize_html_class( $cs_eye_class ) ?>"></i><?php
                                                }
                                                ?>

                                                <a data-toggle="tooltip" data-placement="top" title="<?php echo __( "Edit Job", "jobhunt" ); ?>" href="<?php echo esc_url( $cs_url ) ?>"><i class="icon-edit3"></i></a>

                                                <a data-toggle="tooltip" data-placement="top" title="<?php echo __( "Remove Job", "jobhunt" ); ?>" id="cs-job-<?php echo absint( $job_id ) ?>" onclick="cs_job_delete('<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', '<?php echo absint( $job_id ) ?>')" data-toggle="tooltip" data-original-title="<?php echo esc_html( $status_toot_tip_text ); ?>" ><i class="icon-trash-o"></i></a>
    <a data-toggle="tooltip" data-placement="top" title="<?php echo __( "Veiw Report", "jobhunt" ); ?>" href="<?php echo esc_url( get_permalink( $job_id ) ); ?>"><i class="<?php echo sanitize_html_class( $cs_eye_class ) ?>"></i></a>
                                            </div>

                                        </div>

                                    </li>

                                    <?php
                                endwhile;
                                ?>

                            </ul>



                        </div>

                        <?php
                        //==Pagination Start

                        if ( $count_post > $cs_blog_num_post && $cs_blog_num_post > 0 ) {

                            echo '<nav>';

                            echo cs_ajax_pagination( $count_post, $cs_blog_num_post, 'jobs', 'employer', $uid, '' );

                            echo '</nav>';
                        }//==Pagination End 
                        ?>

                        <?php
                    } else {

                        echo '<div class="cs-no-record">' . cs_info_messages_listing( __( "There is no record in job list", 'jobhunt' ) ) . '</div>';
                    }
                    ?>

                </div>

                <script>

                    jQuery(document).ready(function () {

                        jQuery('[data-toggle="tooltip"]').tooltip();

                    });

                </script>

                <?php
                die();
            }
        }

        /**

         * End Function how to manage job in ajax funciton

         */

        /**

         * Start Function Transaction in Ajax function

         */
        public function cs_ajax_trans_history() {

            global $post, $cs_plugin_options, $gateways;

            $general_settings = new CS_PAYMENTS();

            $currency_sign = isset( $cs_plugin_options['cs_currency_sign'] ) ? $cs_plugin_options['cs_currency_sign'] : '$';

            $cs_emp_dashboard = isset( $cs_plugin_options['cs_emp_dashboard'] ) ? $cs_plugin_options['cs_emp_dashboard'] : '';

            $cs_emp_funs = new cs_employer_functions();

            $uid = (isset( $_POST['cs_uid'] ) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : '';

            if ( $uid != '' ) {

                $args = array(
                    'posts_per_page' => "-1",
                    'post_type' => 'cs-transactions',
                    'post_status' => 'publish',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'cs_transaction_user',
                            'value' => $uid,
                            'compare' => '=',
                        ),
                    ),
                    'orderby' => 'ID',
                    'order' => 'DESC',
                );

                $custom_query = new WP_Query( $args );
                ?>

                <div class="cs-transection">

                    <div class="scetion-title">

                        <h3><?php _e( 'Transactions', 'jobhunt' ) ?></h3>

                    </div>

                    <?php
                    if ( $custom_query->have_posts() ) {

                        $page_link = get_permalink( $cs_emp_dashboard );
                        ?>



                        <div class="dashboard-content-holder">

                            <ul class="transaction-list">

                                <li>

                                    <div class="trans-id"><span><?php _e( 'Package Id', 'jobhunt' ) ?></span></div>

                                    <div class="trans-description"><span><?php _e( 'Title', 'jobhunt' ) ?></span></div>

                                    <div class="trans-date"><span><?php _e( 'Payment Date', 'jobhunt' ) ?></span></div>

                                    <div class="trans-payment"><span><?php _e( 'Payment Type', 'jobhunt' ) ?></span></div>

                                    <div class="trans-amount"><span><?php _e( 'Amount', 'jobhunt' ) ?></span></div>

                                    <div class="trans-status"><span><?php _e( 'Status', 'jobhunt' ) ?></span></div>

                                </li>

                                <?php
                                while ( $custom_query->have_posts() ) : $custom_query->the_post();

                                    $cs_trans_id = get_post_meta( get_the_id(), "cs_transaction_id", true );

                                    $cs_trans_gate = get_post_meta( get_the_id(), "cs_transaction_pay_method", true );

                                    $cs_trans_amount = get_post_meta( get_the_id(), "cs_transaction_amount", true );

                                    $cs_trans_status = get_post_meta( get_the_id(), "cs_transaction_status", true );

                                    $cs_trans_status = $cs_trans_status == '' ? 'pending' : $cs_trans_status;
									
									if ($cs_trans_status == 'pending') {
										$cs_trans_status = __('Pending', 'jobhunt');
									} else if ($cs_trans_status == 'active') {
										$cs_trans_status = __('Active', 'jobhunt');
									} else if ($cs_trans_status == 'approved') {
										$cs_trans_status = __('Approved', 'jobhunt');
									}

                                    $cs_trans_type = get_post_meta( get_the_id(), "cs_transaction_type", true );

                                    if ( $cs_trans_type == 'cv_trans' ) {

                                        $cs_trans_pkg = get_post_meta( get_the_id(), "cs_transaction_cv_pkg", true );

                                        $cs_trans_pkg_title = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg );

                                        if ( $cs_trans_pkg_title != '' ) {

                                            $cs_trans_pkg_title = __( 'CV Search', 'jobhunt' ) . ' - ' . $cs_trans_pkg_title;
                                        }
                                    } else {

                                        $cs_trans_pkg = get_post_meta( get_the_id(), "cs_transaction_package", true );

                                        $cs_trans_pkg_title = $cs_emp_funs->get_pkg_field( $cs_trans_pkg );

                                        if ( $cs_trans_pkg_title != '' ) {

                                            $cs_trans_pkg_title = __( 'Advertise job', 'jobhunt' ) . ' - ' . $cs_trans_pkg_title;
                                        }
                                    }

                                    if ( $cs_trans_pkg_title == '' ) {

                                        if ( $cs_trans_type != 'cv_trans' ) {

                                            $cs_trans_job = get_post_meta( get_the_id(), "cs_job_id", true );

                                            $cs_trans_pkg_title = __( 'Featured Job', 'jobhunt' ) . ' <a href="' . add_query_arg( array( 'profile_tab' => 'editjob', 'job_id' => $cs_trans_job, 'action' => 'edit' ), $page_link ) . '">' . get_the_title( $cs_trans_job ) . '</a>';
                                        } else {

                                            $cs_trans_pkg_title = __( 'Featured Job', 'jobhunt' );
                                        }
                                    }



                                    $cs_trans_gate = isset( $gateways[strtoupper( $cs_trans_gate )] ) ? $gateways[strtoupper( $cs_trans_gate )] : '-';
                                    ?>

                                    <li>

                                        <div class="trans-id"><span>&nbsp;<?php echo esc_attr( $cs_trans_id ) ?></span></div>

                                        <div class="trans-description"><span>&nbsp;<?php echo force_balance_tags( $cs_trans_pkg_title ) ?></span></div>

                                        <div class="trans-date"><span>&nbsp;<?php echo date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) ) ?></span></div>

                                        <div class="trans-payment"><span>&nbsp;<?php echo esc_attr( $cs_trans_gate ) ?></span></div>

                                        <div class="trans-amount"><span class="amount csborder-color">&nbsp;<?php echo esc_attr( $currency_sign ) . CS_FUNCTIONS()->cs_num_format( $cs_trans_amount ) ?></span></div>

                                        <div class="trans-status"><span>&nbsp;<?php echo esc_attr( ucfirst( $cs_trans_status ) ) ?></span></div>

                                    </li>

                                    <?php
                                endwhile;
                                ?>

                            </ul>

                        </div>



                        <?php
                    } else {

                        echo '<div class="cs-no-record">' . cs_info_messages_listing( __( "There is no record in transaction list", 'jobhunt' ) ) . '</div>';
                    }
                    ?></div><?php
                die();
            }
        }

        /**

         * End Function Transaction in Ajax function

         */

        /**

         * Start Function Create Resumes  in Ajax function

         */
        public function cs_ajax_fav_resumes() {

            global $post, $current_user, $cs_plugin_options, $cs_form_fields2;

            $default_currency_sign = isset( $cs_plugin_options['cs_currency_sign'] ) ? $cs_plugin_options['cs_currency_sign'] : '';
            $cs_candidate_switch = isset( $cs_plugin_options['cs_candidate_switch'] ) ? $cs_plugin_options['cs_candidate_switch'] : '';
            $cs_emp_funs = new cs_employer_functions();

            $uid = (isset( $_POST['cs_uid'] ) and $_POST['cs_uid'] <> '') ? $_POST['cs_uid'] : '';

            if ( $uid != '' ) {

                if ( $cs_candidate_switch == 'on' ) {    // paid list
                    echo '
                    <div class="cs-dash-resumes-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#shortlisted-resumes-list">Shortlisted</a></li>
                        <li><a data-toggle="tab" href="#download-resumes-list">Downloads</a></li>
                    </ul>
                    <div class="tab-content">
                    <div id="shortlisted-resumes-list" class="tab-pane fade in active">';
                    $cs_fav_resumes = get_user_meta( $uid, 'cs-user-resumes-wishlist', true );
                    if ( ! empty( $cs_fav_resumes ) && is_array( $cs_fav_resumes ) ) {
                        $cs_fav_shortlist = array_column_by_two_dimensional( $cs_fav_resumes, 'post_id' );
                    } else {
                        $cs_fav_shortlist = array();
                    }
                    $heading = __( 'Shortlisted', 'jobhunt' );
                    $this->cs_fav_resumes_list( $cs_fav_shortlist, $uid, $heading, false );
                    echo '
                    </div>
                    <div id="download-resumes-list" class="tab-pane fade">';
                    $cs_fav_resumes = get_user_meta( $uid, "cs_fav_resumes", true );
                    $heading = __( 'Resumes', 'jobhunt' );
                    $this->cs_fav_resumes_list( $cs_fav_resumes, $uid, $heading );
                    echo '
                    </div>
                    </div>
                    </div>';
                } else { // free wishlist
                    $cs_fav_resumes = get_user_meta( $uid, 'cs-user-resumes-wishlist', true );
                    if ( ! empty( $cs_fav_resumes ) ) {
                        $cs_fav_shortlist = array_column_by_two_dimensional( $cs_fav_resumes, 'post_id' );
                    } else {
                        $cs_fav_shortlist = array();
                    }
                    $heading = __( 'Shortlisted', 'jobhunt' );
                    $this->cs_fav_resumes_list( $cs_fav_shortlist, $uid, $heading );
                }
                ?>
                <script>
                    jQuery(document).ready(function () {
                        jQuery('[data-toggle="tooltip"]').tooltip();
                    });
                </script>
                <?php
                die();
            }
        }

        /**

         * End Function Create Resumes  in Ajax function

         */
        public function cs_fav_resumes_list( $cs_fav_resumes = '', $uid = '', $heading = '', $actions_drp = true ) {

            global $post, $current_user, $cs_plugin_options, $cs_form_fields2;

            $default_currency_sign = isset( $cs_plugin_options['cs_currency_sign'] ) ? $cs_plugin_options['cs_currency_sign'] : '';
            $cs_candidate_switch = isset( $cs_plugin_options['cs_candidate_switch'] ) ? $cs_plugin_options['cs_candidate_switch'] : '';
            $cs_emp_funs = new cs_employer_functions();

            $cs_vat_switch = isset( $cs_plugin_options['cs_vat_switch'] ) ? $cs_plugin_options['cs_vat_switch'] : '';
            $cs_pay_vat = isset( $cs_plugin_options['cs_payment_vat'] ) ? $cs_plugin_options['cs_payment_vat'] : '0';
            $currency_sign = isset( $cs_plugin_options['cs_currency_sign'] ) ? $cs_plugin_options['cs_currency_sign'] : '$';
            ?>
            <div class="cs-resumes" data-adminurl="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
                <div class="scetion-title">
                    <h3><?php _e( $heading, 'jobhunt' ) ?></h3>
                </div>
                <?php
                if ( is_array( $cs_fav_resumes ) && sizeof( $cs_fav_resumes ) > 0 && isset( $cs_fav_resumes ) && ( ! empty( $cs_fav_resumes )) ) {
                    $cs_blog_num_post = 10;
                    if ( empty( $_REQUEST['page_id_all'] ) ) {
                        $_REQUEST['page_id_all'] = 1;
                    }
                    $mypost = array( 'number' => "999999", 'include' => $cs_fav_resumes, 'role' => 'cs_candidate', 'order' => "ASC" );
                    $loop_count = new WP_User_Query( $mypost );
                    $count_post = $loop_count->total_users;
                    $args = array( 'number' => $cs_blog_num_post, 'include' => $cs_fav_resumes, 'role' => 'cs_candidate', 'order' => "ASC" );
                    $custom_query = new WP_User_Query( $args );

                    if ( $custom_query->results ):
                        ?>
                        <ul class="resumes-list">
                            <?php
                            foreach ( $custom_query->results as $cs_user ) {
                                $cs_fav = $cs_user->ID;
                                // check candidate exist or not

                                $cs_user_img = get_user_meta( $cs_fav, "user_img", true );
                                $cs_user_img = cs_get_img_url( $cs_user_img, 'cs_media_5' );
                                if ( ! cs_image_exist( $cs_user_img ) || $cs_user_img == "" ) {
                                    $cs_user_img = esc_url( wp_jobhunt::plugin_url() . 'assets/images/img-not-found16x9.jpg' );
                                }
                                $cs_job_title = get_user_meta( $cs_fav, "cs_job_title", true );
                                $cs_loc_address = get_user_meta( $cs_fav, "cs_post_loc_address", true );
                                $cs_candidate_cv = get_user_meta( $cs_fav, "cs_candidate_cv", true );
                                $cs_candidate_linkedin = get_user_meta( $cs_fav, 'cs_linkedin', true );
                                $cs_post_loc_city = get_user_meta( $cs_fav, 'cs_post_loc_city', true );
                                $cs_candidate_web_http = $cs_user->user_url;
                                $cs_candidate_web = preg_replace( '#^https?://#', '', $cs_candidate_web_http );
                                $cs_minimum_salary = get_user_meta( $cs_fav, 'cs_minimum_salary', true );
                                $cs_user_last_activity_date = get_user_meta( $cs_fav, 'cs_user_last_activity_date', true );
                                $cs_candidate_user = $cs_fav;
                                $cs_get_exp_list = get_user_meta( $cs_fav, 'cs_exp_list_array', true );
                                $cs_exp_titles = get_user_meta( $cs_fav, 'cs_exp_title_array', true );
                                $cs_exp_from_dates = get_user_meta( $cs_fav, 'cs_exp_from_date_array', true );
                                $cs_exp_to_dates = get_user_meta( $cs_fav, 'cs_exp_to_date_array', true );
                                $cs_exp_companys = get_user_meta( $cs_fav, 'cs_exp_company_array', true );

                                // get all job types
                                $all_specialisms = get_user_meta( $cs_fav, 'cs_specialisms', true );
                                $specialisms_values = '';
                                $specialisms_class = '';
                                $specialism_flag = 1;
                                if ( $all_specialisms != '' ) {
                                    foreach ( $all_specialisms as $specialisms_item ) {
                                        $specialismsitem = get_term_by( 'slug', $specialisms_item, 'specialisms' );
                                        if ( is_object( $specialismsitem ) ) {
                                            $specialisms_values .= $specialismsitem->name;
                                            $specialisms_class .= $specialismsitem->slug;
                                            if ( $specialism_flag != count( $all_specialisms ) ) {
                                                $specialisms_values .= ", ";
                                                $specialisms_class .= " ";
                                            }
                                            $specialism_flag ++;
                                        }
                                    }
                                }

                                $recent_exp_company = '';
                                $recent_exp_titles = '';
                                $recent_exp_company = '';
                                $recent_exp_titles = '';

                                if ( isset( $cs_get_exp_list ) && is_array( $cs_get_exp_list ) && count( $cs_get_exp_list ) > 0 ) {
                                    $required_index = find_heighest_date_index( $cs_exp_to_dates, 'd-m-Y' );
                                    $recent_exp_company = $cs_exp_companys[$required_index];
                                    $recent_exp_titles = $cs_exp_titles[$required_index];
                                }

                                $last_login_timestring = get_user_last_login( $cs_candidate_user );
                                $user_registered_timestamp = isset( $cs_candidate_user ) && $cs_candidate_user != '' ? get_user_registered_timestamp( $cs_candidate_user ) : '';
                                ?>
                                <li>
                                    <img alt="" src="<?php echo esc_url( $cs_user_img ) ?>">
                                    <div class="cs-text">
                                        <?php
                                        if ( $specialisms_values != '' ) {
                                            echo '<span class="time">' . $specialisms_values . '</span>';
                                        }
                                        ?>
                                        <h5><a><?php echo $cs_user->display_name ?></a><?php
                                            if ( $cs_post_loc_city != '' ) {

                                                echo " | " . urldecode( $cs_post_loc_city );
                                            }

                                            if ( $cs_minimum_salary != '' ) {

                                                echo '<span>' . $default_currency_sign . $cs_minimum_salary . __( ' p.a minimum', 'jobhunt' ) . '</span>';
                                            }
                                            ?></h5>

                                        <?php
                                        if ( $recent_exp_titles != '' ) {

                                            echo '<span><em>' . $recent_exp_titles . '</em> ' . __( 'at', 'jobhunt' ) . ' ' . $recent_exp_company . '</span>';
                                        }
                                        ?>

                                        <div class="cs-uploaded candidate-detail">
                                            <span>
                                                <?php if ( $cs_user_last_activity_date != '' ) { ?>
                                                    <em><?php _e( 'Last activity', 'jobhunt' ) ?></em> <?php echo cs_time_elapsed_string( $cs_user_last_activity_date ); ?>. 
                                                    <?php
                                                }
                                                if ( $user_registered_timestamp != '' ) {
                                                    ?>
                                                    <em><?php echo __( "Registered", "jobhunt" ); ?></em> <?php echo cs_time_elapsed_string( $user_registered_timestamp ); ?>
                                                <?php } ?>
                                            </span>
                                        </div>
                                    </div>

                                    <?php
                                    if ( $actions_drp == true ) {
                                        ?>
                                        <div class="cs-downlod-sec">
                                            <a><?php _e( 'Actions', 'jobhunt' ) ?></a>
                                            <ul>
                                                <li>
                                                    <a data-toggle="modal" data-target="#cover_letter_light<?php echo absint( $cs_fav ) ?>"><?php _e( 'Cover Letter', 'jobhunt' ) ?></a>
                                                </li>
                                                <?php if ( isset( $cs_candidate_cv ) && ($cs_candidate_cv) != '' ) { ?>
                                                    <li><a target="_blank" href="<?php echo esc_url( $cs_candidate_cv ) ?>"><?php _e( 'Download CV', 'jobhunt' ) ?></a></li>
                                                <?php } else { ?>
                                                    <li><a href="javascript:void(0);" onclick="show_alert_msg('<?php echo __( 'There is no downloadable doc', 'jobhunt' ) ?>');"><?php _e( 'Download CV', 'jobhunt' ) ?></a></li>
                                                <?php } if ( $cs_candidate_linkedin != '' ) { ?>
                                                    <li><a target="_blank" href="<?php echo esc_url( $cs_candidate_linkedin ) ?>"><?php _e( 'Linked-in Profile', 'jobhunt' ) ?></a></li>
                                                <?php } ?>
                                                <li>
                                                    <a data-toggle="modal" data-target="#cs-msgbox-<?php echo absint( $cs_fav ) ?>"><?php _e( 'Send a Message ', 'jobhunt' ) ?></a>
                                                </li> 
                                                <li><a href="<?php echo esc_url( get_author_posts_url( $cs_fav ) ) ?>"><?php _e( 'View Profile', 'jobhunt' ) ?></a></li>
                                            </ul>
                                        </div>
                                        <div class="modal fade" id="cover_letter_light<?php echo absint( $cs_fav ) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h5>
                                                            <a><?php echo $cs_user->display_name ?></a>
                                                            <?php
                                                            if ( isset( $cs_post_loc_city ) && $cs_post_loc_city != '' ) {
                                                                echo " | " . $cs_post_loc_city;
                                                            }
                                                            echo " - " . __( "Cover Letter", "jobhunt" );
                                                            ?>
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        if ( isset( $cs_fav ) && $cs_fav != '' ) {

                                                            $cs_cover_letter = get_user_meta( $cs_fav, 'cs_cover_letter', true );

                                                            if ( isset( $cs_cover_letter ) && $cs_cover_letter != '' ) {
                                                                echo force_balance_tags( $cs_cover_letter );
                                                            } else {
                                                                echo __( "Not set by user", "jobhunt" );
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        $cs_paid_resumes = get_user_meta( $uid, "cs_fav_resumes", true );
                                        echo '<span class="cs-resume-add-btn">';
                                        if ( is_array( $cs_paid_resumes ) && in_array( $cs_fav, $cs_paid_resumes ) ) {
                                            ?>
                                            <a href="<?php echo esc_url( get_author_posts_url( $cs_fav ) ) ?>" class="add_list_icon ad_to_list cs_resume_added cs-button"><?php _e( 'View Detail', 'jobhunt' ) ?></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a data-toggle="tooltip" data-placement="top" title="<?php _e( "Add to List", "jobhunt" ); ?>" class="add_list_icon ad_to_list cs-button" id="add-to-btn-<?php echo absint( $cs_fav ) ?>" onclick="cs_add_to_list('<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', '<?php echo absint( $cs_fav ) ?>')"><?php _e( 'Add to List', 'jobhunt' ) ?></a>
                                            <?php
                                        }
                                        echo '</span>';
                                    }
                                    ?>
                                    <a data-toggle="tooltip" data-placement="top" title="<?php _e( "Remove", "jobhunt" ); ?>" class="delete" id="cs-resume-<?php echo absint( $cs_fav ) ?>" onclick="cs_fav_resume_del('<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', '<?php echo absint( $cs_fav ) ?>')"><i class="icon-trash-o"></i></a>
                                    <?php
                                    if ( $actions_drp == true ) {
                                        ?>
                                        <div id="cs-msgbox-fade<?php echo esc_html( $cs_fav ); ?>" class="black_overlay"></div>
                                        <div class="modal fade" id="cs-msgbox-<?php echo absint( $cs_fav ) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <?php
                                                        $contact_heading = '<h4>' . __( 'Send message to Candidate', 'jobhunt' ) . '</h4>';
                                                        if ( get_the_title( $cs_fav ) != "" ) {
                                                            $contact_heading = '<h4>' . sprintf( __( 'Send message to "%s"', 'jobhunt' ), get_the_title( $cs_fav ) ) . '"</h4>';
                                                        }
                                                        echo $contact_heading;
                                                        ?> 
                                                    </div>

                                                    <div class="modal-body">
                                                        <div id="cs_employer_id_<?php echo absint( $cs_fav ) ?>" data-validationmsg="<?php _e( "Please ensure that all required fields are completed and formatted correctly", "jobhunt" ); ?>">
                                                            <div id="ajaxcontact-response-<?php echo absint( $cs_fav ) ?>" class="error-msg"></div>
                                                            <div class="cs-profile-contact-detail">
                                                                <form id="ajaxcontactform-<?php echo absint( $cs_fav ) ?>"  method="post" enctype="multipart/form-data">
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-user9"></i>
                                                                        <?php
                                                                        $cs_employer_info = get_userdata( $uid );
                                                                        $ajaxcontactname = $cs_employer_info->display_name;
                                                                        $ajaxcontactemail = $cs_employer_info->user_email;

                                                                        $ajaxcontactname = isset( $ajaxcontactname ) ? $ajaxcontactname : '';

                                                                        $ajaxcontactemail = isset( $ajaxcontactemail ) ? $ajaxcontactemail : '';

                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactname',
                                                                            'std' => $ajaxcontactname,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );

                                                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                                                        ?>
                                                                    </div>
                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-envelope4"></i>
                                                                        <?php
                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactemail',
                                                                            'std' => $ajaxcontactemail,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );

                                                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                                                        ?>
                                                                    </div>

                                                                    <div class="input-filed-contact">
                                                                        <i class="icon-mobile4"></i>
                                                                        <?php
                                                                        $ajaxcontactphonenumber = get_user_meta( $uid, 'cs_phone_number', true );

                                                                        $ajaxcontactphone = isset( $ajaxcontactphonenumber ) ? $ajaxcontactphonenumber : '';

                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactphone',
                                                                            'std' => $ajaxcontactphone,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );

                                                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                                                        ?>
                                                                    </div>

                                                                    <div class="input-filed-contact">
                                                                        <?php
                                                                        $ajaxcontactcontents = isset( $ajaxcontactcontents ) ? $ajaxcontactcontents : '';

                                                                        $cs_opt_array = array(
                                                                            'id' => 'ajaxcontactcontents',
                                                                            'std' => $ajaxcontactcontents,
                                                                            'desc' => '',
                                                                            'classes' => 'form-control',
                                                                            'hint_text' => '',
                                                                        );

                                                                        $cs_form_fields2->cs_form_textarea_render( $cs_opt_array );
                                                                        ?>
                                                                    </div>

                                                                    <div id="jb-id-<?php echo absint( $cs_fav ) ?>" data-jid="<?php echo absint( $cs_fav ) ?>">
                                                                        <?php
                                                                        $cs_opt_array = array(
                                                                            'id' => '',
                                                                            'std' => __( 'Send Request', 'jobhunt' ),
                                                                            'cust_type' => 'button',
                                                                            'cust_id' => 'jb-cont-send-' . $cs_fav,
                                                                            'cust_name' => 'candidate_contactus',
                                                                            'extra_atr' => 'data-id="' . $cs_fav . '"',
                                                                            'classes' => 'cs-bgcolor acc-submit',
                                                                            'hint_text' => '',
                                                                        );

                                                                        $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                                                                        ?>

                                                                        <div id="main-cs-loader_<?php echo absint( $cs_fav ) ?>" class="loader_class"></div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!--Content div--->
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>

                        </ul>

                        <?php
                    endif;

                    //==Pagination Start

                    if ( $count_post > $cs_blog_num_post && $cs_blog_num_post > 0 ) {

                        echo '<nav>';

                        echo cs_ajax_pagination( $count_post, $cs_blog_num_post, 'resumes', 'employer', $uid, '' );

                        echo '</nav>';
                    }//==Pagination End 
                } else {

                    echo '<div class="cs-no-record">' . cs_info_messages_listing( __( "There is no record in resumes list", 'jobhunt' ) ) . '</div>';
                }
                ?>

            </div>
            <?php
        }

        /**

         * Start Function Createing job Packages in Ajax Function

         */
        public function cs_ajax_job_packages() {



            global $cs_plugin_options, $current_user, $cs_form_fields2;

            $general_settings = new CS_PAYMENTS();



            if ( isset( $_POST['pkg_array'] ) ) {

                $post_array = stripslashes( $_POST['pkg_array'] );

                $post_array = json_decode( $post_array, true );

                if ( is_array( $post_array ) && sizeof( $post_array ) > 0 ) {

                    if ( isset( $post_array['post_array'] ) ) {

                        $post_array = $post_array['post_array'];

                        $_POST = array_merge( $_POST, $post_array );
                    }
                }
            }



            $cs_emp_funs = new cs_employer_functions();

            $cs_vat_switch = isset( $cs_plugin_options['cs_vat_switch'] ) ? $cs_plugin_options['cs_vat_switch'] : '';

            $cs_pay_vat = isset( $cs_plugin_options['cs_payment_vat'] ) ? $cs_plugin_options['cs_payment_vat'] : '0';

            $currency_sign = isset( $cs_plugin_options['cs_currency_sign'] ) ? $cs_plugin_options['cs_currency_sign'] : '$';

            $cs_feature_amount = isset( $cs_plugin_options['cs_job_feat_price'] ) ? $cs_plugin_options['cs_job_feat_price'] : '';

            $cs_packages_options = isset( $cs_plugin_options['cs_packages_options'] ) ? $cs_plugin_options['cs_packages_options'] : '';

            $cs_cv_pkgs_options = isset( $cs_plugin_options['cs_cv_pkgs_options'] ) ? $cs_plugin_options['cs_cv_pkgs_options'] : '';



            if ( isset( $_POST['cs_package'] ) && $_POST['cs_package'] != '' ) {

                if ( ! $cs_emp_funs->cs_is_pkg_subscribed( $_POST['cs_package'] ) ) {

                    $cs_package = $_POST['cs_package'];

                    $cs_html = '';

                    $cs_total_amount = 0;

                    $cs_total_amount += CS_FUNCTIONS()->cs_num_format( $cs_emp_funs->get_pkg_field( $_POST['cs_package'], 'package_price' ) );

                    $cs_smry_totl = $cs_total_amount;

                    if ( $cs_vat_switch == 'on' && $cs_pay_vat > 0 ) {

                        $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );

                        $cs_total_amount = CS_FUNCTIONS()->cs_num_format( $cs_vat_amount ) + $cs_total_amount;
                    }



                    if ( $cs_total_amount <= 0 ) {

                        // Adding Free Package

                        $cs_trans_pkg = isset( $_POST['cs_package'] ) ? $_POST['cs_package'] : '';

                        $cs_pkg_title = $cs_emp_funs->get_pkg_field( $cs_trans_pkg );

                        $cs_pkg_expiry = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_duration' );

                        $cs_pkg_duration = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_duration_period' );

                        $cs_pkg_expir_days = strtotime( $cs_emp_funs->cs_date_conv( $cs_pkg_expiry, $cs_pkg_duration ) );

                        $cs_pkg_list_num = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_listings' );

                        $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_submission_limit' );

                        $cs_pkg_list_per = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'cs_list_dur' );

                        $cs_trans_fields = array(
                            'cs_job_id' => isset( $_POST['cs_package'] ) ? $_POST['cs_package'] : '',
                            'cs_trans_id' => rand( 149344111, 991435901 ),
                            'cs_trans_user' => $current_user->ID,
                            'cs_package_title' => $cs_pkg_title,
                            'cs_trans_package' => isset( $_POST['cs_package'] ) ? $_POST['cs_package'] : '',
                            'cs_trans_amount' => 0,
                            'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                            'cs_trans_list_num' => $cs_pkg_list_num,
                            'cs_trans_list_expiry' => $cs_pkg_list_exp,
                            'cs_trans_list_period' => $cs_pkg_list_per,
                        );

                        $cs_emp_funs->cs_pay_process( $cs_trans_fields );

                        $cs_html .= __( 'You have successfully subscribed free package.', 'jobhunt' );

                        //echo CS_FUNCTIONS()->cs_special_chars($cs_html);
                    }



                    if ( isset( $_POST['cs_pkge_trans'] ) && $_POST['cs_pkge_trans'] == "1" ) {

                        if ( $cs_total_amount > 0 ) {

                            $cs_trans_pkg = isset( $_POST['cs_package'] ) ? $_POST['cs_package'] : '';

                            $cs_pkg_title = $cs_emp_funs->get_pkg_field( $cs_trans_pkg );

                            $cs_pkg_expiry = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_duration' );

                            $cs_pkg_duration = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_duration_period' );

                            $cs_pkg_expir_days = strtotime( $cs_emp_funs->cs_date_conv( $cs_pkg_expiry, $cs_pkg_duration ) );

                            $cs_pkg_list_num = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_listings' );

                            $cs_pkg_list_exp = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'package_submission_limit' );

                            $cs_pkg_list_per = $cs_emp_funs->get_pkg_field( $cs_trans_pkg, 'cs_list_dur' );

                            $cs_trans_fields = array(
                                'cs_job_id' => isset( $_POST['cs_package'] ) ? $_POST['cs_package'] : '',
                                'cs_trans_id' => rand( 149344111, 991435901 ),
                                'cs_trans_user' => $current_user->ID,
                                'cs_package_title' => $cs_pkg_title,
                                'cs_trans_package' => isset( $_POST['cs_package'] ) ? $_POST['cs_package'] : '',
                                'cs_trans_amount' => $cs_total_amount,
                                'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                'cs_trans_list_num' => $cs_pkg_list_num,
                                'cs_trans_list_expiry' => $cs_pkg_list_exp,
                                'cs_trans_list_period' => $cs_pkg_list_per,
                            );

                            $cs_trnas_html = $cs_emp_funs->cs_pay_process( $cs_trans_fields );
                        }
                    }

                    if ( isset( $cs_trnas_html ) && $cs_trnas_html != '' ) {

                        $cs_html .= $cs_trnas_html;
                    } else {

                        if ( $cs_total_amount > 0 ) {

                            $cs_html .= '

                        <form method="post" id="cs-emp-pkgs" data-ajaxurl="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '">

                                <div class="cs-order-summery">

                                        <h4>' . __( 'Order summery', 'jobhunt' ) . '</h4>

                                        <ul class="cs-sumry-clacs">

                                                        <li><span>' . esc_attr( $cs_emp_funs->get_pkg_field( $_POST['cs_package'] ) ) . ' ' . __( 'Subscription', 'jobhunt' ) . '</span><em>' . esc_attr( $currency_sign ) . CS_FUNCTIONS()->cs_num_format( $cs_emp_funs->get_pkg_field( $_POST['cs_package'], 'package_price' ) ) . '</em></li>';

                            if ( $cs_vat_switch == 'on' && isset( $cs_vat_amount ) ) {

                                $cs_html .= '<li><span>' . sprintf( __( 'VAT (%s&#37;)', 'jobhunt' ), $cs_pay_vat ) . '</span><em>' . esc_attr( $currency_sign ) . CS_FUNCTIONS()->cs_num_format( $cs_vat_amount ) . '</em></li>';
                            }



                            $cs_html .= '

                            <li><span>' . __( 'Total', 'jobhunt' ) . '</span><em>' . esc_attr( $currency_sign ) . CS_FUNCTIONS()->cs_num_format( $cs_total_amount ) . '</em></li>

                            </ul>

                            </div>



                            <div class="contact-box cs-pay-box">
							
                            <ul class="select-card cs-all-gates">';

                            global $gateways;
                            $cs_gateway_options = get_option( 'cs_plugin_options' );
                            $cs_gw_counter = 1;
                            $cs_gatway_enable_flag = 0;

                            if ( isset( $cs_gateway_options['cs_use_woocommerce_gateway'] ) && $cs_gateway_options['cs_use_woocommerce_gateway'] == 'on' ) {
                                $cs_opt_array = array(
                                    'std' => 'cs_wooC_GATEWAY',
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'cs_payment_gateway',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );

                                $cs_opt_array = array(
                                    'std' => $_POST['wooC_current_page'],
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'wooC_current_page',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );

                                $cs_gatway_enable_flag ++;
                            } else {
                                if ( isset( $gateways ) && is_array( $gateways ) ) {

                                    foreach ( $gateways as $key => $value ) {

                                        $status = $cs_gateway_options[strtolower( $key ) . '_status'];

                                        if ( isset( $status ) && $status == 'on' ) {

                                            $logo = '';

                                            if ( isset( $cs_gateway_options[strtolower( $key ) . '_logo'] ) ) {

                                                $logo = $cs_gateway_options[strtolower( $key ) . '_logo'];
                                            }

                                            if ( isset( $logo ) && $logo != '' ) {

                                                $cs_checked = $cs_gw_counter == 1 ? ' checked="checked"' : '';

                                                $cs_active = $cs_gw_counter == 1 ? ' class="active"' : '';

                                                $cs_html .= '

														<li' . $cs_active . '>

															<a><img alt="" src="' . esc_url( $logo ) . '"></a>';



                                                $cs_opt_array = array(
                                                    'std' => $key,
                                                    'id' => '',
                                                    'cust_type' => 'radio',
                                                    'extra_atr' => ' style="display:none; position:absolute;" ' . CS_FUNCTIONS()->cs_special_chars( $cs_checked ),
                                                    'return' => true,
                                                    'cust_name' => 'cs_payment_gateway',
                                                );

                                                $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );

                                                $cs_html .= ' </li>';

                                                $cs_gatway_enable_flag ++;   // if any gatway enable then set flag
                                            }

                                            $cs_gw_counter ++;
                                        }
                                    }
                                }
                            }
                            $cs_html .= '</ul>';

                            if ( $cs_gatway_enable_flag > 0 ) {

                                $cs_opt_array = array(
                                    'std' => absint( $cs_package ),
                                    'id' => '',
                                    'cust_name' => 'cs_package',
                                    'return' => true,
                                );

                                $cs_html .= $cs_form_fields2->cs_form_hidden_render( $cs_opt_array );



                                $cs_opt_array = array(
                                    'std' => '1',
                                    'id' => '',
                                    'cust_name' => 'cs_pkge_trans',
                                    'return' => true,
                                );



                                $cs_html .= $cs_form_fields2->cs_form_hidden_render( $cs_opt_array );



                                $cs_opt_array = array(
                                    'std' => __( 'Pay Now', 'jobhunt' ),
                                    'id' => '',
                                    'cust_type' => 'submit',
                                    'classes' => 'continue-btn',
                                    'return' => true,
                                );



                                $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );
                            }

                            $cs_html .= '</div> </form>';
                        }
                    }

                    echo CS_FUNCTIONS()->cs_special_chars( $cs_html );
                } else {

                    echo '<div class="cs-no-record">' . cs_info_messages_listing( __( "You have already subscribe this Package", 'jobhunt' ) ) . '</div>';
                }
            }

            if ( isset( $_POST['cs_packge'] ) && $_POST['cs_packge'] != '' ) {



                if ( ! $cs_emp_funs->is_cv_pkg_subs() ) {

                    $cs_packge = $_POST['cs_packge'];

                    $cv_pkg_price = CS_FUNCTIONS()->cs_num_format( $cs_emp_funs->get_cv_pkg_field( $_POST['cs_packge'], 'cv_pkg_price' ) );

                    $cs_html = '';



                    if ( $cv_pkg_price > 0 ) {

                        $cs_total_amount = 0;

                        $cs_total_amount += CS_FUNCTIONS()->cs_num_format( $cs_emp_funs->get_cv_pkg_field( $_POST['cs_packge'], 'cv_pkg_price' ) );

                        $cs_smry_totl = $cs_total_amount;

                        if ( $cs_vat_switch == 'on' && $cs_pay_vat > 0 ) {

                            $cs_vat_amount = $cs_total_amount * ( $cs_pay_vat / 100 );

                            $cs_total_amount = CS_FUNCTIONS()->cs_num_format( $cs_vat_amount ) + $cs_total_amount;
                        }

                        if ( isset( $_POST['cs_pkg_trans'] ) && $_POST['cs_pkg_trans'] == 1 && $cs_total_amount > 0 ) {



                            $cs_trans_pkg = isset( $_POST['cs_packge'] ) ? $_POST['cs_packge'] : '';

                            $cs_pkg_title = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg );

                            $cs_pkg_expiry = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg, 'cv_pkg_dur' );

                            $cs_pkg_duration = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg, 'cv_pkg_dur_period' );

                            $cs_pkg_expir_days = strtotime( $cs_emp_funs->cs_date_conv( $cs_pkg_expiry, $cs_pkg_duration ) );

                            $cs_pkg_cv_num = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg, 'cv_pkg_cvs' );

                            $cs_trans_fields = array(
                                'cs_job_id' => isset( $_POST['cs_packge'] ) ? $_POST['cs_packge'] : '',
                                'cs_trans_id' => rand( 149344111, 991435901 ),
                                'cs_trans_user' => $current_user->ID,
                                'cs_package_title' => $cs_pkg_title,
                                'cs_trans_package' => isset( $_POST['cs_packge'] ) ? $_POST['cs_packge'] : '',
                                'cs_trans_amount' => $cs_total_amount,
                                'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                                'cs_trans_cv_num' => $cs_pkg_cv_num,
                            );

                            $cs_trnas_html = $cs_emp_funs->cs_cv_pay_process( $cs_trans_fields );
                        }

                        if ( isset( $cs_trnas_html ) && $cs_trnas_html != '' ) {

                            $cs_html .= $cs_trnas_html;
                        } else {

                            $cs_html .= '

                                        <form method="post" id="cs-emp-resumes" data-ajaxurl="' . esc_url( admin_url( 'admin-ajax.php' ) ) . '">

                                            <div class="cs-order-summery">

                                                <h4>' . __( 'Order Summary', 'jobhunt' ) . '</h4>

                                                <ul class="cs-sumry-clacs">

                                                    <li><span>' . esc_attr( $cs_emp_funs->get_cv_pkg_field( $_POST['cs_packge'] ) ) . ' ' . __( 'Subscription', 'jobhunt' ) . '</span><em>' . esc_attr( $currency_sign ) . CS_FUNCTIONS()->cs_num_format( $cs_emp_funs->get_cv_pkg_field( $_POST['cs_packge'], 'cv_pkg_price' ) ) . '</em></li>';

                            if ( $cs_vat_switch == 'on' && isset( $cs_vat_amount ) ) {



                                $cs_html .= '<li><span>' . sprintf( __( 'VAT (%s&#37;)', 'jobhunt' ), $cs_pay_vat ) . '</span><em>' . esc_attr( $currency_sign ) . CS_FUNCTIONS()->cs_num_format( $cs_vat_amount ) . '</em></li>';
                            }



                            $cs_html .= '

                                        <li><span>' . __( 'Total', 'jobhunt' ) . '</span><em>' . esc_attr( $currency_sign ) . CS_FUNCTIONS()->cs_num_format( $cs_total_amount ) . '</em></li>

                                            </ul>

                                        </div>

                                        <div class="contact-box cs-pay-box">

                                         <ul class="select-card cs-all-gates">';

                            global $gateways;

                            $cs_gateway_options = get_option( 'cs_plugin_options' );

                            $cs_gw_counter = 1;

                            if ( isset( $cs_gateway_options['cs_use_woocommerce_gateway'] ) && $cs_gateway_options['cs_use_woocommerce_gateway'] == 'on' ) {
                                $cs_opt_array = array(
                                    'std' => 'cs_wooC_GATEWAY',
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'cs_payment_gateway',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );

                                $cs_opt_array = array(
                                    'std' => $_POST['wooC_current_page'],
                                    'id' => '',
                                    'return' => true,
                                    'cust_type' => 'hidden',
                                    'extra_atr' => '',
                                    'cust_name' => 'wooC_current_page',
                                    'prefix' => '',
                                );
                                $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );

                                $cs_gatway_enable_flag ++;
                            } else {

                                foreach ( $gateways as $key => $value ) {

                                    $status = $cs_gateway_options[strtolower( $key ) . '_status'];

                                    if ( isset( $status ) && $status == 'on' ) {

                                        $logo = '';

                                        if ( isset( $cs_gateway_options[strtolower( $key ) . '_logo'] ) ) {

                                            $logo = $cs_gateway_options[strtolower( $key ) . '_logo'];
                                        }

                                        if ( isset( $logo ) && $logo != '' ) {

                                            $cs_checked = $cs_gw_counter == 1 ? ' checked="checked"' : '';

                                            $cs_active = $cs_gw_counter == 1 ? ' class="active"' : '';

                                            $cs_html .= ' <li' . $cs_active . '><a><img alt="" src="' . esc_url( $logo ) . '"></a>';



                                            $cs_opt_array = array(
                                                'std' => $key,
                                                'id' => '',
                                                'cust_type' => 'radio',
                                                'extra_atr' => 'style="display:none; position:absolute;" ' . CS_FUNCTIONS()->cs_special_chars( $cs_checked ),
                                                'return' => true,
                                                'cust_name' => 'cs_payment_gateway',
                                            );

                                            $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );

                                            $cs_html .= '</li>';
                                        }

                                        $cs_gw_counter ++;
                                    }
                                }
                            }

                            $cs_html .= ' </ul>';

                            $cs_opt_array = array(
                                'std' => $cs_packge,
                                'id' => '',
                                'cust_name' => 'cs_packge',
                                'return' => true,
                            );



                            $cs_html .= $cs_form_fields2->cs_form_hidden_render( $cs_opt_array );

                            $cs_html .= '<input type="hidden" name="cs_pkg_trans" value="1">';

                            $cs_opt_array = array(
                                'std' => __( 'Pay Now', 'jobhunt' ),
                                'id' => '',
                                'return' => true,
                                'classes' => 'continue-btn',
                                'cust_type' => 'submit',
                            );

                            $cs_html .= $cs_form_fields2->cs_form_text_render( $cs_opt_array );

                            $cs_html .= '</div> </form>';
                        }
                    } else {

                        // Adding Free Package

                        $cs_trans_pkg = isset( $_POST['cs_packge'] ) ? $_POST['cs_packge'] : '';

                        $cs_pkg_title = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg );

                        $cs_pkg_expiry = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg, 'cv_pkg_dur' );

                        $cs_pkg_duration = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg, 'cv_pkg_dur_period' );

                        $cs_pkg_expir_days = strtotime( $cs_emp_funs->cs_date_conv( $cs_pkg_expiry, $cs_pkg_duration ) );

                        $cs_pkg_cv_num = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg, 'cv_pkg_cvs' );

                        $cs_trans_fields = array(
                            'cs_job_id' => isset( $_POST['cs_packge'] ) ? $_POST['cs_packge'] : '',
                            'cs_trans_id' => rand( 149344111, 991435901 ),
                            'cs_trans_user' => $current_user->ID,
                            'cs_package_title' => $cs_pkg_title,
                            'cs_trans_package' => isset( $_POST['cs_packge'] ) ? $_POST['cs_packge'] : '',
                            'cs_trans_amount' => '0',
                            'cs_trans_pkg_expiry' => $cs_pkg_expir_days,
                            'cs_trans_cv_num' => $cs_pkg_cv_num,
                        );

                        $cs_emp_funs->cs_cv_add_trans( $cs_trans_fields );

                        $cs_html .= __( 'You have successfully subscribed free package.', 'jobhunt' );
                    }

                    echo CS_FUNCTIONS()->cs_special_chars( $cs_html );
                } else {

                    echo '<div class="cs-no-record">' . cs_info_messages_listing( __( 'You have already subscribe a Package.', 'jobhunt' ) ) . '</div>';
                }
            }
            ?>

            <div class="cs-resumes">
                <div class="scetion-title">

                    <h3><?php _e( 'Packages', 'jobhunt' ) ?></h3>

                </div>
                <?php
                $cs_results = false;

                if ( (is_array( $cs_packages_options ) && sizeof( $cs_packages_options ) > 0 ) || ( is_array( $cs_cv_pkgs_options ) && sizeof( $cs_cv_pkgs_options ) > 0 ) ) {

                    $args = array(
                        'posts_per_page' => "-1",
                        'post_type' => 'cs-transactions',
                        'post_status' => 'publish',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'cs_transaction_user',
                                'value' => $current_user->ID,
                                'compare' => '=',
                            ),
                            array(
                                'relation' => 'OR',
                                array(
                                    'key' => 'cs_transaction_cv_pkg',
                                    'value' => '',
                                    'compare' => '!=',
                                ),
                                array(
                                    'key' => 'cs_transaction_package',
                                    'value' => '',
                                    'compare' => '!=',
                                ),
                            ),
                        ),
                    );

                    $custom_query = new WP_Query( $args );

                    $cs_trans_count = $custom_query->post_count;
                    ?>



                    <?php
                    if ( $cs_trans_count > 0 ) {
                        ?>

                        <div class="dashboard-content-holder">

                            <div class="table-responsive">

                                <table class="table">

                                    <thead>

                                        <tr>

                                            <td>#</td>

                                            <td><?php _e( 'Transaction id', 'jobhunt' ) ?></td>

                                            <td><?php _e( 'Package', 'jobhunt' ) ?></td>

                                            <td><?php _e( 'Expiry', 'jobhunt' ) ?></td>

                                            <td><?php _e( 'Total Jobs/CVs', 'jobhunt' ) ?></td>

                                            <td><?php _e( 'Used', 'jobhunt' ) ?></td>

                                            <td><?php _e( 'Remaining', 'jobhunt' ) ?></td>

                                            <td><?php _e( 'Status', 'jobhunt' ) ?></td>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php
                                        $cs_trans_num = 1;

                                        $cs_expire_trans = $cs_emp_funs->cs_expire_pkgs_id();

                                        $cv_expire_trans = $cs_emp_funs->cs_expire_cv_pkgs_id();

                                        while ( $custom_query->have_posts() ) : $custom_query->the_post();

                                            $cs_trans_id = get_post_meta( get_the_id(), "cs_transaction_id", true );

                                            $cs_trans_expiry = get_post_meta( get_the_id(), "cs_transaction_expiry_date", true );

                                            $cs_trans_type = get_post_meta( get_the_id(), "cs_transaction_type", true );

                                            $cs_trans_lists = get_post_meta( get_the_id(), "cs_transaction_listings", true );

                                            $cs_trans_status = get_post_meta( get_the_id(), "cs_transaction_status", true );

                                            $cs_tr_post_id = get_the_id();

                                            $cs_trans_status = $cs_trans_status != '' ? $cs_trans_status : 'pending';
											
											if ($cs_trans_status == 'pending') {
												$cs_trans_status = __('Pending', 'jobhunt');
											} else if ($cs_trans_status == 'active') {
												$cs_trans_status = __('Active', 'jobhunt');
											} else if ($cs_trans_status == 'approved') {
												$cs_trans_status = __('Approved', 'jobhunt');
											}

                                            $cs_trans_status = $cs_trans_status == 'approved' ? 'active' : $cs_trans_status;

                                            $cs_trans_lists = $cs_trans_lists != '' && $cs_trans_lists > 0 ? $cs_trans_lists : 0;

                                            if ( $cs_trans_expiry != '' ) {

                                                $cs_trans_expiry = date_i18n( get_option( 'date_format' ), $cs_trans_expiry );
                                            }

                                            if ( $cs_trans_type == 'cv_trans' ) {

                                                $cs_trans_pkg = get_post_meta( $cs_tr_post_id, "cs_transaction_cv_pkg", true );

                                                $cs_trans_pkg_title = $cs_emp_funs->get_cv_pkg_field( $cs_trans_pkg );
                                            } else {

                                                $cs_trans_pkg = get_post_meta( $cs_tr_post_id, "cs_transaction_package", true );

                                                $cs_trans_pkg_title = $cs_emp_funs->get_pkg_field( $cs_trans_pkg );
                                            }

                                            if ( $cs_trans_type != 'cv_trans' ) {

                                                if ( $cs_emp_funs->cs_is_pkg_subscribed( $cs_trans_pkg ) && $cs_emp_funs->cs_is_pkg_subscribed( $cs_trans_pkg, true ) == $cs_trans_id ) {

                                                    $cs_pkg = $cs_emp_funs->cs_update_pkg_subs( true, $cs_trans_pkg );

                                                    if ( CS_FUNCTIONS()->cs_special_chars( $cs_emp_funs->cs_user_pkg_detail( $cs_pkg, '', true ) ) != '' ) {

                                                        echo '<tr>';

                                                        echo '<td>' . absint( $cs_trans_num ) . '</td>';

                                                        echo CS_FUNCTIONS()->cs_special_chars( $cs_emp_funs->cs_user_pkg_detail( $cs_pkg, '', true ) );

                                                        echo '</tr>';

                                                        $cs_trans_num ++;
                                                    }
                                                } else if ( is_array( $cs_expire_trans ) && in_array( $cs_tr_post_id, $cs_expire_trans ) ) {

                                                    echo '<tr>';

                                                    echo '<td>' . absint( $cs_trans_num ) . '</td>';

                                                    echo CS_FUNCTIONS()->cs_special_chars( $cs_emp_funs->cs_expire_pkgs( $cs_tr_post_id ) );

                                                    echo '</tr>';

                                                    $cs_trans_num ++;
                                                } else if ( $cs_trans_pkg_title != '' ) {
                                                    ?>

                                                    <tr>

                                                        <td><?php echo absint( $cs_trans_num ) ?></td>

                                                        <td>#<?php echo absint( $cs_trans_id ) ?></td>

                                                        <td><?php echo CS_FUNCTIONS()->cs_special_chars( $cs_trans_pkg_title ) ?></td>

                                                        <td><?php echo CS_FUNCTIONS()->cs_special_chars( $cs_trans_expiry ) ?></td>

                                                        <td><?php echo absint( $cs_trans_lists ) ?></td>

                                                        <td>-</td>

                                                        <td>-</td>

                                                        <td><?php echo ucfirst( $cs_trans_status ) ?></td>

                                                    </tr>

                                                    <?php
                                                    $cs_trans_num++;
                                                }
                                            } else if ( $cs_trans_type == 'cv_trans' ) {

                                                $cs_get_trans_id = '';

                                                if ( $cs_emp_funs->cs_is_cv_pkg_subs( $cs_trans_pkg ) ) {

                                                    $cs_get_trans_id = get_post_meta( $cs_emp_funs->cs_is_cv_pkg_subs( $cs_trans_pkg, true ), "cs_transaction_id", true );
                                                }

                                                if ( $cs_emp_funs->cs_is_cv_pkg_subs( $cs_trans_pkg ) && $cs_get_trans_id == $cs_trans_id ) {

                                                    $cs_trans_post_id = $cs_tr_post_id;

                                                    $cs_pkg_subs = array( 'pkg_id' => $cs_trans_pkg, 'trans_id' => $cs_trans_post_id );

                                                    if ( CS_FUNCTIONS()->cs_special_chars( $cs_emp_funs->user_cv_pkg_detail( $cs_pkg_subs, true ) ) != '' ) {

                                                        echo '<tr>';

                                                        echo '<td>' . absint( $cs_trans_num ) . '</td>';

                                                        echo CS_FUNCTIONS()->cs_special_chars( $cs_emp_funs->user_cv_pkg_detail( $cs_pkg_subs, true ) );

                                                        echo '</tr>';

                                                        $cs_trans_num ++;
                                                    }
                                                } else if ( is_array( $cv_expire_trans ) && in_array( $cs_tr_post_id, $cv_expire_trans ) ) {

                                                    echo '<tr>';

                                                    echo '<td>' . absint( $cs_trans_num ) . '</td>';

                                                    echo CS_FUNCTIONS()->cs_special_chars( $cs_emp_funs->cs_cv_expire_pkgs( $cs_tr_post_id ) );

                                                    echo '</tr>';

                                                    $cs_trans_num ++;
                                                } else if ( $cs_trans_pkg_title != '' ) {
                                                    ?>

                                                    <tr>

                                                        <td><?php echo absint( $cs_trans_num ) ?></td>

                                                        <td>#<?php echo absint( $cs_trans_id ) ?></td>

                                                        <td><?php echo CS_FUNCTIONS()->cs_special_chars( $cs_trans_pkg_title ) ?></td>

                                                        <td><?php echo CS_FUNCTIONS()->cs_special_chars( $cs_trans_expiry ) ?></td>

                                                        <td><?php echo absint( $cs_trans_lists ) ?></td>

                                                        <td>-</td>

                                                        <td>-</td>

                                                        <td><?php echo ucfirst( $cs_trans_status ) ?></td>

                                                    </tr>

                                                    <?php
                                                    $cs_trans_num ++;
                                                }
                                            }

                                        endwhile;
                                        ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                        <?php
                    } else {

                        echo '<div class="cs-no-record">' . cs_info_messages_listing( __( "There is no package in your list.", 'jobhunt' ) ) . '</div>';
                    }
                } else {

                    echo '<div class="cs-no-record">' . cs_info_messages_listing( __( "There is no package in your list.", 'jobhunt' ) ) . '</div>';
                }
                ?>

            </div>

            <?php
            die();
        }

        /**

         * End Function Createing job Packages in Ajax Function

         */
        //cs-msgbox-1720
    }

    $cs_emp_ajax_temps = new cs_employer_ajax_templates();
} 