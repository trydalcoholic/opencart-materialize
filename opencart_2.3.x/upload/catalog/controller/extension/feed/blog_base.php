<?php
class ControllerFeedBlogBase extends Controller {
	public function index() {
		if ($this->config->get('blog_base_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0" xmlns:g="' . $this->config->get('config_url') . '">';
			$output .= '<channel>';
			$output .= '<title>' . $this->config->get('config_name') . '</title>';
			$output .= '<description>' . $this->config->get('config_meta_description') . '</description>';
			$output .= '<link>' . HTTP_SERVER . '</link>';

			$this->load->model('extension/feed/blog_base');
			$this->load->model('blog/category');
			$this->load->model('blog/post');

			$posts = $this->model_blog_post->getPosts();

			foreach ($posts as $post) {
				if ($post['description']) {
					$output .= '<item>';
					$output .= '<title>' . $post['title'] . '</title>';
					$output .= '<link>' . $this->url->link('blog/post', 'blog_post_id=' . $post['blog_post_id']) . '</link>';
					$output .= '<description>' . utf8_substr(strip_tags(html_entity_decode($post['description'], ENT_QUOTES, 'UTF-8')), 0, 500) . '..' . '</description>';
					$output .= '<g:id>' . $post['blog_post_id'] . '</g:id>';


					$categories = $this->model_blog_category->getCategoriesByPostId($post['blog_post_id']);

					if ($categories) {

						foreach ($categories as $category) {
							$output .= '<g:post_type>' . $category['name'] . '</g:post_type>';
						}
					}

					$output .= '</item>';
				}
			}

			$output .= '</channel>';
			$output .= '</rss>';

			$this->response->addHeader('Content-Type: application/rss+xml');
			$this->response->setOutput($output);
		}
	}

}