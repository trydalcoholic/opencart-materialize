<?php
class ControllerExtensionModuleBlog extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/blog');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['heading_search'] = $this->language->get('heading_search');
		$data['heading_category'] = $this->language->get('heading_category');
		$data['heading_archive'] = $this->language->get('heading_archive');
		$data['heading_post'] = $this->language->get('heading_post');
		$data['heading_comment'] = $this->language->get('heading_comment');
		$data['heading_tag'] = $this->language->get('heading_tag');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['filter_title'])) {
			$data['filter_title'] = $this->request->get['filter_title'];
		} else {
			$data['filter_title'] = '';
		}

		if (isset($this->request->get['blog_category_id'])) {
			$data['blog_category_id'] = $this->request->get['blog_category_id'];
		} else {
			$data['blog_category_id'] = 0;
		}

		if (isset($this->request->get['date_added'])) {
			$data['date_added'] = $this->request->get['date_added'];
		} else {
			$data['date_added'] = 0;
		}

		$blog_blocks =  array();

		if(!empty($setting['search_status'])) {
			$blog_blocks[$setting['search_sort_order']] = 'search';
		}

		$this->load->model('blog/category');
		$this->load->model('blog/post');
		$this->load->model('blog/comment');
		$this->load->model('tool/image');

		if(!empty($setting['category_status'])) {

			$data['categories'] = array();

			$categories = $this->model_blog_category->getCategories();

			foreach ($categories as $category) {

				$filter_data = array(
					'filter_blog_category_id'  => $category['blog_category_id']
				);

				$data['categories'][] = array(
					'blog_category_id' 	=> $category['blog_category_id'],
					'name'        		=> $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_blog_post->getTotalPosts($filter_data) . ')' : ''),
					'href'        		=> $this->url->link('blog/category', 'blog_category_id=' . $category['blog_category_id'])
				);
			}

			$blog_blocks[$setting['category_sort_order']] = 'categories';
		}

		if(!empty($setting['archive_status'])) {

			$data['archives'] = array();

			$post_dates = $this->model_blog_post->getPostsDate($setting['archive_type']);

			foreach ($post_dates as $post_date) {

				if($setting['archive_type']){
					$date_added = date('F, Y', strtotime($post_date['date_added']));
				}else{
					$date_added = 'Year ' . date('Y', strtotime($post_date['date_added']));
				}

				$data['archives'][] = array(
					'title'        	=> $date_added,
					'date_added' 	=> $post_date['date_added2'],
					'href'			=> $this->url->link('blog/category', 'filter_date_added=' . $post_date['date_added2'])
				);
			}

			$blog_blocks[$setting['archive_sort_order']] = 'archives';
		}

		if(!empty($setting['post_status'])) {
			$data['recent_posts'] = array();

			$filter_data = array(
				'sort'		=> 'p.date_added',
				'order'  	=> 'DESC',
				'start'  	=> 0,
				'limit'  	=> $setting['post_limit']
			);

			$posts = $this->model_blog_post->getPosts($filter_data);

			foreach ($posts as $post) {

				$data['recent_posts'][] = array(
					'blog_post_id' 		=> $post['blog_post_id'],
					'title'        		=> $post['title'],
					'image'        		=> $this->model_tool_image->resize($post['image'], 42, 42, 'crop'),
					'date_added' 		=> date_create($post['date_added']),
					'description'		=> utf8_substr(strip_tags(html_entity_decode($post['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'href'        		=> $this->url->link('blog/post', 'blog_post_id=' . $post['blog_post_id'])
				);
			}

			$blog_blocks[$setting['post_sort_order']] = 'recent_posts';

		}

		if(!empty($setting['comment_status'])) {

			$data['recent_comments'] = array();

			$filter_data = array(
				'sort'		=> 'r.date_added',
				'order'  	=> 'DESC',
				'start'  	=> 0,
				'limit'  	=> $setting['comment_limit']
			);

			$comments = $this->model_blog_comment->getComments($filter_data);

			foreach ($comments as $comment) {

				$data['recent_comments'][] = array(
					'blog_comment_id' 	=> $comment['blog_comment_id'],
					'title'        		=> $comment['title'],
					'author'        	=> $comment['author'],
					'date_added' 		=> date_create($comment['date_added']),
					'text'   			=> utf8_substr(strip_tags(html_entity_decode($comment['text'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'href'        		=> $this->url->link('blog/post', 'blog_post_id=' . $comment['blog_post_id'])
				);
			}

			$blog_blocks[$setting['comment_sort_order']] = 'recent_comments';

		}

		if(!empty($setting['tag_status'])){

			$data['tags'] = array();
			$filter_data = array(
				'order'  	=> 'ASC',
				'limit'  	=> $setting['tag_limit']
			);

			$tags = $this->model_blog_post->getPostTags($filter_data);

			if ($tags) {
				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('blog/category', 'filter_title=' . trim($tag))
					);
				}
			}

			$blog_blocks[$setting['tag_sort_order']] = 'tags';

		}


		ksort($blog_blocks);

		$data['blog_blocks'] = $blog_blocks;

		return $this->load->view('extension/module/blog', $data);
	}
}