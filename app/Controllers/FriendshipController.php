<?php

namespace App\Controllers;

use App\Models\Friendship;
use App\Core\View;

class FriendshipController
{
    private $friendshipModel;
    private $view;

    public function __construct()
    {
        $this->friendshipModel = new Friendship();
        $this->view = new View();
    }

    // Adicionar um amigo
    public function add($user_id, $friend_id)
    {
        if (!$this->friendshipModel->exists($user_id, $friend_id)) {
            $this->friendshipModel->add($user_id, $friend_id);
        }
        header('Location: /users/' . $friend_id);
    }

    // Remover um amigo
    public function remove($user_id, $friend_id)
    {
        $this->friendshipModel->remove($user_id, $friend_id);
        header('Location: /users/' . $friend_id);
    }

    // Listar amigos
    public function list($user_id)
    {
        $friends = $this->friendshipModel->getFriends($user_id);
        return $this->view->render('friendships/list.twig', ['friends' => $friends]);
    }
}
