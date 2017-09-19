<?php
class ControllerExtensionModuleBlog extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/blog');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		$data['heading_search'] = $this->language->get('heading_search');
		$data['heading_category'] = $this->language->get('heading_category');
		$data['heading_post'] = $this->language->get('heading_post');
		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['filter_name'])) {
			$data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$data['filter_name'] = '';
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
		$this->load->model('tool/image');

		if(!empty($setting['category_status'])) {
			if (isset($this->request->get['path'])) {
				$parts = explode('_', (string)$this->request->get['path']);
			} else {
				$parts = array();
			}

			if (isset($parts[0])) {
				$data['category_id'] = $parts[0];
			} else {
				$data['category_id'] = 0;
			}

			if (isset($parts[1])) {
				$data['child_id'] = $parts[1];
			} else {
				$data['child_id'] = 0;
			}

			$data['categories'] = array();

			$categories = $this->model_blog_category->getCategories(0);

			foreach ($categories as $category) {
				$children_data = array();

				if ($category['category_id'] == $data['category_id']) {
					$children = $this->model_blog_category->getCategories($category['category_id']);

					foreach($children as $child) {
						$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

						$children_data[] = array(
							'category_id'	=> $child['category_id'],
							'name'			=> $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_blog_post->getTotalPosts($filter_data) . ')' : ''),
							'href'			=> $this->url->link('blog/category', 'blog_path=' . $category['category_id'] . '_' . $child['category_id'])
						);
					}
				}

				$filter_data = array(
					'filter_category_id'	=> $category['category_id'],
					'filter_sub_category'	=> true
				);

				$data['categories'][] = array(
					'category_id'	=> $category['category_id'],
					'name'			=> $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_blog_post->getTotalPosts($filter_data) . ')' : ''),
					'children'		=> $children_data,
					'href'			=> $this->url->link('blog/category', 'blog_path=' . $category['category_id'])
				);
			}

			$blog_blocks[$setting['category_sort_order']] = 'categories';
		}

		if(!empty($setting['post_status'])) {
			$data['latest_posts'] = array();

			$filter_data = array(
				'sort'	=> 'p.date_added',
				'order'	=> 'DESC',
				'start'	=> 0,
				'limit'	=> 5
			);

			$results = $this->model_blog_post->getPosts($filter_data);

			if ($results) {
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], 42, 42, 'crop');
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 42, 42);
					}

					$data['latest_posts'][] = array(
						'post_id'		=> $result['post_id'],
						'thumb'			=> $image,
						'name'			=> $result['name'],
						'description'	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 75) . '..',
						'published'		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
						'href'			=> $this->url->link('blog/post', 'post_id=' . $result['post_id'])
					);
				}
			}
			$blog_blocks[$setting['post_sort_order']] = 'latest_posts';
		}

		ksort($blog_blocks);

		$data['blog_blocks'] = $blog_blocks;

		return $this->load->view('extension/module/blog', $data);
	}
}