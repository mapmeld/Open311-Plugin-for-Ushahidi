<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Open311 Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module	   Open311 Settings Controller	
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
* 
*/

// at the moment this is just an edit of the clickatell controller that needs a lot of revisions.  For open311 implementation one idea for admin settings is to allow users to determine how Ushahidi data will map to open311 data.  See comments in hook file.  

class Open311_Settings_Controller extends Admin_Controller
{
	public function index()
	{
		$this->template->this_page = 'addons';
		
		// Standard Settings View
		$this->template->content = new View("admin/plugins_settings");
		$this->template->content->title = "Open311 Settings";
		
		// Settings Form View
		$this->template->content->settings_form = new View("open311/admin/open311_settings");
		
		// JS Header Stuff
      //  $this->template->js = new View('open311/admin/open311_settings_js');
		
		// setup and initialize form field names
        $form = array
        (
            'open311_api' => '',
            'open311_username' => '',
            'open311_password' => ''
        );
        //  Copy the form as errors, so the errors will be stored with keys
        //  corresponding to the form field names
        $errors = $form;
        $form_error = FALSE;
        $form_saved = FALSE;

        // check, has the form been submitted, if so, setup validation
        if ($_POST)
        {
            // Instantiate Validation, use $post, so we don't overwrite $_POST
            // fields with our own things
            $post = new Validation($_POST);

            // Add some filters
            $post->pre_filter('trim', TRUE);

            // Add some rules, the input field, followed by a list of checks, carried out in order

            $post->add_rules('open311_api','required', 'length[4,20]');
            $post->add_rules('open311_username', 'required', 'length[3,50]');
            $post->add_rules('open311_password', 'required', 'length[5,50]');

            // Test to see if things passed the rule checks
            if ($post->validate())
            {
                // Yes! everything is valid
                $open311 = new Open311_Model(1);
                $open311->open311_api = $post->open311_api;
                $open311->open311_username = $post->open311_username;
                $open311->open311_password = $post->open311_password;
                $open311->save();

                // Everything is A-Okay!
                $form_saved = TRUE;

                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());

            }

            // No! We have validation errors, we need to show the form again,
            // with the errors
            else
            {
                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());

                // populate the error fields, if any
                $errors = arr::overwrite($errors, $post->errors('settings'));
                $form_error = TRUE;
            }
        }
        else
        {
            // Retrieve Current Settings
            $open311 = ORM::factory('open311', 1);

            $form = array
            (
                'open311_api' => $open311->open311_api,
                'open311_username' => $open311->open311_username,
                'open311_password' => $open311->open311_password
            );
        }
		
		// Pass the $form on to the settings_form variable in the view
		$this->template->content->settings_form->form = $form;
		
		
		// Do we have a frontlineSMS Key? If not create and save one on the fly
        $open311 = ORM::factory('open311', 1);
		
		if ($open311->loaded AND $open311->open311_key)
		{
			$open311_key = $open311->open311_key;
		}
		else
		{
			$open311_key = strtoupper(text::random('alnum',8));
            $open311->open311_key = $open311_key;
            $open311->save();
		}

		$this->template->content->settings_form->open311_key = $open311_key;
		$this->template->content->settings_form->open311_link = url::site()."open311/index/".$open311_key;
		
		// Other variables
	    $this->template->content->errors = $errors;
		$this->template->content->form_error = $form_error;
		$this->template->content->form_saved = $form_saved;
	}
	
	/**
     * Retrieves Open311 Balance using Open311 Library
     */
    function smsbalance()
    {
        $this->template = "";
        $this->auto_render = FALSE;

        $open311 = ORM::factory("open311")->find(1);
        if ($open311->loaded)
		{
            $open311_api = $open311->open311_api;
            $open311_username = $open311->open311_username;
            $open311_password = $open311->open311_password;

            $testsms = new Open311_API();
            $testsms->api_id = $open311_api;
            $testsms->user = $open311_username;
            $testsms->password = $open311_password;
            $testsms->use_ssl = false;
            $testsms->sms();
            // echo $mysms->session;
            echo $testsms->getbalance();
        }
    }
}
