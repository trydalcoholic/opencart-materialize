<?php
class ControllerExtensionMaterializeBlogPost extends Controller {
	private $error = array();

	public function index() {
		if ($this->config->get('module_blog_status') == 1) {
			$this->load->language('blog/post');

			$this->load->model('extension/materialize/blog');

			$this->load->model('tool/image');

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
				$path = '';

				$parts = explode('_', (string)$this->request->get['blog_path']);

				$blog_category_id = (int)array_pop($parts);

				foreach ($parts as $path_id) {
					if (!$path) {
						$path = $path_id;
					} else {
						$path .= '_' . $path_id;
					}

					$category_info = $this->model_extension_materialize_blog->getCategory($path_id);

					if ($category_info) {
						$data['breadcrumbs'][] = array(
							'text'	=> $category_info['name'],
							'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $path)
						);
					}
				}

				// Set the last category breadcrumb
				$category_info = $this->model_extension_materialize_blog->getCategory($blog_category_id);

				if ($category_info) {
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
						'text'	=> $category_info['name'],
						'href'	=> $this->url->link('extension/materialize/blog/category', 'blog_path=' . $this->request->get['blog_path'] . $url)
					);
				}
			}

			if (isset($this->request->get['author_id'])) {
				$data['breadcrumbs'][] = array(
					'text'	=> $this->language->get('text_author'),
					'href'	=> $this->url->link('extension/materialize/blog/author')
				);

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

				$author_info = $this->model_extension_materialize_blog->getAuthor($this->request->get['author_id']);

				if ($author_info) {
					$data['breadcrumbs'][] = array(
						'text'	=> $author_info['name'],
						'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $this->request->get['author_id'] . $url)
					);
				}
			}

			if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
				$url = '';

