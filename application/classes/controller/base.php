<?php
 defined('SYSPATH') or die('No direct script access.');

 class Controller_Base extends Controller_Template
  {
     public $template = 'templates/default';

     /**
      * Initialize properties before running the controller methods (actions),
      * so they are available to our action.
      */
     public function before()
      {
         // Run anything that need ot run before this.
         parent::before();

         if($this->auto_render)
          {
            // Initialize empty values
            $this->template->title            = '';
            $this->template->meta_keywords    = '';
            $this->template->meta_description = '';
            $this->template->meta_copywrite   = '';
            $this->template->header           = '';
            $this->template->navigation       = '';
            $this->template->leftcolumn       = '';
            $this->template->content          = '';
            $this->template->footer           = '';
            $this->template->styles           = array();
            $this->template->scripts          = array();
          }
      }

     /**
      * Fill in default values for our properties before rendering the output.
      */
     public function after()
      {
         if($this->auto_render)
          {
             // Define defaults
             $styles                  = array(SITE_PATH.'media/css/livepage.css' => 'screen');
             $scripts                 = array(SITE_PATH.'media/js/jquery.min.js',
             SITE_PATH.'media/js/loadleftcolumn.js',
             SITE_PATH.'media/js/checkinput.js',
             //'js/addlatlng.js',
             SITE_PATH.'media/js/getlatlng.js'
             );

             // Add defaults to template variables.
             $this->template->styles  = array_reverse(array_merge($this->template->styles, $styles));
             $this->template->scripts = array_reverse(array_merge($this->template->scripts, $scripts));
           }

         // Run anything that needs to run after this.
         parent::after();
      }
 }
