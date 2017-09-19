<?php
class ControllerBlogPost extends Controller {
	private $error = array();

	public function index() {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->load->language('blog/post');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$this->load->model('blog/category');

		if (isset($this->request->get['blog_path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['blog_path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}

				$category_info = $this->model_blog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('blog/category', 'blog_path=' . $path)
					);
				}
			}

			$category_info = $this->model_blog_category->getCategory($category_id);

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
					'text' => $category_info['name'],
					'href' => $this->url->link('blog/category', 'blog_path=' . $this->request->get['blog_path'] . $url)
				);
			}
		}

		$this->load->model('blog/author');

		if (isset($this->request->get['author_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_author'),
				'href' => $this->url->link('blog/author')
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

			$author_info = $this->model_blog_author->getAuthor($this->request->get['author_id']);

			if ($author_info) {
				$data['breadcrumbs'][] = array(
					'text' => $author_info['name'],
					'href' => $this->url->link('blog/author/info', 'author_id=' . $this->request->get['author_id'] . $url)
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

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
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
				'text' => $this->language->get('text_search'),
				'href' => $this->url->link('blog/search', $url)
			);
		}

		if (isset($this->request->get['post_id'])) {
			$post_id = (int)$this->request->get['post_id'];
		} else {
			$post_id = 0;
		}

		$this->load->model('blog/post');

		$post_info = $this->model_blog_post->getPost($post_id);

		if ($post_info) {
			$url = '';

			if (isset($this->request->get['blog_path'])) {
				$url .= '&blog_path=' . $this->request->get['blog_path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
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
				'text' => $post_info['name'],
				'href' => $this->url->link('blog/post', $url . '&post_id=' . $this->request->get['post_id'])
			);

			if ($post_info['meta_title']) {
				$this->document->setTitle($post_info['meta_title']);
			} else {
				$this->document->setTitle($post_info['name']);
			}

			$mainCategory = $this->model_blog_post->getPostMainCategory($post_id);
			$this->document->setDescription($post_info['meta_description']);
			$this->document->setKeywords($post_info['meta_keyword']);
			$this->document->addLink($this->url->link('blog/post', 'blog_path=' . $mainCategory . 'post_id=' . $this->request->get['post_id']), 'canonical');

			if ($post_info['meta_h1']) {
				$data['heading_title'] = $post_info['meta_h1'];
			} else {
				$data['heading_title'] = $post_info['name'];
			}

			$data['text_select'] = $this->language->get('text_select');
			$data['text_author'] = $this->language->get('text_author');
			$data['text_published'] = $this->language->get('text_published');
			$data['text_write'] = $this->language->get('text_write');
			$data['text_note'] = $this->language->get('text_note');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['text_related'] = $this->language->get('text_related');
			$data['text_url'] = $this->language->get('text_url');
			$data['text_copy'] = $this->language->get('text_copy');
			$data['text_email_error'] = $this->language->get('text_email_error');
			$data['text_email_success'] = $this->language->get('text_email_success');
			$data['text_сlipboard_error'] = $this->language->get('text_сlipboard_error');
			$data['text_сlipboard_succeess'] = $this->language->get('text_сlipboard_succeess');
			$data['text_read_more'] = $this->language->get('text_read_more');
			$data['text_related'] = $this->language->get('text_related');

			$data['help_email'] = $this->language->get('help_email');

			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_comment'] = $this->language->get('entry_comment');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_share'] = $this->language->get('button_share');
			$data['button_pswp_close'] = $this->language->get('button_pswp_close');
			$data['button_pswp_toggle_fullscreen'] = $this->language->get('button_pswp_toggle_fullscreen');
			$data['button_pswp_zoom'] = $this->language->get('button_pswp_zoom');
			$data['button_pswp_prev'] = $this->language->get('button_pswp_prev');
			$data['button_pswp_next'] = $this->language->get('button_pswp_next');

			$data['post_id'] = (int)$this->request->get['post_id'];
			$data['author_link'] = $this->url->link('blog/author/info', 'author_id=' . $post_info['author_id']);
			$data['description'] = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');
			$data['published'] = date($this->language->get('date_format_short'), strtotime($post_info['date_added']));
			$data['meta_published'] = $post_info['date_added'];
			$data['meta_modified'] = $post_info['date_modified'];
			$data['viewed'] = $post_info['viewed'];
			$data['author'] = $post_info['author'];
			$data['publisher_org'] = $this->config->get('config_name');
			$data['lang'] = $this->language->get('code');
			
			$this->load->model('tool/image');

			if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
				list($data['logo_width'], $data['logo_height']) = getimagesize($data['logo']);
			} else {
				$data['logo'] = '';
			}

			$author_image = $this->model_blog_author->getAuthor($post_info['author_id']);

			if ($author_image) {
				$data['author_image'] = $this->model_tool_image->resize($author_image['image'], 32, 32);
				$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
			} else {
				$data['author_image'] = false;
			}

			// Authors
			$authors = $this->model_blog_post->getPostAuthors($post_id);

			$data['post_authors'] = array();

			foreach ($authors as $author) {
				$author_info = $this->model_blog_author->getAuthor($author['author_id']);

				if ($author_info) {
					$data['post_authors'][] = array(
						'name'	=> $author_info['name'],
						'image'	=> $this->model_tool_image->resize($author_info['image'], 32, 32),
						'href'	=> $this->url->link('blog/author/info', 'author_id=' . $author_info['author_id'])
					);
				}
			}

			if ($post_info['image']) {
				$data['post_image'] = $this->model_tool_image->resize($post_info['image'], 600, 400, 'crop');
				$data['post_image_width'] = 600;
				$data['post_image_height'] = 400;
			} else {
				$data['post_image'] = '';
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('comment', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$data['share'] = $this->url->link('blog/post', 'post_id=' . (int)$this->request->get['post_id']);

			$data['posts'] = array();

			$results = $this->model_blog_post->getPostRelated($this->request->get['post_id']);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resizeBlog($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				}

				$mainCategory = $this->model_blog_post->getPostMainCategory($result['post_id']);

				$data['posts'][] = array(
					'post_id'		=> $result['post_id'],
					'thumb'			=> $image,
					'name'			=> $result['name'],
					'author'		=> $result['author'],
					'description'	=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 150) . '..',
					'href'			=> $this->url->link('blog/post', 'blog_path=' . $mainCategory . 'post_id=' . $result['post_id'])
				);
			}

			$data['tags'] = array();

			if ($post_info['tag']) {
				$tags = explode(',', $post_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('blog/search', 'tag=' . trim($tag))
					);
				}
			}

			$this->model_blog_post->updateViewed($this->request->get['post_id']);

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

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
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

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
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
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('blog/post', $url . '&post_id=' . $post_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

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
	}

	public function comment() {
		$this->load->language('blog/post');

		$this->load->model('blog/comment');

		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
		$data['text_no_comments'] = $this->language->get('text_no_comments');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['comments'] = array();

		$comment_total = $this->model_blog_comment->getTotalCommentsByPostId($this->request->get['post_id']);

		$results = $this->model_blog_comment->getCommentsByPostId($this->request->get['post_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['comments'][] = array(
				'author'		=> $result['author'],
				'text'			=> nl2br($result['text']),
				'email'			=> $result['email'],
				'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('blog/post/comment', 'post_id=' . $this->request->get['post_id'] . '&page={page}');

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

			if (!preg_match($this->config->get('config_mail_regexp'), $this->request->post['email'])) {
				$json['error'] = $this->language->get('error_email');
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('comment', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('blog/comment');

				$this->model_blog_comment->addComment($this->request->get['post_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}