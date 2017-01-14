<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 30/01/16
 * @desc Controller for posts
 */
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class PostsController extends AppController
{
    /**
     * INIT CONTROLLER
     */
    public function initialize()
    {
        parent::initialize();

        /* LOADING : AJAX COMPONENT */
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    /**
     * IF APP NOT INSTALL
     */
    public function beforeFilter(Event $event) {
        if (!file_exists(TMP.'installed.txt')) {
            return $this->redirect(
                ['controller' => 'Installer', 'action' => 'index']
            );
        }
    }

    /**
     * ACTION FOR INDEX
     */
    public function index(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Settings');

        /* DATA : SETTINGS */
        $settings = $this->Settings->find('all', array(
            'limit' => '1'
        ));

        /* SETTINGS */
        foreach($settings as $setting):
            $nbshowposts = $setting->nbshowposts;
        endforeach;

        /* INIT : PAGINATE FOR DATA POSTS */
        $this->paginate = array(
            'contain' => array('Websites'),
            'limit' => $nbshowposts,
            'order' => array('Posts.created' => 'desc'),
        );
        $posts = $this->paginate($this->Posts);

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : MOST ACTIVE TODAY*/
        $hooks = $this->Websites->find('all', [
                'conditions' => [
                    'Websites.nb_unread !=' => 0],
                'limit' => 3,
                'order' => array('Websites.nb_unread' => 'desc')]
        );

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('posts','categories','allcounter','hooks','settings'));
    }

    /**
     * ACTION FOR CATEGORIES
     */
    public function websites($idWeb){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Websites');
        $this->loadModel('Categories');
        $this->loadModel('Settings');

        /* DATA : SETTINGS */
        $settings = $this->Settings->find('all', array(
            'limit' => '1'
        ));

        /* SETTINGS */
        foreach($settings as $setting):
            $nbshowposts = $setting->nbshowposts;
        endforeach;

        /* INIT : PAGINATE FOR DATA POSTS */
        $this->paginate = array(
            'contain' => array('Websites'),
            'limit' => $nbshowposts,
            'order' => array('Posts.created' => 'desc'),
            'conditions' => array('Posts.websites_id' => $idWeb)
        );
        $posts = $this->paginate($this->Posts);

        /* DATA : WEBSITES DATA */
        $websites = $this->Websites->find('all', ['conditions' => ['Websites.id' => $idWeb]]);

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : MOST ACTIVE TODAY*/
        $hooks = $this->Websites->find('all', [
                'conditions' => [
                    'Websites.nb_unread !=' => 0],
                'limit' => 3,
                'order' => array('Websites.nb_unread' => 'desc')]
        );

        /* DATA : COUNT FOR UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0, 'Posts.websites_id' => $idWeb]]);
        $counter = $query->count();

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('posts','categories','counter','websites','allcounter','hooks','settings'));
    }

    /**
     * ACTION FOR CATEGORIES
     */
    public function category($idCategory){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Websites');
        $this->loadModel('Categories');
        $this->loadModel('Settings');

        /* DATA : SETTINGS */
        $settings = $this->Settings->find('all', array(
            'limit' => '1'
        ));

        /* SETTINGS */
        foreach($settings as $setting):
            $nbshowposts = $setting->nbshowposts;
        endforeach;

        /* INIT : PAGINATE FOR DATA POSTS */
        $this->paginate = array(
            'contain' => array('Websites'),
            'limit' => $nbshowposts,
            'order' => array('Posts.created' => 'desc'),
            'conditions' => array('Websites.categories_id' => $idCategory)
        );
        $posts = $this->paginate($this->Posts);

        /* DATA : WEBSITES DATA */
        $category = $this->Categories->find('all', ['conditions' => ['Categories.id' => $idCategory]]);

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : MOST ACTIVE TODAY*/
        $hooks = $this->Websites->find('all', [
                'conditions' => [
                    'Websites.nb_unread !=' => 0],
                'limit' => 3,
                'order' => array('Websites.nb_unread' => 'desc')]
        );

        /* DATA : COUNT FOR UNREAD POSTS */
        $query = $this->Posts->find('all', [
                'conditions' => [
                    'Posts.reading' => 0,
                    'Websites.categories_id' => $idCategory],
                'contain' => array('Websites')
            ]
        );
        $counter = $query->count();

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('posts','categories','counter','category','allcounter','hooks','settings'));
    }

    /**
     * ACTION FOR FAV POSTS
     */
    public function favorites(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Settings');

        /* DATA : SETTINGS */
        $settings = $this->Settings->find('all', array(
            'limit' => '1'
        ));

        /* SETTINGS */
        foreach($settings as $setting):
            $nbshowposts = $setting->nbshowposts;
        endforeach;

        /* INIT : PAGINATE FOR DATA POSTS */
        $this->paginate = array(
            'contain' => array('Websites'),
            'limit' => $nbshowposts,
            'order' => array('Posts.created' => 'desc'),
            'conditions' => array(
                'Posts.favorite' => 1
            )
        );
        $posts = $this->paginate($this->Posts);

        /* DATA : CATEGORIES FOR MENU */
        $categories = $this->Categories->find('all', array(
            'contain' => array(
                'Websites' => array(
                    'conditions' => array('Websites.active' => 1)
                )
            )
        ));

        /* DATA : MOST ACTIVE TODAY*/
        $hooks = $this->Websites->find('all', [
                'conditions' => [
                    'Websites.nb_unread !=' => 0],
                'limit' => 3,
                'order' => array('Websites.nb_unread' => 'desc')]
        );

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('posts','categories','allcounter','hooks','settings'));
    }

    /**
     * ACTION FOR PUT POSTS READ (AJAX)
     */
    public function read(){

        /* LOADING : OTHERS MODELS */
        $this->loadModel('Websites');
        $this->loadModel('Categories');

        /* AJAX : RECEIPT */
        if($this->request->is('ajax') && $this->request->is('post') && $this->request->data['all']=='all')
        {
            /* DATA : SET ALL UNREAD POST TO 1 */
            $this->Posts->updateAll(
                array('Posts.reading' => 1)
            );

            /* DATA : SET ALL UNREAD COUNTER WEBSITE POST TO 0 */
            $this->Websites->updateAll(
                array('Websites.nb_unread' => 0)
            );
        }
        elseif($this->request->is('ajax') && $this->request->is('post') && $this->request->data['id'] != null){

            /* INIT : ID FOR REQUEST */
            $id = $this->request->data['id'];

            /* DATA : FIND THE POST WITH ID */
            $postsTable = TableRegistry::get('Posts');
            $post = $postsTable->get($id);

            /* DATA : CHANGE VALUE */
            $post->reading = 1;

            /* DATA : DONE */
            $postsTable->save($post);
        }elseif($this->request->is('ajax') && $this->request->is('post') && $this->request->data['websites'] != null){

            /* DATA : SET ALL UNREAD POST TO 1 */
            $this->Posts->updateAll(
                array('Posts.reading' => 1),
                array('Posts.websites_id' => $this->request->data['websites'])
            );

            /* DATA : SET ALL UNREAD COUNTER WEBSITE POST TO 0 */
            $this->Websites->updateAll(
                array('Websites.nb_unread' => 0),
                array('Websites.id' => $this->request->data['websites'])
            );

        }elseif($this->request->is('ajax') && $this->request->is('post') && $this->request->data['category'] != null){

            /* DATA : POSTS */
            $posts = $this->Posts->find('all', [
                    'contain' => 'Websites',
                    'conditions' => [
                        'Websites.categories_id' => $this->request->data['category'],
                        'Posts.reading' => 0],
                    'order' => array('Posts.created' => 'desc')]
            );

            $postsTable = TableRegistry::get('Posts');

            /* DATA : SET UNREAD POST TO 1 */
            foreach($posts as $po){

                $po = $postsTable->get($po->id);
                $po->reading = 1;

                /* DATA : DONE */
                $postsTable->save($po);

                /* DATA : SET ALL UNREAD COUNTER WEBSITE POST TO 0 */
                $this->Websites->updateAll(
                    array('Websites.nb_unread' => 0),
                    array('Websites.id' => $po->websites_id)
                );
            }

        }else{
            die;
            // TODO : EXCEPTION
        }

        $this->autoRender = false;
    }

    /**
     * ACTION FOR FAV POST (AJAX)
     */
    public function favorite(){

        /* AJAX : RECEIPT ID POST FOR FAV */
        if($this->request->is('ajax') && $this->request->is('post') && is_numeric($this->request->data['idposts']))
        {
            /* INIT : ID FOR REQUEST */
            $id = $this->request->data['idposts'];

            /* DATA : FIND THE POST WITH ID */
            $postsTable = TableRegistry::get('Posts');
            $post = $postsTable->get($id);

            /* DATA : CHANGE VALUE */
            if($post->favorite == 0){
                $post->favorite = 1;
            }else{
                $post->favorite = 0;
            }
            $postsTable->save($post);
        }
        else{
            die;
            // TODO : EXCEPTION
        }

        $this->autoRender = false;
    }

}