				if (isset($this->request->get['search'])) {
					$url .= '&search=' . $this->request->get['search'];
				}

				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . $this->request->get['tag'];
				}

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				if (isset($this->request->get['blog_category_id'])) {
					$url .= '&blog_category_id=' . $this->request->get['blog_category_id'];
				}

				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
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
					'text'	=> $this->language->get('text_search'),
					'href'	=> $this->url->link('extension/materialize/blog/search', $url)
				);
			}

			if (isset($this->request->get['post_id'])) {
				$post_id = (int)$this->request->get['post_id'];
			} else {
				$post_id = 0;
			}

			$post_info = $this->model_extension_materialize_blog->getPost($post_id);

			if ($post_info) {
				$url = '';

				if (isset($this->request->get['blog_path'])) {
					$url .= '&blog_path=' . $this->request->get['blog_path'];
				}

				if (isset($this->request->get['author_id'])) {
					$url .= '&author_id=' . $this->request->get['author_id'];
				}

				if (isset($this->request->get['search'])) {
					$url .= '&search=' . $this->request->get['search'];
				}

				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . $this->request->get['tag'];
				}

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				if (isset($this->request->get['blog_category_id'])) {
					$url .= '&blog_category_id=' . $this->request->get['blog_category_id'];
				}

				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
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
					'text'	=> $post_info['name'],
					'href'	=> $this->url->link('extension/materialize/blog/post', $url . '&post_id=' . $this->request->get['post_id'])
				);

				if (empty($post_info['meta_title'])) {
					$post_info['meta_title'] = $post_info['name'];
				}

				$this->document->setTitle($post_info['meta_title']);
				$this->document->setDescription($post_info['meta_description']);
				$this->document->setKeywords($post_info['meta_keyword']);
				$this->document->addLink($this->url->link('extension/materialize/blog/post', 'post_id=' . $this->request->get['post_id']), 'canonical');

				if (empty($post_info['meta_h1'])) {
					$data['heading_title'] = $post_info['name'];
				} else {
					$data['heading_title'] = $post_info['meta_h1'];
				}

				$data['post_id'] = (int)$this->request->get['post_id'];
				$data['description'] = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');
				$data['published'] = date($this->language->get('date_format_short'), strtotime($post_info['date_added']));
				$data['meta_published'] = $post_info['date_added'];
				$data['meta_modified'] = $post_info['date_modified'];
				$data['publisher_org'] = $this->config->get('config_name');
				$data['lang'] = $this->language->get('code');

				if ($this->config->get('module_blog_views_status') == 1) {
					$data['viewed'] = $post_info['viewed'];
				} else {
					$data['viewed'] = '';
				}

				if ($this->config->get('module_blog_link_status') == 1) {
					$data['link_share'] = true;
				} else {
					$data['link_share'] = false;
				}

				if ($post_info['image']) {
					$data['post_image'] = $this->model_tool_image->resize($post_info['image'], 1000, 800, 'crop');
					$data['post_image_width'] = 1000;
					$data['post_image_height'] = 800;
				} else {
					$data['post_image'] = '';
				}

				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}

				if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
					$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
					list($data['logo_width'], $data['logo_height']) = getimagesize($data['logo']);
				} else {
					$data['logo'] = '';
				}

				$data['author'] = $post_info['author'];
				$data['author_link'] = $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $post_info['author_id']);

				$author_image = $this->model_extension_materialize_blog->getAuthor($post_info['author_id']);

				if ($author_image) {
					$data['author_image'] = $this->model_tool_image->resize($author_image['image'], 32, 32);
					$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
				} else {
					$data['author_image'] = false;
				}

				// Authors
				$authors = $this->model_extension_materialize_blog->getPostAuthors($post_id);

				$data['post_authors'] = array();

				foreach ($authors as $author) {
					$author_info = $this->model_extension_materialize_blog->getAuthor($author['author_id']);

					if ($author_info) {
						$data['post_authors'][] = array(
							'name'	=> $author_info['name'],
							'image'	=> $this->model_tool_image->resize($author_info['image'], 32, 32),
							'href'	=> $this->url->link('extension/materialize/blog/author/info', 'author_id=' . $author_info['author_id'])
						);
					}
				}

				if ($this->config->get('module_blog_comment_status') == 1) {
					if ($post_info['comment_status'] == 1) {
						$data['comment_status'] = true;

						if ($this->config->get('module_blog_config_captcha')) {
							$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('module_blog_config_captcha'));
						} else {
							$data['captcha'] = '';
						}
					} else {
						$data['comment_status'] = false;
					}
				} else {
					$data['comment_status'] = false;
					$data['captcha'] = '';
				}

				$data['share'] = $this->url->link('extension/materialize/blog/post', 'post_id=' . (int)$this->request->get['post_id']);

				$data['posts'] = array();

				$results = $this->model_extension_materialize_blog->getPostRelated($this->request->get['post_id']);

				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], 150, 300);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', 150, 300);
					}

					$data['posts'][] = array(
						'post_id'		=> $result['post_id'],
						'thumb'			=> $image,
						'name'			=> $result['name'],
						'description'	=> utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100) . '..',
						'href'			=> $this->url->link('extension/materialize/blog/post', 'post_id=' . $result['post_id'])
					);
				}

				$data['tags'] = array();

				if ($post_info['tag']) {
					$tags = explode(',', $post_info['tag']);

					foreach ($tags as $tag) {
						$data['tags'][] = array(
							'tag'	=> trim($tag),
							'href'	=> $this->url->link('extension/materialize/blog/search', 'tag=' . trim($tag))
						);
					}
				}

				$this->model_extension_materialize_blog->updateViewed($this->request->get['post_id']);

				$data['column_left'] = $this->load->controller('common/column_left');
				$data['column_right'] = $this->load->controller('common/column_right');
				$data['content_top'] = $this->load->controller('common/content_top');
				$data['content_bottom'] = $this->load->controller('common/content_bottom');
				$data['footer'] = $this->load->controller('common/footer');
				$data['header'] = $this->load->controller('common/header');

				$this->response->setOutput($this->load->view('blog/post', $data));
			} else {
				$url = '';

				if (isset($this->request->get['blog_path'])) {
					$url .= '&blog_path=' . $this->request->get['blog_path'];
				}

				if (isset($this->request->get['author_id'])) {
					$url .= '&author_id=' . $this->request->get['author_id'];
				}

				if (isset($this->request->get['search'])) {
					$url .= '&search=' . $this->request->get['search'];
				}

				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . $this->request->get['tag'];
				}

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				if (isset($this->request->get['blog_category_id'])) {
					$url .= '&blog_category_id=' . $this->request->get['blog_category_id'];
				}

				if (isset($this->request->get['sub_category'])) {
					$url .= '&sub_category=' . $this->request->get['sub_category'];
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
					'href'	=> $this->url->link('extension/materialize/blog/post', $url . '&post_id=' . $post_id)
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

	public function comment() {
		$this->load->language('blog/post');

		$this->load->model('extension/materialize/blog');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
		$data['text_no_comments'] = $this->language->get('text_no_comments');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['comments'] = array();

		$comment_total = $this->model_extension_materialize_blog->getTotalCommentsByPostId($this->request->get['post_id']);

		$results = $this->model_extension_materialize_blog->getCommentsByPostId($this->request->get['post_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['comments'][] = array(
				'author'		=> $result['author'],
				'text'			=> nl2br($result['text']),
				'email'			=> $result['email'],
				'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new MaterializePagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('extension/materialize/blog/post/comment', 'post_id=' . $this->request->get['post_id'] . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($comment_total - 5)) ? $comment_total : ((($page - 1) * 5) + 5), $comment_total, ceil($comment_total / 5));

		$this->response->setOutput($this->load->view('blog/comment', $data));
	}

	public function write() {
		$this->load->language('blog/post');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}

			if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
				$json['error'] = $this->language->get('error_email');
			}

			// Captcha
			if ($this->config->get('module_blog_config_captcha')) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('module_blog_config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/materialize/blog');

				$this->model_extension_materialize_blog->addComment($this->request->get['post_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}