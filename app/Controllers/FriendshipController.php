<?php
namespace App\Controllers;

use App\Models\Friendship;
use App\Models\User;
use App\Core\Controller;
use App\Core\View;

class FriendshipController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $friendship = new Friendship();
        $friendships = $friendship->getAllByUserId($userId);

        $this->view->render('friendship/index', ['friendships' => $friendships]);
    }

    public function requests()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $friendship = new Friendship();
        $requests = $friendship->getRequestsByUserId($userId);

        $this->view->render('friendship/requests', ['requests' => $requests]);
    }

    public function acceptRequest()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $requestId = $_POST['request_id'] ?? '';

        $friendship = new Friendship();
        $friendship->acceptRequest($userId, $requestId);
        header("Location: /friendships/requests");
    }

    public function rejectRequest()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $requestId = $_POST['request_id'] ?? '';

        $friendship = new Friendship();
        $friendship->rejectRequest($userId, $requestId);
        header("Location: /friendships/requests");
    }

    public function removeFriendship()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $friendId = $_POST['friend_id'] ?? '';

        $friendship = new Friendship();
        $friendship->removeFriendship($userId, $friendId);
        header("Location: /friendships");
    }
}
