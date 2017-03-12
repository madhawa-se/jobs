<?php

/**
 * File Type: new job  Email Templates
 */
if (!class_exists('jobhunt_new_job_template')) {

    class jobhunt_new_job_template {

        public $email_template_type;
        public $email_default_template;
        public $email_template_variables;
        public $email_template_index;
        public $is_email_sent;
        public static $is_email_sent1;
        public $user;
        public $user_pass;
        public $template_group;

        public function __construct() {

            $this->email_template_type = 'New Job';

            $this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">New Job</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="260" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>Hello [ADMIN_NAME] ! A new job is waiting for your review.</td></tr><tr><td style="padding: 10px 0 0 0;"><p style="Margin:0 0 25px 0;font-size:18px;line-height:23px;color:#102231;font-weight:bold">[JOB_TITLE]</p></td></tr><tr><td style="padding: 10px 0 0 0;"><a href="[JOB_LINK]" style="width: 250px;color: #fff;font-size: 1em;text-align: center;font-weight: bold;font-family: HelveticaNeue-Medium;display: inline-block;background-color:#01B3E3;border-radius: 2px;padding: 10px;text-decoration: none;">Review</a></td></tr></table></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016<br/></td></tr></table></td></tr></table></div></body></html>';

            $this->email_template_variables = array(
                array(
                    'tag' => 'ADMIN_NAME',
                    'display_text' => 'Admin Name',
                    'value_callback' => array($this, 'get_admin_name'),
                ),
                array(
                    'tag' => 'JOB_TITLE',
                    'display_text' => 'Job Title',
                    'value_callback' => array($this, 'get_job_title'),
                ),
                array(
                    'tag' => 'JOB_LINK',
                    'display_text' => 'Job Link',
                    'value_callback' => array($this, 'get_job_link'),
                ),
            );
            $this->template_group = 'Job';
            $this->email_template_index = 'new-job-template';
            add_action('init', array($this, 'add_email_template'), 5);
            add_filter('jobhunt_email_template_settings', array($this, 'template_settings_callback'), 12, 1);
            add_action('jobhunt_new_job_email', array($this, 'jobhunt_new_job_email_callback'), 10, 2);

            // Add options in Email Templates Addon
            // add_filter('cs_jobhunt_email_templates_options', array($this, 'email_templates_options_callback'), 10, 1);
        }

        public function template_settings_callback($email_template_options) {

            $email_template_options["types"][] = $this->email_template_type;

            $email_template_options["templates"][$this->email_template_type] = $this->email_default_template;

            $email_template_options["variables"][$this->email_template_type] = $this->email_template_variables;

            return $email_template_options;
        }

        public function get_template() {
            return wp_jobhunt::get_template($this->email_template_index, $this->email_template_variables, $this->email_default_template);
        }

        function get_admin_name() {
            $super_admins = get_super_admins();
            return $super_admins[0];
        }

        function get_admin_email() {
            $admin_email = get_option('admin_email', 'admin@plz-set@email.com');
            return $admin_email;
        }

        function get_job_title() {
            return get_the_title($this->job_id);
        }

        function get_job_link() {
            return esc_url(get_permalink($this->job_id));
        }

        function get_candidate_registered_name() {
            $user_name = $this->user->user_login;
            return $user_name;
        }

        function get_candidate_registered_email() {
            $user_email = $this->user->user_email;
            return $user_email;
        }

        function get_candidate_registered_passsword() {

            $user_password = $this->user_pass;
            return $user_password;
        }

        public function add_email_template() {
            $email_templates = array();
            $email_templates[$this->template_group] = array();
            $email_templates[$this->template_group][$this->email_template_index] = array(
                'title' => $this->email_template_type,
                'template' => $this->email_default_template,
                'email_template_type' => $this->email_template_type,
                'is_recipients_enabled' => false,
                'description' => __('This template is used for review newly added jobs', 'jobhunt'),
                'jh_email_type' => 'html',
            );
            do_action('jobhunt_load_email_templates', $email_templates);
        }

//        public function email_templates_options_callback($cs_setting_options) {
//            $cs_setting_options[] = array(
//                "name" => __('Employer Register', 'jobhunt'),
//                "desc" => '',
//                "hint_text" => '',
//                "id" => $this->email_template_index,
//                "std" => '',
//                'classes' => 'chosen-select-no-single',
//                "type" => 'select_values',
//                "options" => array(),
//                'email_template_type' => $this->email_template_type,
//            );
//
//            return $cs_setting_options;
//        }

        public function jobhunt_new_job_email_callback($user = '', $job_id = '') {


            $this->user = $user;
            $this->job_id = $job_id;
            $template = $this->get_template();
            // checking email notification is enable/disable


            $args = array(
                'to' => $this->get_admin_email(),
                'subject' => 'new job waiting to approve',
                'from' => $from,
                'message' => $template['email_template'],
                'email_type' => $email_type,
                'class_obj' => $this,
            );

            do_action('jobhunt_send_mail', $args);

            ///////////////////////////////////////////
            jobhunt_new_job_template::$is_email_sent1 = $this->is_email_sent;
        }

    }

    new jobhunt_new_job_template();
}
