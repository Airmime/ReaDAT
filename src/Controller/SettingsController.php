<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 16/03/16
 * @desc Controller for settings
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;

class SettingsController extends AppController
{
    /**
     * ACTION FOR SHOW AND EDIT ACCOUNT:USERNAME&MAIL
     */
    public function index(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Posts');
        $this->loadModel('Settings');

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('categories','allcounter','user'));
    }

    /**
     * ACTION FOR EDIT PASSWORD
     */
    public function password(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Posts');
        $this->loadModel('Settings');

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('categories','allcounter','user'));
    }

    /**
     * ACTION FOR EDIT CATEGORIES
     */
    public function categories(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Posts');
        $this->loadModel('Settings');

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('categories','allcounter'));
    }

    /**
     * ACTION FOR EDIT WEBSITES
     */
    public function websites(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Posts');
        $this->loadModel('Settings');

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : CATEGORIES FOR MENU */
        $websites = $this->Websites->find('all', array(
            'contain' => array('Categories')
        ));

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('websites','categories','allcounter'));
    }

    /**
     * ACTION FOR GENERALS SETTINGS
     */
    public function general(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Posts');
        $this->loadModel('Settings');

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : CATEGORIES FOR MENU */
        $websites = $this->Websites->find('all');

        /* DATA : SETTINGS */
        $settings = $this->Settings->find('all', array(
            'limit' => '1'
        ));

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('websites','categories','allcounter','settings'));
    }

    /**
     * ACTION FOR EDITING SETTINGS
     */
    public function editgeneral(){

        $this->autoRender = false; /* NO VIEW */

        /* POSTS DATA */
        $id = $this->request->data['id'];
        $showpictures = $this->request->data['showpictures'];
        $nbtext = $this->request->data['nbtext'];
        $nbshowposts = $this->request->data['nbshowposts'];

        if ($this->request->is('post')) { /* IF REQUEST IS POST */
            if(!empty($id) && !empty($nbtext) && !empty($nbshowposts)){

                if(is_numeric($showpictures) && is_numeric($nbtext) && is_numeric($nbshowposts)){

                    /* EDIT CATEGORY */
                    $settingsTable = TableRegistry::get('Settings');
                    $setting = $settingsTable->get($id);

                    $setting->showimg = $showpictures;
                    $setting->nbtext = $nbtext;
                    $setting->nbshowposts = $nbshowposts;

                    $settingsTable->save($setting);

                    $this->Flash->success('Settings updated.');
                    return $this->redirect(['controller' => 'Settings', 'action' => 'general', $id]);

                }else{
                    $this->Flash->error('Error seized, try again.');
                    return $this->redirect(['controller' => 'Settings', 'action' => 'general', $id]);
                }

            }else{
                $this->Flash->error('Empty field, try again.');
                return $this->redirect(['controller' => 'Settings', 'action' => 'general', $id]);
            }
        }else{
            $this->Flash->error('Error, try again.');
            return $this->redirect(['controller' => 'Settings', 'action' => 'general', $id]);
        }
    }
}