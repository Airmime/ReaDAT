<?php
/**
 * @author Rémi MARION
 * @version 0.1.0
 * Date: 15/03/16
 * @desc Controller for installer
 */

namespace App\Controller;

use Cake\Core\Exception\Exception;
Use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;

class InstallerController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['index','database','user']);

        if (file_exists(TMP.'installed.txt')) {
            echo 'Application already installed. Remove app/config/installed.txt to reinstall the application';
            exit();
        };
    }

    /**
     * ACTION FOR INSTALL APP
     */
    public function index(){

    }

    /**
     * ACTION FOR INSTALL DATABASE
     */
    public function database(){

        if (!file_exists(TMP.'installed.txt')) {

            $this->loadModel('Settings');

            // INSTALL DATABASE
            try{
                $conn = ConnectionManager::get('default');
                $conn->query('

                CREATE TABLE IF NOT EXISTS categories (
                  id INT NOT NULL AUTO_INCREMENT,
                  name VARCHAR(255) NOT NULL,
                  PRIMARY KEY (id))
                ENGINE = InnoDB;

                CREATE TABLE IF NOT EXISTS websites (
                  id INT NOT NULL AUTO_INCREMENT,
                  title VARCHAR(255) NOT NULL,
                  url VARCHAR(255) NOT NULL,
                  rssfeed VARCHAR(255) NOT NULL,
                  active INT NOT NULL DEFAULT 1,
                  nb_unread INT NOT NULL DEFAULT 0,
                  favicon VARCHAR(255) NULL,
                  picture VARCHAR(255) NULL,
                  categories_id INT NOT NULL,
                  PRIMARY KEY (id),
                  INDEX fk_websites_categories1_idx (categories_id ASC),
                  CONSTRAINT fk_websites_categories1
                    FOREIGN KEY (categories_id)
                    REFERENCES categories (id)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                ENGINE = InnoDB;

                CREATE TABLE IF NOT EXISTS posts (
                  id INT NOT NULL AUTO_INCREMENT,
                  title VARCHAR(255) NOT NULL,
                  url VARCHAR(255) NOT NULL,
                  created DATETIME NOT NULL,
                  uuid VARCHAR(128) NOT NULL,
                  reading INT NOT NULL DEFAULT 0,
                  favorite INT NOT NULL DEFAULT 0,
                  text LONGTEXT NULL,
                  picture VARCHAR(255) NULL,
                  websites_id INT NOT NULL,
                  PRIMARY KEY (id),
                  INDEX fk_posts_websites1_idx (websites_id ASC),
                  UNIQUE INDEX uuid_UNIQUE (uuid ASC),
                  CONSTRAINT fk_posts_websites1
                    FOREIGN KEY (websites_id)
                    REFERENCES websites (id)
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                ENGINE = InnoDB;

                CREATE TABLE IF NOT EXISTS settings (
                  id INT NOT NULL AUTO_INCREMENT,
                  showimg INT NOT NULL DEFAULT 1,
                  nbtext INT NOT NULL DEFAULT 255,
                  nbshowposts INT NOT NULL DEFAULT 50,
                  PRIMARY KEY (id))
                ENGINE = InnoDB;

                CREATE TABLE IF NOT EXISTS users (
                  id INT NOT NULL AUTO_INCREMENT,
                  username VARCHAR(255) NOT NULL,
                  password VARCHAR(255) NOT NULL,
                  mail VARCHAR(255) NOT NULL,
                  resetcode VARCHAR(255) NULL,
                  PRIMARY KEY (id),
                  UNIQUE INDEX username_UNIQUE (username ASC))
                ENGINE = InnoDB;

                INSERT INTO settings (id, showimg, nbtext, nbshowposts) VALUES (NULL, 1, 255, 50);
                INSERT INTO categories (id, name) VALUES (NULL, \'Default\');

              ');
            }catch (Exception $e){
                echo 'Error install database';
                echo '<br/>';
                echo $e;
            }
        }
    }

    /**
     * ACTION FOR ADD DEFAULT USER
     */
    public function user(){

        /* ADD CATEGORY */
        $UsersTable = TableRegistry::get('Users');
        $users = $UsersTable->newEntity();
        $users->username = 'admin';
        $users->password = 'admin';
        $UsersTable->save($users);

        $file = new File(TMP.'installed.txt', true, 0644);
        $file->create();
        $file->write('Don\'t remove this file !');

    }
}