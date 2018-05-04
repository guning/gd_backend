<?php
/**
 * Created by PhpStorm.
 * User: guning
 * Date: 2017/12/7
 * Time: 19:16
 */
include 'Common.class.php';
use core\Auth;
use core\View;
use app\model\Article;
use app\model\User;
class Gadmin extends Common
{
    private $model;
    private $userModel;
    protected $args = [];

    protected function auth()
    {
        // TODO: Implement auth() method.
        return true;
    }

    public function __construct(){
        $this->model = new Article();
        $this->userModel = new User();
    }

    protected function beforeRun($method) {
        $users = $this->userModel->getUsers();
        if (!Auth::auth($users)) {
            header('HTTP/1.0 403 Forbidden');
            echo "403 Forbidden";
            exit;
        }
        $methods = get_class_methods($this);
        if (!in_array($method, $methods)) {
            \core\Logger::errorLog('Warning : access to a undefined method: ' . $_SERVER['REQUEST_URI']);
            echo "404";
            exit;
        }
    }

    public function run($method, $args = []) {
        try {
            $this->beforeRun($method);
            $this->args = $args;
            $res = $this->$method();
        } catch (Exception $e) {
            \core\Logger::errorLog($e->getMessage());
            $res = "something wrong!";
        }
        $this->afterRun($res);
    }


    public function show() {
        $page = isset($this->args[0]) ? $this->args[0] : 'list';
        if (!in_array($page, ['modify', 'list'])) {
            $page = 'list';
        }
        if ($page == 'list') {
            $res = $this->model->getAdminList();
            $lists = [];
            foreach ($res as $row) {
                $lists[] = [
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'author' => $row['name'],
                    'status' => $row['status'],
                    'c_time' => date("Ymd H:i:s", $row['create_time']),
                    'u_time' => date("Ymd H:i:s", $row['update_time'])
                ];
            }
            $vars = ['page' => $page, 'list' => $lists];
        } else {
            $content = $title = $summary = '';
            $type = 0;
            if (isset($this->args[1]) && is_numeric($this->args[1])) {
                $data = $this->model->getArticle($this->args[1]);
                if (!empty($data)) {
                    $content = $data['file'];
                    $title = $data['title'];
                    $summary = $data['summary'];
                }
                $type = $this->args[1];
            }
            $vars = ['page' => $page, 'content' => $content, 'type' => $type, 'title' => $title, 'summary' => $summary];
        }
        $content = View::get('admin_' . $page, $vars);
        return $content;
    }


    /**
     * m:modify
     * @author by 罟宁
     * @return mixed
     * createTime: 2017年12月9日10:02:05
     */
    public function m() {
        $article = [
            'title' => $_POST['title'],
            'summary' => $_POST['summary']
        ];
        $content = $_POST['content'];
        $type = $_POST['type'];
        if ($type == 0) {
            $name = $_SERVER['PHP_AUTH_USER'];
            $id = $this->userModel->getUserId($name);
            if ($id === -1) {
                return '403';
            }
            $article['user_id'] = $id;
            $res = $this->model->add($article, $content);
        } else {
            $articleId = $type;
            $res = $this->model->updateArticle($articleId, $article, $content);
        }
        return $res ? 1 : 0;
    }

    /**
     * d:delete
     * @author by 罟宁
     * @return int
     * createTime:2017年12月9日10:02:26
     */
    public function d() {
        $articleId = $_POST['id'];
        if ($this->model->delete($articleId)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * s:status
     * @author by 罟宁
     * @return int
     * createTime:
     */
    public function s() {
        $articleId = $_POST['id'];
        if ($this->model->changeStatus($articleId)) {
            return 1;
        } else {
            return 0;
        }
    }
}