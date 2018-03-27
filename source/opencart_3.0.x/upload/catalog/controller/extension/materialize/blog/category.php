<?php
class ControllerExtensionMaterializeBlogCategory extends Controller {
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

			$blog_name = $blog[$this->config->get('config_language_id')]['name'];

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text'	=> $this->language->get('text_home'),
				'href'	=> $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text'	=> $blog_name,
				'href'	=> $this->url->link('extension/materialize/blog/blog')
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

				$blog_category_id = (int)array_pop($parts);

				foreach ($parts as $path_id) {
					if (!$path) {
						$path = (int)$path_id;
					} else {
						$path .= '_' . (int)$path_id;
					}

					$category_info = $this->model_extension_materialize_blog->getCategory($path_id);

					if ($category_info) {
						$data['breadcrumbs'][] = array(
							'text'	=> $category_info['name'],
							'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $path . $url)
						);
					}
				}
			} else {
				$blog_category_id = 0;
			}

			$category_info = $this->model_extension_materialize_blog->getCategory($blog_category_id);

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

				$data['color_snippet'] = $this->config->get('module_blog_color_snippet');
				$data['color_title'] = $this->config->get('module_blog_color_title');
				$data['color_tabs'] = $this->config->get('module_blog_color_tabs');
				$data['color_tabs_icon'] = $this->config->get('module_blog_color_tabs_indicator_hex');

				// Set the last category breadcrumb
				$data['breadcrumbs'][] = array(
					'text'	=> $category_info['name'],
					'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'])
				);

				if ($category_info['image']) {
					$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
				} else {
					$data['thumb'] = '';
				}

				$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');

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

				$data['categories'] = array();

				$results = $this->model_extension_materialize_blog->getCategories($blog_category_id);

				foreach ($results as $result) {
					$filter_data = array(
						'filter_blog_category_id'	=> $result['blog_category_id'],
						'filter_sub_category'		=> true
					);

					$data['categories'][] = array(
						'name'	=> $result['name'],
						'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'] . '_' . $result['blog_category_id'] . $url)
					);
				}

				$data['posts'] = array();

				$filter_data = array(
					'filter_blog_category_id'	=> $blog_category_id,
					'sort'						=> $sort,
					'order'						=> $order,
					'start'						=> ($page - 1) * $limit,
					'limit'						=> $limit
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
						'description'	=> utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
						'published'		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
						'href'			=> $this->url->link('extension/materialize/blog/post', 'blog_path=' . $this->request->get['blog_path'] . '&post_id=' . $result['post_id'] . $url)
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
					'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'] . '&sort=p.sort_order&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'	=> $this->language->get('text_name_asc'),
					'value'	=> 'pd.name-ASC',
					'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'] . '&sort=pd.name&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'	=> $this->language->get('text_name_desc'),
					'value'	=> 'pd.name-DESC',
					'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'] . '&sort=pd.name&order=DESC' . $url)
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
						'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'] . $url . '&limit=' . $value)
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
				$pagination->url = $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'] . $url . '&page={page}');

				$data['pagination'] = $pagination->render();

				$data['results'] = sprintf($this->language->get('text_pagination'), ($post_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($post_total - $limit)) ? $post_total : ((($page - 1) * $limit) + $limit), $post_total, ceil($post_total / $limit));

				if ($page == 1) {
					$this->document->addLink($this->url->link('extension/materialize/blog/category', 'blog_path=' . $category_info['blog_category_id']), 'canonical');
				} else {
					$this->document->addLink($this->url->link('extension/materialize/blog/category', 'blog_path=' . $category_info['blog_category_id'] . '&page='. $page), 'canonical');
				}

				if ($page > 1) {
					$this->document->addLink($this->url->link('extension/materialize/blog/category', 'blog_path=' . $category_info['blog_category_id'] . (($page - 2) ? '&page='. ($page - 1) : '')), 'prev');
				}

				if ($limit && ceil($post_total / $limit) > $page) {
					$this->document->addLink($this->url->link('extension/materialize/blog/category', 'blog_path=' . $category_info['blog_category_id'] . '&page='. ($page + 1)), 'next');
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
			} else {
				$url = '';

				if (isset($this->request->get['blog_path'])) {
					$url .= '&blog_path=' . $this->request->get['blog_path'];
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

				$data['breadcrumbs'][] = array(
					'text'	=> $this->language->get('text_error'),
					'href'	=> $this->url->link('extension/materialize/blog/category', $url)
				);

				$this->document->setTitle($this->language->get('text_error'));

				$data['continue'] = $this->url->link('common/home');

				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				$this->response->setOutput($this->load->view('error/not_found', $data));
			}
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