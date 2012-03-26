<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Savepdf extends Public_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->load->library('savepdf_lib');

    }
	
	/**
	 * Catch all requests to this page in one mega-function
	 * @access public
	 * @param string $method The method to call
	 * @return void
	 */
	public function index()
	{
		// This page has been routed to with pages/view/whatever
		/*if ($this->uri->rsegment(1, '') == 'savepdf')
		{
			$url_segments = $this->uri->total_rsegments() > 0 ? array_slice($this->uri->rsegment_array(), 1) : null;
		}
		
		// not routed, so use the actual URI segments
		else
		{*/
			//$url_segments = $this->uri->total_segments() > 1 ? $this->uri->segment_array() : null;
		//}
		
		if (isset($_GET['page'])) {
			$url_segments = explode('/',$_GET['page']);
			// If it has .rss on the end then parse the RSS feed
			if ($url_segments){
				$this->_page($url_segments);
			}
		}
		elseif (isset($_GET['blog'])) {
			$this->_blog($_GET['blog']);
			
		}
	}

	/**
	 * Page method
	 * @access public
	 * @param array $url_segments The URL segments
	 * @return void
	 */
	// Public: View a post
	public function _blog($slug = '')
	{
		$this->load->model('blog/blog_m');

		if ( ! $slug or ! $post = $this->blog_m->get_by('slug', $slug))
		{
			redirect('blog');
		}

		if ($post->status != 'live' && ! $this->ion_auth->is_admin())
		{
			redirect('blog');
		}
		
		// if it uses markdown then display the parsed version
		if ($post->type == 'markdown')
		{
			$post->body = $post->parsed;
		}

		// IF this post uses a category, grab it
		if ($post->category_id && ($category = $this->blog_categories_m->get($post->category_id)))
		{
			$post->category = $category;
		}

		// Set some defaults
		else
		{
			$post->category->id		= 0;
			$post->category->slug	= '';
			$post->category->title	= '';
		}

		$this->session->set_flashdata(array('referrer' => $this->uri->uri_string));

		$this->template->title($post->title, lang('blog_blog_title'));
		$post->url = site_url('blog/'.date('Y', $post->created_on).'/'.date('m', $post->created_on).'/'.$post->slug);
		
		// No layout
		$this->template->set_layout('');
		
		$body = $this->template
			->set_breadcrumb($post->title)
			->set('post', $post)
			->build('blog', $this->data, TRUE);
		$this->savepdf_lib->load($body, $post->title);
	}

	public function _page($url_segments)
	{
		$this->load->model('pages/page_m');

		$page = $url_segments !== NULL
		
			// Fetch this page from the database via cache
			? $this->pyrocache->model('page_m', 'get_by_uri', array($url_segments))

			: $this->pyrocache->model('page_m', 'get_home');
			

		// If page is missing or not live (and not an admin) show 404
		if ( ! $page OR ($page->status == 'draft' AND ( ! isset($this->current_user->group) OR $this->current_user->group != 'admin')))
		{
			// Load the '404' page. If the actual 404 page is missing (oh the irony) bitch and quit to prevent an infinite loop.
			if ( ! ($page = $this->pyrocache->model('page_m', 'get_by_uri', array('404'))))
			{
				show_error('The page you are trying to view does not exist and it also appears as if the 404 page has been deleted.');
			}
		}
		
		// If this is a homepage, do not show the slug in the URL
		if ($page->is_home and $url_segments)
		{
			//redirect('', 'location', 301);
		}

		// If the page is missing, set the 404 status header
		if ($page->slug == '404')
		{
			return false;
		}
		
		// Nope, it's a page but do they have access?
		elseif ($page->restricted_to)
		{
			$page->restricted_to = (array) explode(',', $page->restricted_to);

			// Are they logged in and an admin or a member of the correct group?
			if ( ! $this->current_user OR (isset($this->current_user->group) AND $this->current_user->group != 'admin' AND ! in_array($this->current_user->group_id, $page->restricted_to)))
			{
				//Restricted
				return false;
			}
		}

		// Don't worry about breadcrumbs for 404 or restricted
		elseif (count($url_segments) > 1)
		{
			// we dont care about the last one
			array_pop($url_segments);


			// This array of parents in the cache?
			if ( ! $parents = $this->pyrocache->get('page_m/'.md5(implode('/', $url_segments))))
			{
				$parents = $breadcrumb_segments = array();

				foreach ($url_segments as $segment)
				{
					$breadcrumb_segments[] = $segment;

					$parents[] = $this->pyrocache->model('page_m', 'get_by_uri', array($breadcrumb_segments));
				}
				// Cache for next time
				$this->pyrocache->write($parents, 'page_m/'.md5(implode('/', $url_segments)));
			}
		}
		
	
		// No layout
		$this->template->set_layout('');

		// Grab all the chunks that make up the body
		$page->chunks = $this->db->order_by('sort')
			->get_where('page_chunks', array('page_id' => $page->id))
			->result();
		
		$chunk_html = '';
		foreach ($page->chunks as $chunk)
		{
			$chunk_html .= 	'<div class="page-chunk '.$chunk->slug.'">' .
						'<div class="page-chunk-pad">' .
								(($chunk->type == 'markdown') ? $chunk->parsed : $chunk->body) .
						'</div>' .
					'</div>'.PHP_EOL;
		}
		
		
		// Parse it so the content is parsed. We pass along $page so that {{ page:id }} and friends work in page content
		$page->body = $this->parser->parse_string(str_replace(array('&#39;', '&quot;'), array("'", '"'), $chunk_html), array('theme' => $this->theme, 'page' => $page), TRUE);
		$body = $this->template
			->set_breadcrumb($page->title)
			->set('page', $page)
			->build('page', $this->data, TRUE);

		$this->savepdf_lib->load($page->body, $page->title);
	}
}