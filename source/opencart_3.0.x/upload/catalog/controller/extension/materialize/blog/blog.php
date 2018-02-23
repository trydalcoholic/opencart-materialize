<?php
class ControllerExtensionMaterializeBlogBlog extends Controller {
	public function index() {
		if ($this->config->get('module_blog_status') == 1) {
			$this->load->language('blog/category');

			$this->load->model('extension/materialize/blog');

			$this->load->model('tool/image');

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
				$limit = $this->config->get('module_blog_post_limit');
			}

			$blog = $this->config->get('module_blog');

			$blog_name				= $blog[$this->config->get('config_language_id')]['name'];
			$blog_meta_title		= $blog[$this->config->get('config_language_id')]['meta_title'];
			$blog_meta_h1			= $blog[$this->config->get('config_language_id')]['meta_h1'];
			$blog_meta_description	= $blog[$this->config->get('config_language_id')]['meta_description'];
			$blog_meta_keyword		= $blog[$this->config->get('config_language_id')]['meta_keyword'];

			if ($blog_meta_title) {
				$this->document->setTitle($blog_meta_title);
			} else {
				$this->document->setTitle($blog_name);
			}

			$this->document->setDescription($blog_meta_description);
			$this->document->setKeywords($blog_meta_keyword);

			if ($blog_meta_h1) {
				$data['heading_title'] = $blog_meta_h1;
			} else {
				$data['heading_title'] = $blog_name;
			}

			$data['color_snippet'] = $this->config->get('module_blog_color_snippet');
			$data['color_title'] = $this->config->get('module_blog_color_title');
			$data['color_tabs'] = $this->config->get('module_blog_color_tabs');
			$data['color_tabs_icon'] = $this->config->get('module_blog_color_tabs_indicator_hex');

			$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text'	=> $this->language->get('text_home'),
				'href'	=> $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text'	=> $blog_name,
				'href'	=> $this->url->link('extension/materialize/blog/blog')
			);

			$data['categories'] = array();

			$categories = $this->model_extension_materialize_blog->getCategories(0);

			foreach ($categories as $category) {
				// Level 2
				$children_data = array();

				$children = $this->model_extension_materialize_blog->getCategories($category['blog_category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'	=> $child['blog_category_id'],
						'filter_sub_category'	=> true
					);

					$children_data[] = array(
						'name'	=> $child['name'],
						'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $category['blog_category_id'] . '_' . $child['blog_category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'		=> $category['name'],
					'thumb'		=> $this->model_tool_image->resize($category['image'], 32, 32),
					'children'	=> $children_data,
					'href'		=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $category['blog_category_id'])
				);
			}

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

			$data['posts'] = array();

			$filter_data = array(
				'sort'	=> $sort,
				'order'	=> $order,
				'start'	=> ($page - 1) * $limit,
				'limit'	=> $limit
			);

			$post_total = $this->model_extension_materialize_blog->getTotalPosts($filter_data);

			$results = $this->model_extension_materialize_blog->getPosts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resizeBlog($result['image'], 320, 320);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 320, 320);
				}

				$data['posts'][] = array(
					'post_id'		=> $result['post_id'],
					'thumb'			=> $image,
					'author'		=> $result['author'],
					'author_link'	=> $this->url->link('extension/materialize/blog/author/info&author_id=' . $result['author_id']),
					'author_image'	=> $this->model_tool_image->resize($result['author_image'], 56, 56),
					'name'			=> $result['name'],
					'description'	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'published'		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'href'			=> $this->url->link('extension/materialize/blog/post&post_id=' . $result['post_id'])
				);
			}

			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'	=> $this->language->get('text_default'),
				'value'	=> 'p.sort_order-ASC',
				'href'	=> $this->url->link('extension/materialize/blog/blog&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'	=> $this->language->get('text_name_asc'),
				'value'	=> 'pd.name-ASC',
				'href'	=> $this->url->link('extension/materialize/blog/blog&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'	=> $this->language->get('text_name_desc'),
				'value'	=> 'pd.name-DESC',
				'href'	=> $this->url->link('extension/materialize/blog/blog&sort=pd.name&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('module_blog_post_limit'), 36, 54, 72, 90));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'	=> $value,
					'value'	=> $value,
					'href'	=> $this->url->link('extension/materialize/blog/blog' . $url . '&limit=' . $value)
				);
			}

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

			$pagination = new MaterializePagination();
			$pagination->total = $post_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('extension/materialize/blog/blog' . $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($post_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($post_total - $limit)) ? $post_total : ((($page - 1) * $limit) + $limit), $post_total, ceil($post_total / $limit));

			if ($page == 1) {
				$this->document->addLink($this->url->link('extension/materialize/blog/blog'), 'canonical');
			} else {
				$this->document->addLink($this->url->link('extension/materialize/blog/blog&page='. $page), 'canonical');
			}

			if ($page > 1) {
				$this->document->addLink($this->url->link('extension/materialize/blog/blog' . (($page - 2) ? '&page='. ($page - 1) : '')), 'prev');
			}

			if ($limit && ceil($post_total / $limit) > $page) {
				$this->document->addLink($this->url->link('extension/materialize/blog/blog&page='. ($page + 1)), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('blog/blog', $data));
		} else {
			$this->load->language('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text'	=> $this->language->get('text_home'),
				'href'	=> $this->url->link('common/home')
			);

			if (isset($this->request->get['route'])) {
				$url_data = $this->request->get;

				unset($url_data['_route_']);

				$route = $url_data['route'];

				unset($url_data['route']);

				$url = '';

				if ($url_data) {
					$url = '&' . urldecode(http_build_query($url_data, '', '&'));
				}

				$data['breadcrumbs'][] = array(
					'text'	=> $this->language->get('heading_title'),
					'href'	=> $this->url->link($route, $url, $this->request->server['HTTPS'])
				);
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
}