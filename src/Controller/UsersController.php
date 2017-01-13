<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 15/03/16
 * @desc Controller for users
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Mailer\Email;

class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['forgot','sendpassword']);
    }

    /**
     * ACTION FOR LOGIN USER
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__("Username or password incorrect, try again."));
        }
    }

    /**
     * ACTION FORGOT PASSWORD
     */
    public function forgot()
    {

    }

    /**
     * ACTION FOR SEND PASSWORD
     */
    public function sendpassword()
    {

        $this->autoRender = false; /* NO VIEW */

        /* POSTS DATA */
        $mail = $this->request->data['mail'];

        if ($this->request->is('post') && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {

            /* DATA : USERS */
            $query = $this->Users->find('all', ['conditions' => ['mail' => $mail]]);
            if($query->count() != 0){

                /* NEW PASSWORD */
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@";
                $password = substr( str_shuffle( $chars ), 0, 8 );

                $email = new Email('default');
                $email->from([$mail => 'Readat.io'])
                    ->to($mail)
                    ->subject('Your new password !')
                    ->send('
                        Yo,
                        A new password was generated: '. $password.'
                        For security reasons consider changing this password.
                    ');

                /* EDIT PASSWORD */
                $usersTable = TableRegistry::get('Users');
                foreach($query as $usr){
                    $iduser = $usr->id;
                }
                $user = $usersTable->get($iduser);
                $user->password = $password;
                $usersTable->save($user);

                $this->Flash->success('The new password has been sent. Check your mail.');
                return $this->redirect(
                    ['controller' => 'Users', 'action' => 'login']
                );

            }else{
                $this->Flash->error('Mail incorrect, try again.');
                return $this->redirect(
                    ['controller' => 'Users', 'action' => 'forgot']
                );
            }

        }else{
            $this->Flash->error('Mail incorrect, try again.');
            return $this->redirect(
                ['controller' => 'Users', 'action' => 'forgot']
            );
        }
    }

    /**
     * ACTION FOR ADD USER
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__("L'utilisateur a été sauvegardé."));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__("Impossible d'ajouter l'utilisateur."));
        }
        $this->set('user', $user);
    }

    /**
     * ACTION FOR LOGOUT USER
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * ACTION FOR EDIT ACCOUNT:USERNAME&MAIL
     */
    public function editaccount()
    {
        $this->autoRender = false; /* NO VIEW */

        if ($this->request->is('post')) { /* IF REQUEST IS POST */

            $id = $this->request->session()->read('Auth.User.id'); /* USER ID */

            /* POSTS DATA */
            $username = $this->request->data['username'];
            $mail = $this->request->data['mail'];

            /* IF USERNAME OK */
            if(isset($username) && strlen($username)>2){

                /* EDIT USERNAME */
                $usersTable = TableRegistry::get('Users');
                $user = $usersTable->get($id);
                $user->username = $username;
                $usersTable->save($user);
                $this->request->session()->write([
                    'Auth.User.username' => $username
                ]);
                $this->Flash->success('Username updated.');

                /* IF MAIL OK */
                if(isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)){

                    /* EDIT USERNAME */
                    $user = $usersTable->get($id);
                    $user->mail = $mail;
                    $usersTable->save($user);
                    $this->request->session()->write([
                        'Auth.User.mail' => $mail
                    ]);
                    $this->Flash->success('Mail updated.');
                    return $this->redirect(
                        ['controller' => 'Settings', 'action' => 'index']
                    );
                }else{
                    $this->Flash->error('Mail incorrect, try again.');
                    return $this->redirect(
                        ['controller' => 'Settings', 'action' => 'index']
                    );
                }
            }else{
                $this->Flash->error('Username or mail incorrect, try again.');
                return $this->redirect(
                    ['controller' => 'Settings', 'action' => 'index']
                );
            }
        }
    }

    /**
     * ACTION FOR EDIT ACCOUNT:PASSWORD
     */
    public function editpassword(){

        $this->autoRender = false; /* NO VIEW */

        if ($this->request->is('post')) { /* IF REQUEST IS POST */

            $id = $this->request->session()->read('Auth.User.id'); /* USER ID */

            /* POSTS DATA */
            $newpassword = $this->request->data['newpassword'];
            $newpasswordbis = $this->request->data['newpasswordbis'];

            /* IF FIELD NOT EMPTY */
            if(!empty($newpassword) && !empty($newpasswordbis)){
                if($newpassword == $newpasswordbis){

                    /* EDIT PASSWORD */
                    $usersTable = TableRegistry::get('Users');
                    $user = $usersTable->get($id);
                    $user->password = $newpassword;
                    $usersTable->save($user);
                    $this->Flash->success('Password updated.');
                    return $this->redirect(['controller' => 'Settings', 'action' => 'password']);

                }else{
                    $this->Flash->error('Password not same, try again.');
                    return $this->redirect(['controller' => 'Settings', 'action' => 'password']);
                }
            }else{
                $this->Flash->error('Empty field, try again.');
                return $this->redirect(['controller' => 'categories', 'action' => 'password']);
            }
        }
    }
}