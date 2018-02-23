<?php
class ControllerExtensionModuleBlog extends Controller {
	public function index() {
		$this->load->language('extension/module/blog');

		$this->load->model('extension/materialize/blog');

		$this->load->model('tool/image');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		/* Search */

		if (isset($this->request->get['blog_search'])) {
			$data['blog_search'] = $this->request->get['blog_search'];
		} else {
			$data['blog_search'] = '';
		}

		/* Categories */

		if (isset($this->request->get['blog_path'])) {
			$parts = explode('_', (string)$this->request->get['blog_path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['blog_category_id'] = $parts[0];
		} else {
			$data['blog_category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$data['categories'] = array();

		$categories = $this->model_extension_materialize_blog->getCategories(0);

		foreach ($categories as $category) {
			$children_data = array();

			if ($category['blog_category_id'] == $data['blog_category_id']) {
				$children = $this->model_extension_materialize_blog->getCategories($category['blog_category_id']);

				foreach($children as $child) {
					$filter_data = array('filter_category_id' => $child['blog_category_id'], 'filter_sub_category' => true);

					$children_data[] = array(
						'blog_category_id'	=> $child['blog_category_id'],
						'name'				=> $child['name'],
						'href'				=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $category['blog_category_id'] . '_' . $child['blog_category_id'])
					);
				}
			}

			$filter_data = array(
				'filter_category_id'	=> $category['blog_category_id'],
				'filter_sub_category'	=> true
			);

			$data['categories'][] = array(
				'blog_category_id'	=> $category['blog_category_id'],
				'name'				=> $category['name'],
				'children'			=> $children_data,
				'href'				=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $category['blog_category_id'])
			);
		}

		/* Latest posts */

		$data['latest_posts'] = array();

		$filter_data = array(
			'sort'	=> 'p.date_added',
			'order'	=> 'DESC',
			'start'	=> 0,
			'limit'	=> $this->config->get('module_blog_post_limit')
		);

		$results = $this->model_extension_materialize_blog->getPosts($filter_data);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resizeBlog($result['image'], 320, 320);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 320, 320);
				}

				$data['latest_posts'][] = array(
					'post_id'		=> $result['post_id'],
					'thumb'			=> $image,
					'name'			=> $result['name'],
					'description'	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 50) . '..',
					'published'		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'href'			=> $this->url->link('extension/materialize/blog/post', 'post_id=' . $result['post_id'])
				);
			}
		}

		return $this->load->view('extension/module/blog', $data);
	}
}