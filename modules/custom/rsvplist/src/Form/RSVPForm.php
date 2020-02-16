<?php

namespace Drupal\rsvplist\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an example form.
 */
class RSVPForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'rpsvlist_email_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $node=\Drupal::routeMatch()->getParameter('node');
    if($node){
      $nid=$node->nid->value;
    }else{
      $nid=null;
    }
    
    $form['email'] = [
      '#title' => 'Email Address',
      '#type' => 'textfield',
      '#required'=>true
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];
    $form['nid'] = [
      '#value' => $nid,
      '#type' => 'hidden',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email=$form_state->getValue('email');
    if($email==!\Drupal::service('email.validator')->isValid($email)) {
      $form_state->setErrorByName('email', $this->t('The email is not valid'),array(
        'email'=>$email
      ));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user=\Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    
    db_insert('rsvplist')
   ->fields(array(
     'mail'=>$form_state->getValue('email'),
     'nid'=>$form_state->getValue('nid'),
     'uid'=>$user->id(),
     'created'=>time()
   ))->execute();
   
    $this->messenger()->addStatus($this->t('Success'));
  }

}