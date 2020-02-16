<?php 
/**
 * My first controller
 */
namespace Drupal\mymodule\Controller;
use Drupal\Core\Controller\ControllerBase;
/**
 * An example controller.
 */
class  MymoduleController extends ControllerBase{
    /**
   * Returns a render-able array for a test page.
   */
    public function content(){
        return array(
            '#type'=>'markup',
            'markup'=>'This is my menu linked custom page'
        );
    }
}