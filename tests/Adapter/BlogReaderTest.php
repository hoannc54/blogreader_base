<?php
use PHPUnit\Framework\TestCase;

class BlogReaderTest extends TestCase
{
    public $url = 'http://khoacongnghethongtin.blogspot.com/2016/12/download-quan-ly-chuyen-nghiep-cho.html';
	public function testGetInfo(){
	    $blog = new \Dok123\BlogReader\Adapter\BlogReader($this->url);
	    $info = $blog->getInfo();

	    if (is_array($info) && !empty($info)){
//            var_dump($info);
	        $this->assertTrue(true);
        }else{
	        $this->assertTrue(false);
        }
    }

    /**
     * Test trường hợp url không tồn tại
     */
    public function testGetInfoWithUrlNotFound(){

    }

    /** *********************** posts() ****************************** */

    /**
     * Lấy bài viết từ trang hiện tại
     */
    public function testPostsNormal(){
        $url = 'http://khoacongnghethongtin.blogspot.com/2016/12/download-quan-ly-chuyen-nghiep-cho.html';
        $blog = new \Dok123\BlogReader\Adapter\BlogReader($url);
        $data = $blog->posts();
//        print_r($data);
        die();
    }

    /**
     * Lấy bài viết có lọc theo fields
     */
    public function testPostsFromFields(){
        $url = 'http://khoacongnghethongtin.blogspot.com/';
        $blog = new \Dok123\BlogReader\Adapter\BlogReader($url);
        $fields = [
            'id',
            'title',
            'created',
            'published',
            'updated',
//            'content',
//            'labels'
        ];
        $posts = $blog->posts($fields);
        print_r($posts);
    }

    /**
     * Lấy bài viết từ 1 trang cụ thể
     */
    public function testPostsFromPage(){

    }
    /**
     * Đọc trang tiếp theo
     */

    public function testNext(){
        $url = '';
        $blog = new \Dok123\BlogReader\Adapter\BlogReader($url);
        $next = $blog->next();
    }

    public function testCurrentPage(){
        $url = 'http://khoacongnghethongtin.blogspot.com/';
        $blog = new \Dok123\BlogReader\Adapter\BlogReader($url);
        $data = $blog->current_page();
        print_r($data);

    }

    public function testSetKeyword(){

    }

    public function testResetKeyword(){

    }

    public function testLabels(){

    }
}