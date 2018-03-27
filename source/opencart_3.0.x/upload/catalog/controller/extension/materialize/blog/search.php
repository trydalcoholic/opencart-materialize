<?php
class ControllerExtensionMaterializeBlogSearch extends Controller {
	public function index() {
		if ($this->config->get('module_blog_status') == 1) {
			$this->load->language('blog/search');

			$this->load->model('extension/materialize/blog');

			$this->load->model('tool/image');

			if (isset($this->request->get['blog_search'])) {
				$blog_search = $this->request->get['blog_search'];
			} else {
				$blog_search = '';
			}

			if (isset($this->request->get['tag'])) {
				$tag = $this->request->get['tag'];
			} elseif (isset($this->request->get['blog_search'])) {
				$tag = $this->request->get['blog_search'];
			} else {
				$tag = '';
			}

			if (isset($this->request->get['description'])) {
				$description = $this->request->get['description'];
			} else {
				$description = '';
			}

			if (isset($this->request->get['blog_category_id'])) {
				$blog_category_id = $this->request->get['blog_category_id'];
			} else {
				$blog_category_id = 0;
			}

			if (isset($this->request->get['sub_category'])) {
				$sub_category = $this->request->get['sub_category'];
			} else {
				$sub_category = '';
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

			if (isset($this->request->get['blog_search'])) {
				$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['blog_search']);
			} elseif (isset($this->request->get['tag'])) {
				$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
			} else {
				$this->document->setTitle($this->language->get('heading_title'));
			}

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

			$url = '';

			if (isset($this->request->get['blog_search'])) {
				$url .= '&blog_search=' . urlencode(html_entity_decode($this->request->get['blog_search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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
				'text'	=> $this->language->get('heading_title'),
				'href'	=> $this->url->link('extension/materialize/blog/search', $url)
			);

			if (isset($this->request->get['blog_search'])) {
				$data['heading_title'] = $this->language->get('heading_title') .  ' - ' . $this->request->get['blog_search'];
			} else {
				$data['heading_title'] = $this->language->get('heading_title');
			}

			// 3 Level Category Search
			$data['categories'] = array();

			$categories_1 = $this->model_extension_materialize_blog->getCategories(0);

			foreach ($categories_1 as $category_1) {
				$level_2_data = array();

				$categories_2 = $this->model_extension_materialize_blog->getCategories($category_1['blog_category_id']);

				foreach ($categories_2 as $category_2) {
					$level_3_data = array();

					$categories_3 = $this->model_extension_materialize_blog->getCategories($category_2['blog_category_id']);

					foreach ($categories_3 as $category_3) {
						$level_3_data[] = array(
							'blog_category_id'	=> $category_3['blog_category_id'],
							'name'			=> $category_3['name'],
						);
					}

					$level_2_data[] = array(
						'blog_category_id'	=> $category_2['blog_category_id'],
						'name'			=> $category_2['name'],
						'children'		=> $level_3_data
					);
				}

				$data['categories'][] = array(
					'blog_category_id'	=> $category_1['blog_category_id'],
					'name'			=> $category_1['name'],
					'children'		=> $level_2_data
				);
			}


			$data['color_snippet'] = $this->config->get('module_blog_color_snippet');
			$data['color_title'] = $this->config->get('module_blog_color_title');
			$data['color_tabs'] = $this->config->get('module_blog_color_tabs');
			$data['color_tabs_icon'] = $this->config->get('module_blog_color_tabs_indicator_hex');

			$data['posts'] = array();

			if (isset($this->request->get['blog_search']) || isset($this->request->get['tag'])) {
				$filter_data = array(
					'filter_name'			=> $blog_search,
					'filter_tag'			=> $tag,
					'filter_description'	=> $description,
					'filter_category_id'	=> $blog_category_id,
					'filter_sub_category'	=> $sub_category,
					'sort'					=> $sort,
					'order'					=> $order,
					'start'					=> ($page - 1) * $limit,
					'limit'					=> $limit
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
						'href'			=> $this->url->link('extension/materialize/blog/post', 'post_id=' . $result['post_id'] . $url)
					);
				}

				$url = '';

				if (isset($this->request->get['blog_search'])) {
					$url .= '&blog_search=' . urlencode(html_entity_decode($this->request->get['blog_search'], ENT_QUOTES, 'UTF-8'));
				}

				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$data['sorts'] = array();

				$data['sorts'][] = array(
					'text'	=> $this->language->get('text_default'),
					'value'	=> 'p.sort_order-ASC',
					'href'	=> $this->url->link('extension/materialize/blog/search', 'sort=p.sort_order&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'	=> $this->language->get('text_name_asc'),
					'value'	=> 'pd.name-ASC',
					'href'	=> $this->url->link('extension/materialize/blog/search', 'sort=pd.name&order=ASC' . $url)
				);

				$data['sorts'][] = array(
					'text'	=> $this->language->get('text_name_desc'),
					'value'	=> 'pd.name-DESC',
					'href'	=> $this->url->link('extension/materialize/blog/search', 'sort=pd.name&order=DESC' . $url)
				);

				$url = '';

				if (isset($this->request->get['blog_search'])) {
					$url .= '&blog_search=' . urlencode(html_entity_decode($this->request->get['blog_search'], ENT_QUOTES, 'UTF-8'));
				}

				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

				$data['limits'] = array();

				$limits = array_unique(array($this->config->get('module_blog_post_limit'), 36, 54, 72, 90));

				sort($limits);

				foreach($limits as $value) {
					$data['limits'][] = array(
						'text'	=> $value,
						'value'	=> $value,
						'href'	=> $this->url->link('extension/materialize/blog/search', $url . '&limit=' . $value)
					);
				}

				$url = '';

				if (isset($this->request->get['blog_search'])) {
					$url .= '&blog_search=' . urlencode(html_entity_decode($this->request->get['blog_search'], ENT_QUOTES, 'UTF-8'));
				}

				if (isset($this->request->get['tag'])) {
					$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
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

				if (isset($this->request->get['limit'])) {
					$url .= '&limit=' . $this->request->get['limit'];
				}

				$pagination = new MaterializePagination();
				$pagination->total = $post_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('extension/materialize/blog/search', $url . '&page={page}');

				$data['pagination'] = $pagination->render();

				$data['results'] = sprintf($this->language->get('text_pagination'), ($post_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($post_total - $limit)) ? $post_total : ((($page - 1) * $limit) + $limit), $post_total, ceil($post_total / $limit));
			}

			$data['blog_search'] = $blog_search;
			$data['description'] = $description;
			$data['blog_category_id'] = $blog_category_id;
			$data['sub_category'] = $sub_category;

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('blog/search', $data));
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