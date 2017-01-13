<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 18/03/16
 * @desc Controller for categories
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;

class CategoriesController extends AppController
{
    /**
     * ACTION FOR SHOW "EDIT CATEGORIES"
     */
    public function edit($id){
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

        /* DATA : CURRENT CATEGORY */
        $mycategories = $this->Categories->find('all', array(
            'conditions' => array('Categories.id' => $id),
            'limit' => 1
        ));

        /* DATA : COUNT FOR ALL UNREAD POSTS */
        $query = $this->Posts->find('all', ['conditions' => ['Posts.reading' => 0]]);
        $allcounter = $query->count();

        /* SEND : SEND DATA FOR THE INDEX.CTP VIEW */
        $this->set(compact('categories','allcounter','user','mycategories'));
    }

    /**
     * ACTION FOR SHOW "ADD CATEGORIES"
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
     * ACTION FOR EDIT CATEGORIES
     */
    public function editcategories(){

        $this->autoRender = false; /* NO VIEW */

        /* POSTS DATA */
        $id = $this->request->data['id'];
        $catname = $this->request->data['name'];

        if ($this->request->is('post')) { /* IF REQUEST IS POST */
            if(!empty($id) && !empty($catname)){

                /* EDIT CATEGORY */
                $catTable = TableRegistry::get('Categories');
                $cat = $catTable->get($id);
                $cat->name = $catname;
                $catTable->save($cat);
                $this->Flash->success('Category updated.');
                return $this->redirect(['controller' => 'Categories', 'action' => 'edit', $id]);

            }else{
                $this->Flash->error('Empty field, try again.');
                return $this->redirect(['controller' => 'Categories', 'action' => 'edit', $id]);
            }
        }else{
            $this->Flash->error('Error, try again.');
            return $this->redirect(['controller' => 'Categories', 'action' => 'edit', $id]);
        }
    }

    /**
     * ACTION FOR DELETE CATEGORIES
     */
    public function deletecategories($id){

        $this->autoRender = false; /* NO VIEW */

        if(!empty($id)){
            $query = $this->Categories->find('all');
            if($query->count() > 1){
                /* DELETE CATEGORY */
                try{
                    $entity = $this->Categories->get($id);
                    $this->Categories->delete($entity);
                }catch (Exception $e) {
                    $this->Flash->success('Websites are associated with this categories. Move websites before deleting the category.');
                    return $this->redirect(['controller' => 'Settings', 'action' => 'categories']);
                }
                $this->Flash->success('Category deleted.');
                return $this->redirect(['controller' => 'Settings', 'action' => 'categories']);
            }else{
                $this->Flash->error('It must remain one category.');
                return $this->redirect(['controller' => 'Settings', 'action' => 'categories']);
            }
        }else{
            $this->Flash->error('Error, try again.');
            return $this->redirect(['controller' => 'Settings', 'action' => 'categories']);
        }
    }

    /**
     * ACTION FOR ADD CATEGORIES
     */
    public function addcategories(){

        $this->autoRender = false; /* NO VIEW */

        /* POSTS DATA */
        $catname = $this->request->data['name'];

        if ($this->request->is('post')) { /* IF REQUEST IS POST */
            if(!empty($catname)){

                /* ADD CATEGORY */
                $categoryTable = TableRegistry::get('categories');
                $category = $categoryTable->newEntity();
                $category->name = $catname;
                $categoryTable->save($category);

                $this->Flash->success('Category added.');
                return $this->redirect(['controller' => 'Settings', 'action' => 'categories']);

            }else{
                $this->Flash->error('Empty field, try again.');
                return $this->redirect(['controller' => 'Categories', 'action' => 'add']);
            }
        }else{
            $this->Flash->error('Error, try again.');
            return $this->redirect(['controller' => 'Categories', 'action' => 'add']);
        }
    }
}