<?php
class ControllerExtensionMaterializeBlogAuthor extends Controller {
	public function index() {
		if ($this->config->get('module_blog_status') == 1) {
			$this->load->language('blog/author');

			$this->load->model('extension/materialize/blog');

			$this->load->model('tool/image');

			$this->document->setTitle($this->language->get('heading_title'));

			$blog = $this->config->get('module_blog');

			$blog_name = $blog[$this->config->get('config_language_id')]['name'];

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

			$data['breadcrumbs'][] = array(
				'text'	=> $this->language->get('text_authors'),
				'href'	=> $this->url->link('extension/materialize/blog/author')
			);

			$data['categories'] = array();

			$results = $this->model_extension_materialize_blog->getAuthors();

			foreach ($results as $result) {
				$name = $result['name'];

				if (is_numeric(utf8_substr($name, 0, 1))) {
					$key = '0 - 9';
				} else {
					$key = utf8_substr(utf8_strtoupper($name), 0, 1);
				}

				if (!isset($data['categories'][$key])) {
					$data['categories'][$key]['name'] = $key;
				}

				$data['categories'][$key]['author'][] = array(
					'name'	=> $name,
					'image'	=> $this->model_tool_image->resize($result['image'], 100, 100),
					'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $result['author_id'])
				);
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('blog/author_list', $data));
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

	public function info() {
		if ($this->config->get('module_blog_status') == 1) {
			$this->load->language('blog/author');

			$this->load->model('extension/materialize/blog');

			$this->load->model('tool/image');

			$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

			if (isset($this->request->get['author_id'])) {
				$author_id = (int)$this->request->get['author_id'];
			} else {
				$author_id = 0;
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

			$data['breadcrumbs'][] = array(
				'text'	=> $this->language->get('text_authors'),
				'href'	=> $this->url->link('extension/materialize/blog/author')
			);

			$author_info = $this->model_extension_materialize_blog->getAuthor($author_id);

			if ($author_info) {
				$this->document->setTitle($author_info['name']);

				$url = '';

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
					'text'	=> $author_info['name'],
					'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . $url)
				);

				if ($author_info['meta_title']) {
					$this->document->setTitle($author_info['meta_title']);
				} else {
					$this->document->setTitle($author_info['name']);
				}

				$this->document->setDescription($author_info['meta_description']);
				$this->document->setKeywords($author_info['meta_keyword']);

				if ($author_info['meta_h1']) {
					$data['heading_title'] = $author_info['meta_h1'];
				} else {
					$data['heading_title'] = $author_info['name'];
				}

				$data['color_snippet'] = $this->config->get('module_blog_color_snippet');
				$data['color_title'] = $this->config->get('module_blog_color_title');
				$data['color_tabs'] = $this->config->get('module_blog_color_tabs');
				$data['color_tabs_icon'] = $this->config->get('module_blog_color_tabs_indicator_hex');

				if ($author_info['image']) {
					$data['thumb'] = $this->model_tool_image->resize($author_info['image'], 150, 150, 'crop');
				} else {
					$data['thumb'] = '';
				}

				$data['description'] = html_entity_decode($author_info['description'], ENT_QUOTES, 'UTF-8');

				$data['posts'] = array();

				$filter_data = array(
					'filter_author_id'	=> $author_id,
					'sort'				=> $sort,
					'order'				=> $order,
					'start'				=> ($page - 1) * $limit,
					'limit'				=> $limit
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
						'author_image'	=> $this->model_tool_image->resize($result['author_image'], 56, 56),
						'name'			=> $result['name'],
						'description'	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
						'published'		=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
						'href'			=> $this->url->link('extension/materialize/blog/post', 'author_id=' . $result['author_id'] . '&post_id=' . $result['post_id'] . $url)
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
					'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=p.sort_order&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'	=> $this->language->get('text_name_asc'),
					'value'	=> 'pd.name-ASC',
					'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=pd.name&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'	=> $this->language->get('text_name_desc'),
					'value'	=> 'pd.name-DESC',
					'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . '&sort=pd.name&order=DESC' . $url)
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
						'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&limit=' . $value)
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
				$pagination->url = $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] .  $url . '&page={page}');

				$data['pagination'] = $pagination->render();

				$data['results'] = sprintf($this->language->get('text_pagination'), ($post_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($post_total - $limit)) ? $post_total : ((($page - 1) * $limit) + $limit), $post_total, ceil($post_total / $limit));

				if ($page == 1) {
					$this->document->addLink($this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'], true), 'canonical');
				} else {
					$this->document->addLink($this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&page='. $page, true), 'canonical');
				}

				if ($page > 1) {
					$this->document->addLink($this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&page='. (($page - 2) ? '&page='. ($page - 1) : ''), true), 'prev');
				}

				if ($limit && ceil($post_total / $limit) > $page) {
					$this->document->addLink($this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . $url . '&page='. ($page + 1), true), 'next');
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

				$this->response->setOutput($this->load->view('blog/author_info', $data));
			} else {
				$url = '';

				if (isset($this->request->get['author_id'])) {
					$url .= '&author_id=' . $this->request->get['author_id'];
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
					'href'	=> $this->url->link('extension/materialize/blog/author/info', $url)
				);

				$this->document->setTitle($this->language->get('text_error'));

				$data['continue'] = $this->url->link('common/home');

				$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

				$data['header'] = $this->load->controller('common/header');
				$data['footer'] = $this->load->controller('common/footer');
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');

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