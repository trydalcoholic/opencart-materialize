<?php
class ControllerBlogCategory extends Controller {
	public function index() {
		$this->load->language('blog/category');

		$this->load->model('blog/category');

		$this->load->model('blog/post');

		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_blog'),
			'href' => $this->url->link('blog/category')
		);

		if (isset($this->request->get['blog_path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['blog_path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_blog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text'	=> $category_info['name'],
						'href'	=> $this->url->link('blog/category', 'blog_path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_blog_category->getCategory($category_id);

		if ($category_info) {
			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'])
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'), 'crop');
				$this->document->setOgImage($data['thumb']);
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
		} else {
			$url = '';

			if (isset($this->request->get['blog_path'])) {
				$url .= '&blog_path=' . $this->request->get['blog_path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->document->setTitle($this->language->get('text_blog'));

			$data['heading_title'] = $this->language->get('text_blog');
			$data['description'] = '';
		}

		if (!isset($this->request->get['blog_path'])) {
			$this->request->get['blog_path'] = '';
		}

		$data['text_refine'] = $this->language->get('text_refine');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');
		$data['text_read_more'] = $this->language->get('text_read_more');
		$data['text_author'] = $this->language->get('text_author');
		$data['text_published'] = $this->language->get('text_published');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_continue'] = $this->language->get('button_continue');

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['categories'] = array();

		$results = $this->model_blog_category->getCategories($category_id);

		foreach ($results as $result) {
			$filter_data = array(
				'filter_category_id'  => $result['category_id'],
				'filter_sub_category' => true
			);

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 32, 32);
			} else {
				$image = '';
			}

			if ($this->request->get['blog_path'] != 0) {
				$data['categories'][] = array(
					'name'	=> $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_blog_post->getTotalPosts($filter_data) . ')' : ''),
					'href'	=> $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'] . '_' . $result['category_id'] . $url),
					'thumb'	=> $image
				);
			} else {
				$data['categories'][] = array(
					'name'	=> $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_blog_post->getTotalPosts($filter_data) . ')' : ''),
					'href'	=> $this->url->link('blog/category', 'blog_path=' . $result['category_id'] . $url),
					'thumb'	=> $image
				);
			}
		}

		$data['posts'] = array();

		$filter_data = array(
			'filter_category_id' => $category_id,
			'filter_filter'      => $filter,
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);

		$post_total = $this->model_blog_post->getTotalPosts($filter_data);

		$results = $this->model_blog_post->getPosts($filter_data);

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resizeBlog($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			}

			$data['posts'][] = array(
				'post_id'		=> $result['post_id'],
				'thumb'			=> $image,
				'author'		=> $result['author'],
				'name'			=> $result['name'],
				'description'	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
				'published'		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'href'			=> $this->url->link('blog/post', 'blog_path=' . $this->request->get['blog_path'] . '&post_id=' . $result['post_id'] . $url)
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href'  => $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'] . '&sort=p.sort_order&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href'  => $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'] . '&sort=pd.name&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href'  => $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'] . '&sort=pd.name&order=DESC' . $url)
		);

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = array();

		$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'] . $url . '&limit=' . $value)
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $post_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'] . $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($post_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($post_total - $limit)) ? $post_total : ((($page - 1) * $limit) + $limit), $post_total, ceil($post_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($this->request->get['blog_path'] != 0) {
			if ($page == 1) {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=', true), 'canonical');
			} elseif ($page == 2) {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=' . $category_info['category_id'], true), 'prev');
			} else {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=' . $category_info['category_id'] . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($post_total / $limit) > $page) {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=' . $category_info['category_id'] . '&page='. ($page + 1), true), 'next');
			}
		}
		else {
			if ($page == 1) {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=', true), 'canonical');
			} elseif ($page == 2) {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=', true), 'prev');
			} else {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=' . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($post_total / $limit) > $page) {
				$this->document->addLink($this->url->link('blog/category', 'blog_path=' . '&page='. ($page + 1), true), 'next');
			}
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('blog/category', $data));
	}
}