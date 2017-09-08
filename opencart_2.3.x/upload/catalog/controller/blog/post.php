<?php
class ControllerBlogPost extends Controller {
	public function index() {
		$data['img_loader'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->load->language('blog/post');

		$this->load->model('blog/post');

		$this->load->model('tool/image');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_blog'),
			'href' => $this->url->link('blog/category')
		);

		if (isset($this->request->get['blog_post_id'])) {
			$data['blog_post_id'] = $blog_post_id = (int)$this->request->get['blog_post_id'];
		} else {
			$data['blog_post_id'] = $blog_post_id = 0;
		}

		$post_info = $this->model_blog_post->getPost($blog_post_id);

		if ($post_info) {
			$post_info['date_added'] = date_create($post_info['date_added']);
			$post_info['date_modified'] = date_create($post_info['date_modified']);

			$this->document->setTitle($post_info['meta_title']);
			$this->document->setDescription($post_info['meta_description']);
			$this->document->setKeywords($post_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $post_info['title'],
				'href' => $this->url->link('blog/post', 'blog_post_id=' .  $blog_post_id)
			);

			$data['heading_title'] = $post_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['post_author'] = $post_info['author'];
			$data['post_published'] = date_format($post_info['date_added'], 'd.m.Y');
			$data['post_published_meta'] = date_format($post_info['date_added'], 'Y-m-d H:i:s');
			$data['description'] = html_entity_decode($post_info['description'], ENT_QUOTES, 'UTF-8');
			$data['share'] = $this->url->link('blog/post', 'blog_post_id=' . (int)$this->request->get['blog_post_id']);
			$data['post_publisher_org'] = $this->config->get('config_name');
			$data['lang'] = $this->language->get('code');


			$data['text_write'] = $this->language->get('text_write');
			$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
			$data['text_note'] = $this->language->get('text_note');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['help_email'] = $this->language->get('help_email');
			$data['text_tags'] = $this->language->get('text_tags');
			$data['button_pswp_close'] = $this->language->get('button_pswp_close');
			$data['button_pswp_toggle_fullscreen'] = $this->language->get('button_pswp_toggle_fullscreen');
			$data['button_pswp_zoom'] = $this->language->get('button_pswp_zoom');
			$data['button_pswp_prev'] = $this->language->get('button_pswp_prev');
			$data['button_pswp_next'] = $this->language->get('button_pswp_next');
			$data['button_share'] = $this->language->get('button_share');

			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_comment'] = $this->language->get('entry_comment');
			$data['text_email_error'] = $this->language->get('text_email_error');
			$data['text_email_success'] = $this->language->get('text_email_success');

			$data['continue'] = $this->url->link('common/home');

			if ($post_info['date_modified']) {
				$data['post_modified_meta'] = date_format($post_info['date_modified'], 'Y-m-d H:i:s');
			} else {
				$data['post_modified_meta'] = date_format($post_info['date_added'], 'Y-m-d H:i:s');
			}

			if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
				list($data['logo_width'], $data['logo_height']) = getimagesize($data['logo']);
			} else {
				$data['logo'] = '';
			}

			if ($post_info['image']) {
				$data['post_popup'] = $this->model_tool_image->resizeBlog($post_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
				$data['data_size'] = $this->config->get($this->config->get('config_theme') . '_image_popup_width') . 'x' . $this->config->get($this->config->get('config_theme') . '_image_popup_height');
				$data['data_size_width'] = $this->config->get($this->config->get('config_theme') . '_image_popup_width');
				$data['data_size_height'] = $this->config->get($this->config->get('config_theme') . '_image_popup_height');
			} else {
				$data['post_popup'] = '';
			}

			if ($post_info['image']) {
				$data['post_preview'] = $this->model_tool_image->resize($post_info['image'], 600, 400, 'crop');
			} else {
				$data['post_preview'] = '';
			}

			if ($post_info['image']) {
				$data['post_thumb'] = $this->model_tool_image->resize($post_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
			} else {
				$data['post_thumb'] = '';
			}


			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('comment', (array)$this->config->get('config_captcha_page'))) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
			} else {
				$data['captcha'] = '';
			}

			$data['tags'] = array();

			if ($post_info['tag']) {
				$tags = explode(',', $post_info['tag']);

				foreach ($tags as $tag) {
					$data['tags'][] = array(
						'tag'  => trim($tag),
						'href' => $this->url->link('blog/category', 'filter_title=' . trim($tag))
					);
				}
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('blog/post', $data));
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('blog/post', 'blog_post_id=' . $blog_post_id)
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

		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_no_comments'] = $this->language->get('text_no_comments');


		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['comments'] = array();

		$comment_total = $this->model_blog_comment->getTotalCommentsByPostId($this->request->get['blog_post_id']);

		$results = $this->model_blog_comment->getCommentsByPostId($this->request->get['blog_post_id'], ($page - 1) * 5, 5);

		foreach ($results as $result) {
			$data['comments'][] = array(
				'author'     => $result['author'],
				'text'       => nl2br($result['text']),
				'date_added' => date_create($result['date_added'])
			);
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->url = $this->url->link('blog/post/comment', 'blog_post_id=' . $this->request->get['blog_post_id'] . '&page={page}');

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

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
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

				$this->model_blog_comment->addComment($this->request->get['blog_post_id'], $this->request->post);

				$json['success'] = $this->language->get('text_success');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}