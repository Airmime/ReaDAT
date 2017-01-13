<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 10/02/16
 * @desc Controller for websites
 */

namespace App\Controller;

use Cake\Core\Exception\Exception;
use Cake\Utility\Xml;
use Cake\Network\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class WebsitesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('reload');
    }

    /**
     * ACTION FOR RELOAD RSS FEEDS
     */
    public function reload(){

        /* LOADING : POST MODELS */
        $this->loadModel('Posts');

        /* DATA : WEBSITES */
        $websites = $this->Websites->find('all', [
            'conditions' => array('Websites.active' => 1)
        ]);

        /* BROWSE WEBSITE/RSS FEEDS ASSOCIATE */
        foreach($websites as $website){

            // INIT : BREAK VARIABLE
            $i = 0;

            try{
                /* NEW : HTTP CLIENT */
                try{
                    $http = new Client();
                    $response = $http->get($website->rssfeed);

                    /* BUILD : RSS FEEDS */
                    $xml = Xml::build($response->body());
                }catch (Exception $e){
                    echo $e;
                }

                echo "$website->title OK <br/>";

                /* BROWSE RSS FEED */
                foreach ($xml->channel->item as $item) {

                    /* DATE : FORMAT DATE */
                    try {
                        $date = date('Y-m-d H:i:s', strtotime($item->pubDate));
                        $less_one_month = mktime(0, 0, 0, date("m") - 12, date("d"), date("Y"));
                        if (strtotime($date) > strtotime(date('Y-m-d H:i:s')) || strtotime($date) < $less_one_month) {
                            $date = date('Y-m-d H:i:s');
                        }
                    } catch (Exception $e) {
                        $date = date('Y-m-d H:i:s');
                    }

                    /* PICTURE : PICTURE DATE */
                    try {
                        ini_set('max_execution_time', 300);
                        set_time_limit(0);

                        if (isset($item->enclosure['url'])) {
                            try {
                                if (exif_imagetype($item->enclosure['url']) == IMAGETYPE_JPEG || exif_imagetype($item->enclosure['url']) == IMAGETYPE_PNG || exif_imagetype($item->enclosure['url']) == IMAGETYPE_GIF) {

                                    $width = getimagesize($item->enclosure['url']);
                                    if ($width[0] >= 150) {

                                        $picture = $item->enclosure['url'];
                                    } else {
                                        $picture = null;
                                    }

                                } else {
                                    $picture = null;
                                }
                            } catch (Exception $e) {
                                echo $e;
                            }
                        } else {
                            $picture = null;
                        }
                    } catch (Exception $e) {
                        $picture = null;
                    }

                    /* DATA : INSERT POST */
                    $query = $this->Posts->find('all', array('conditions' => array('Posts.uuid' => md5(substr('' . $website->id . date('y') . '' . $item->link . '', 0, 127)))));
                    $counter = $query->count();

                    if ($counter == 0) {
                        $articlesTable = TableRegistry::get('posts');
                        $article = $articlesTable->newEntity();

                        $article->title = strip_tags($item->title);
                        $article->url = $item->link;
                        $article->created = $date;
                        $article->uuid = md5(substr('' . $website->id . date('y') . '' . $item->link . '', 0, 127));
                        $article->text = strip_tags($item->description);
                        $article->picture = $picture;
                        $article->websites_id = $website->id;

                        $articlesTable->save($article);
                    }

                    /* STOP : BREAK LOOP */
                    if($i>4) break;
                    $i++;
                }
            }catch (\Exception $e){
                echo $e;
                continue;
            }
        }
    }

    /**
     * ACTION FOR ADD WEBSITE
     */
    public function add(){
        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
        $this->loadModel('Websites');
        $this->loadModel('Posts');

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

        /* SEND : SEND DATA */
        $this->set(compact('categories','allcounter','user'));
    }

    /**
     * ACTION ADDING WEBSITE
     */
    public function addwebsites(){

        $this->loadModel('rssfeeds');/* LOAD MODEL */
        $this->autoRender = false; /* NO VIEW */

        /* POSTS DATA */
        $url = $this->request->data['url'];
        $domaine = parse_url($url);
        $rssfeed = $this->request->data['rssfeed'];
        $cat = $this->request->data['category'];

        if ($this->request->is('post')) { /* IF REQUEST IS POST */
            if(!empty($url) && !empty($rssfeed) && !empty($cat)){

                /* ADD WEBSITE */
                $websiteTable = TableRegistry::get('websites');
                $website = $websiteTable->newEntity();

                $website->title = $domaine['host'];
                $website->url = $url;
                $website->rssfeed = $rssfeed;
                $website->favicon = 'http://www.google.com/s2/favicons?domain='.$domaine['host'].'';
                $website->categories_id = $cat;

                $websiteTable->save($website);

                $this->Flash->success('Websites added.');
                return $this->redirect(['controller' => 'Settings', 'action' => 'websites']);

            }else{
                $this->Flash->error('Empty field, try again.');
                return $this->redirect(['controller' => 'Categories', 'action' => 'add']);
            }
        }else{
            $this->Flash->error('Error, try again.');
            return $this->redirect(['controller' => 'Categories', 'action' => 'add']);
        }
    }

    /**
     * ACTION EDIT WEBSITE
     */
    public function edit($id){
        /* LOADING : OTHERS MODELS */
        $this->loadModel('Categories');
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

        /* DATA : CURRENT CATEGORY */
        $mywebsite = $this->Websites->find('all', array(
            'conditions' => array('Websites.id' => $id),
            'limit' => 1
        ));

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('categories','allcounter','user','mywebsite'));
    }

    /**
     * ACTION EDITING WEBSITE
     */
    public function editwebsites(){
        $this->autoRender = false; /* NO VIEW */

        /* POSTS DATA */
        $title = $this->request->data['title'];
        $url = $this->request->data['url'];
        $rssfeed = $this->request->data['rssfeed'];
        $favicon = $this->request->data['favicon'];
        $picture = $this->request->data['picture'];
        $category = $this->request->data['category'];
        $active = $this->request->data['active'];
        $id = $this->request->data['id'];

        if ($this->request->is('post')) { /* IF REQUEST IS POST */
            if(!empty($id) && !empty($title) && !empty($url) && !empty($rssfeed)){

                /* EDIT CATEGORY */
                $webTable = TableRegistry::get('Websites');
                $web = $webTable->get($id);

                $web->title = $title;
                $web->url = $url;
                $web->rssfeed = $rssfeed;
                $web->favicon = $favicon;
                $web->picture = $picture;
                $web->categories_id = $category;
                $web->active = $active;

                $webTable->save($web);

                $this->Flash->success('Website updated.');
                return $this->redirect(['controller' => 'Websites', 'action' => 'edit', $id]);

            }else{
                $this->Flash->error('Empty field, try again.');
                return $this->redirect(['controller' => 'Websites', 'action' => 'edit', $id]);
            }
        }else{
            $this->Flash->error('Error, try again.');
            return $this->redirect(['controller' => 'Websites', 'action' => 'edit', $id]);
        }
    }

    /**
     * ACTION DELETING WEBSITE
     */
    public function deletewebsite($id){

        $this->autoRender = false; /* NO VIEW */

        if(!empty($id)){
            /* DELETE CATEGORY */
            try{
                $entity = $this->Websites->get($id);
                $this->Websites->delete($entity);
            }catch (Exception $e) {
                $this->Flash->success('Error.');
                return $this->redirect(['controller' => 'Settings', 'action' => 'websites']);
            }
            $this->Flash->success('Website deleted.');
            return $this->redirect(['controller' => 'Settings', 'action' => 'websites']);
        }else{
            $this->Flash->error('Error, try again.');
            return $this->redirect(['controller' => 'Settings', 'action' => 'websites']);
        }
    }
}