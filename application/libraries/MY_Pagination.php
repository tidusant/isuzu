<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination{

var $CI;
var $uri_segment_name = "trang";
var $force_url = false;

    public function __construct()
    {
		$this->CI = & get_instance();
         parent::__construct();
    }

	// --------------------------------------------------------------------

	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */
	function create_links()
	{
		// If our item count or per-page total is zero there is no need to continue.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   return '';
		}

		// Calculate the total number of pages
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Is there only one page? Hm... nothing more to do here then.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determine the current page number.

		if ($this->segment_value() != 0)
		{
			$this->cur_page = $this->segment_value();

			// Prep the current page - no funny business!
			$this->cur_page = preg_replace("/[a-z\-]/", "", $this->cur_page);
		}

		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}

		// Is the page number beyond the result range?
		// If so we show the last page
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}

		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calculate the start and end numbers. These determine
		// which number to start and end the digit links with
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Add a trailing slash to the base URL if needed
		$this->base_url = preg_replace("/(.+?)\/*$/", "\\1/",  $this->base_url);

  		// And here we go...
		$output = '';

		// Render the "First" link
		if  ($this->cur_page > $this->num_links)
		{
			$output .= $this->first_tag_open.'<a href="'.$this->get_url().'">'.$this->first_link.'</a>'.$this->first_tag_close;
		}

		// Render the "previous" link
		if  (($this->cur_page - $this->num_links) >= 0)
		{
			$i = $uri_page_number - $this->per_page;
			if ($i == 0) $i = '';
			$output .= $this->prev_tag_open.'<a href="'.$this->get_url($i).'">'.$this->prev_link.'</a>'.$this->prev_tag_close;
		}

		// Write the digit links
		// for ($loop = $start -1; $loop <= $end; $loop++) hoac for ($loop = $end; $loop >= $start -1; $loop--)
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = ($loop * $this->per_page) - $this->per_page;

			if ($i >= 0)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Current page
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->num_tag_open.'<a href="'.$this->get_url($i).'">'.$loop.'</a>'.$this->num_tag_close;
				}
			}
		}

		// Render the "next" link
		if ($this->cur_page < $num_pages)
		{
			$output .= $this->next_tag_open.'<a href="'.$this->get_url($this->cur_page * $this->per_page).'">'.$this->next_link.'</a>'.$this->next_tag_close;
		}

		// Render the "Last" link
		if (($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);
			$output .= $this->last_tag_open.'<a href="'.$this->get_url($i).'">'.$this->last_link.'</a>'.$this->last_tag_close;
		}

		// Kill double slashes.  Note: Sometimes we can end up with a double slash
		// in the penultimate link so we'll kill all double slashes.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Add the wrapper HTML if exists
		$output = $this->full_tag_open.$output.$this->full_tag_close;

		return $output;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Generate the pagintion url
	 * @param   string
	 * @access	public
	 * @return	string
	 */
	 	
	function get_url($count = 0){
	$segments   = $this->CI->uri->segment_array();

	$segments_n = count($segments);
		$url = "";
		if($this->force_url != "" OR $segments_n < 3){ // whatever! as you like!
				if($count > 0) // yes we have some results
					$url = "/" . $this->uri_segment_name . "/" .$count;
				else // no results lets delete the Page segment and value! instead of empty number! "home/Page/"
					$url = "";		
		}
		
		if($this->force_url != "") // whatever! as you like!
				return $this->force_url  . $url;
		elseif(strlen($this->CI->uri->uri_string()) < strlen($this->base_url)) // ohh! base_method isn't found we are on the controller!
				return site_url( $this->base_url . $url);
			//echo $this->CI->uri->uri_string();

	// lets search for our Page segment,
	$segment_n = array_search($this->uri_segment_name, $segments) + 1;
	// now change its value;
	if($count > 0){ // yes we have some results
		if($segment_n > 1)
		 $segments[$segment_n] = $count;
		 else{ // ahh segment not found, lets add it!
		 $segments[] = $this->uri_segment_name;
		 $segments[] = $count;
		 }
	}else{ // no results lets delete the Page segment and value! instead of empty number! "home/Page/"
		unset($segments[$segment_n]);
		unset($segments[$segment_n -1 ]);
	}
	// finally build our url again;
	$uri_segments = implode("/" , $segments);
  	return site_url($uri_segments);
		
	}

	// --------------------------------------------------------------------

	/**
	 * Return the pagination segment value
     *
	 * @access	public
	 * @return	string
	 */
	 	
	function segment_value(){
		$segments = $this->CI->uri->segment_array();
		//print_r($segments);die();
		$this->uri_segment = array_search($this->uri_segment_name, $segments) + 1;
		$value = ($segments[$this->uri_segment] AND $this->uri_segment > 1) ? $segments[$this->uri_segment] : '0';
		return $value;
	}

}	

?>