<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 4/9/18
 * Time: 23:29
 */

namespace Dok123\BlogReader\Adapter;


class BlogReader extends ReaderAbstract
{
    public $api_key = 'AIzaSyBbVshNpiYTlTy13aRPmBX0UEpEIaKwToM';
    public $blogId;
    public $info;
    public $keyword;
    const BASE_URL = 'https://www.googleapis.com/blogger/v3/';
    /** Get Info */
    function __construct($url)
    {
        parent::__construct($url);
//        $this->setInfo();
//        $this->blogId = $this->getBlogId($this->info);

    }

    public function getInfo()
    {
        return $this->getInfo();
    }

    public function setInfo(){
        $response = $this->client->get(self::BASE_URL . 'blogs/byurl?key=' . $this->api_key.'&url=' . $this->url);
        $info = json_decode($response->getBody()->getContents(), true);
        $this->info = $info;
    }

    public function check(){
        try{
            $response = $this->client->get(self::BASE_URL . 'blogs/byurl?key=' . $this->api_key.'&url=' . $this->url);
            if ($response->getStatusCode() == 200){
                return true;
            }else{
                return false;
            }
        }catch (\Exception $exception){
            return false;
        }

    }
    /**
     * lấy các bài viết trang hiện tại hoặc trang tương ứng page truyền vào.
     * Biến fields dạng array, tùy chọn field muốn lấy ra từ 1 bài viết.
     * */
    public function posts(array $fields = null, $page = null, $per_page = 20)
    {
        if (empty($page)){
            $data = $this->current_page();
        }else{
            $data = $this->page($page);
        }

        if (!empty($fields)){
            $items = $this->getItemFromFields($data['items'], $fields);
        }else{
            $items = $data['items'];
        }
        return $items;
    }

    /**
     * Lọc theo fields
     * @param $items
     * @param $fields
     * @return array
     */
    private function getItemFromFields($items, $fields){
        $items_new = [];
        foreach ($items as $item){
            $items_new[] = array_intersect_key($item, array_flip($fields));
        }
        return $items_new;
    }
    /**
     * đọc trang tiếp theo, trả về true nếu thành công, false nếu hết trang.
     * Để dọc nội dung thì gọi hàm trên với $page và $per_page mặc định
     */
    public function next()
    {
        $current_page = $this->current_page();
        $nextPageToken = $current_page['nextPageToken'];
        $data = $this->page($nextPageToken);
        return $data;
    }

    public function page($pageId = null){
        $request_url = self::BASE_URL . 'blogs/'. $this->blogId.'/pages/' . $pageId;
        $response = $this->client->get($request_url);
        $data = json_decode($response->getBody()->getContents());
        return $data;
    }
    /**
     *get page hiện tại, page_token nếu là blogspot
     */
    public function current_page()
    {
        if (empty($this->keyword)){
            $request_url = self::BASE_URL . 'blogs/'.$this->blogId . '/posts';
        }else{
            $request_url = self::BASE_URL . 'blogs/'.$this->blogId . '/posts/search?q=' . $this->keyword;
        }

        $response = $this->client->get($request_url, ['query' => ['key' => $this->api_key]]);
        $data = json_decode($response->getBody()->getContents(), true);
        return $data;
    }

    /**
     * cài đặt keyword, sau khi cài keyword, các posts, pages đọc như trên
     * @param $keyword
     * @return mixed
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * xóa điều kiện keyword hiện tại
     */
    public function resetKeyword()
    {
        $this->keyword = '';
    }

    /**
     * Lấy ra labels có trên trang
     * @param int $limit
     * @return mixed
     */
    public function labels($limit = 100)
    {
        // TODO: Implement labels() method.
    }

    private function getBlogId(array $info){
        return $info['id'];
    }
}