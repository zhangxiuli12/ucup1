<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{

    public function index()
    {
        $this->display();
    }

    public function login()
    {
        if (IS_POST) {
            $name = I('post.name');
            $password = md5(I('post.password'));

            if ($result = (M('admin')->where("username=" . '"' . $name . '"' . 'and password=' . '"' . $password . '"')->find())) {

                echo '登陆成功';
                session('lock', true);  //设置session
                session('name', $name);
                $this->redirect('Index/upload/', '', 1, '页面跳转中...');
            } else {
                $this->error('登录失败');
            }
        } else {
            $this->display();
        }
    }

    public function upload()
    {
        $iosurl = M('download')->where('name="iOS"')->getField('url');

        $this->assign('pathname', $iosurl);
        if (!session('lock')) {
            exit('无权浏览');
        }

        $this->display();
    }

    public function ios()
    {

        echo '<meta charset=utf-8>';
        if (IS_POST) {
            $download = M('download');
            $data['url'] = I('post.file1');

            $result = $download->where('name="iOS"')->save($data);
            if ($result !== false) {
                if ($this->qrcode($data['url'], './iOS/iOSqrcode.png', './iOS/iOS.png', './iOS/', './Public/images/ios.png', 8)) {

                    $this->redirect('Index/upload', '', 3, 'ios地址上传成功页面跳转中...');
                } else {
                    echo '生成二维码失败';
                }
            } else {
                echo '上传失败';
            }
            exit;
        }
        $this->display();
    }

    /*
     qrcode（）生成二维码
     *@param $data 二维码的信息
     * @param $qrname 原始二维码的保存名称无logo
     * @param $logo logo的名称
     * @param $path 保存图片的目录
     * @param  $logoname logo名称
     * @param $size logo二维码图片大小
     * @return qrlogoname 返回带logo的二维码名称
     */
    public function qrcode($data, $qrname, $logo, $path, $logoqrname, $size)
    {

        vendor("phpqrcode.phpqrcode");
        $object = new \QRcode();
        // 纠错级别：L、M、Q、H
        $level = 'H';


        $object->png($data, $qrname, $level, $size);

        $QR = $qrname;//已经生成的原始二维码图
        if ($logo !== FALSE) {
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }
        //输出图片

        imagepng($QR, $logoqrname);
        return $logoqrname;

    }

    public function show()
    {
        $this->display();

    }

    public function logout()
    {
        session(null); // 清空当前的session
        $this->redirect('Index/login', '', 1, '注销成功...');
    }

    public function  changepwd()
    {
        if (!session('lock')) {
            $this->error('请登录', 'Index/login', 1);
        } else {
            if (IS_POST) {
                if (md5(I('post.pwd1')) == M('admin')->getField('password')) {
                    $data['password'] = md5(I('post.pwd2'));
                    $result = M('admin')->where('username=' . '"' . session('name') . '"')->save($data);
                    if ($result) {
                        $this->redirect('Index/login', '', 1, '密码修改成功...');
                    } else {
                        $this->error('密码修改失败');
                    }
                } else {
                    $this->error('原密码有误');
                }
            } else {
                $this->display();
            }
        }
    }

    public function android()
    {
        if (IS_POST) {
            if (!empty($_FILES)) {

                $apppath = './Uploads/' . date('Y-m-d', time()) . '/app.apk';


                if (file_exists($apppath)) {
                    unlink($apppath);
                }
            }
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 10145728;// 设置附件上传大小
            $upload->exts = array('apk');// 设置附件上传类型
            //上传文件
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功
                $data['url'] = '/Uploads/' . $info['file']['savepath'] . $info['file']['savename'];
                $download = M('download');
                $result = $download->where('name="Android"')->save($data);

                if ($result !== false) {
                    if ($this->android = $qrcodeinfo = $this->qrcode('http://' . $_SERVER['SERVER_NAME'] . $data['url'], './Android/Andrqrcode.png', './Android/Android.png', './Android/', './Public/images/Android.png', 7)) {

                        $this->redirect('Index/upload', '', 3, 'android地址上传成功页面跳转中...');

                    } else {
                        echo '生成二维码失败';
                    }
                }
            }
            exit;
        }
    }

}