<?Php
/**
 *```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 *	CLASS: MyPagination
 *	AUTHOR: Romil Jayme
 *	COUNTRY: Philippines
 *	EMAIL: jmill85@gmail.com
 * 	LINK: http://www.phpclasses.org/package/7159-PHP-Display-links-for-browsing-database-query-results.html
 *```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 *	VERSION : 1.1 (Updated 10/22/2015)
 *	DESCRIPTION:
 *		-	Fully Customizable Pagination
 *		-	
 *		-	Displays three types of pagination (basic, page numbers, drop down)
 *		-	NOTE: 
 *		-	this class uses "page" as the default GET variable name ($_GET['page'])
 *		-	you can override the variable name by calling "setgetvar($newname)"
 *		-	and assigned a new variable name ex. setgetvar("pg");
 *```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 *		-	1) previous | next 
 *					FUNCTION : page_nextprev($_offset, $total_results, $_page, $next='next', $prev='prev') 
 *
 * *				Call "page_nextprev" method to display basic next and previous pagination
 * *				Parameters:
 * *					a) $_offset - total number of rows displayed per page
 * *					b) $total_results - total query results
 * *					c) $_page - current page number
 * *					d) $next - text/html, default "next"
 * *					e) $prev - text/html, default "prev"
 *
 * *				Returned values: array variable
 * *					indexes:
 * *					a) limit - ex. "LIMIT 1, 5"
 * *					b) prev - previous link
 * *					c) next - next link
 * *					d) default - the default pagination display
 * *					e) begin_rec - the starting count of the page result ex. page is 2, offset is 10 the the starting count of the result is 11
 * *					f) end_rec - the end count of the page result ex. page is 2, offset is 10 the the end count of the result is 20
 * *					g) total-rec - query total results (total number of records)
 *```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 *		-	2) prev | 1 2 3 4 5 | next
 *					FUNCTION : page_series($_offset, $total_results, $_page, $page_numbers = 5, $next='next', $prev='prev')
 *
 * *				Call "page_series" method to display a series of number pagination
 * *				Parameters:
 * *					all are the same with number 1 except 
 * *					*) $page_numbers - maximum numbers at the left and right of the current page ex. page is 7 then display is 2 3 4 5 6 7 8 9 10 11 12
 *
 * *				Returned values: array variable
 * *					indexes:
 * *					all are the same with number 1 plus 
 * *					*) pages - the series of page numbers
 *```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 *		-	3) drop down field
 *					FUNCTION : page_selectField($_offset, $total_results, $_page, $next='next', $prev='prev')
 *
 * *				Call "page_selectField" method to display a drop down field pagination
 * *				Parameters:
 * *					all are the same with number 1  
 *
 * *				Returned values: array variable
 * *					indexes:
 * *					all are the same with number 2 
 * *					*) pages - the select drop down field *```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 * *		SAMPLE USAGE:
 * 
 * *				$offset = 4; // number of rows per page
 *					$sql = "SELECT * FROM users";
 *					$query = mysql_query($sql);
 *					$total_results = mysql_num_rows($query);
 *
 * *				$pg = new MyPagination();
 *					$result = $pg->page_nextprev($offset, $total_results, $_GET['page']);
 *					
 * *				$sql1 = "SELECT * FROM users ".$result['limit'];
 *					$query1 = mysql_query($sql1);
 *					$page_results = mysql_num_rows($query1);
 * *
 *					while ($row = mysql_fetch_array($query1)) {
 *						echo $row['id_user'].' => '.$row['user_name'];
 *						echo '<br />';
 *					}
 *
 * *				echo $result['default']; 
**```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 *		-	4) Number Series
 *					FUNCTION : number_series($_offset, $total_results, $_page, $next='next', $prev='prev')
 *
 * *				Call "number_series" method to display a series of range pagination
 * *				Parameters:
 * *					all are the same with number 1  
 *
 * *				Returned values: array variable
 * *					indexes:
 * *					all are the same with number 2 
 * *					*) pages - the select drop down field *```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 * *		SAMPLE USAGE:
 * 
 * *				$offset = 4; // number of rows per page
 *					$sql = "SELECT * FROM users";
 *					$query = mysql_query($sql);
 *					$total_results = mysql_num_rows($query);
 *
 * *				$pg = new MyPagination();
 *					$result = $pg->number_series($offset, $total_results, $_GET['page']);
 *					
 * *				$sql1 = "SELECT * FROM users ".$result['limit'];
 *					$query1 = mysql_query($sql1);
 *					$page_results = mysql_num_rows($query1);
 * *
 *					while ($row = mysql_fetch_array($query1)) {
 *						echo $row['id_user'].' => '.$row['user_name'];
 *						echo '<br />';
 *					}
 *
 * *				echo $result['default']; 
**```````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````````
 */
class MyPagination 
{
	var $getvar, $page, $limit, $offset, $totalresults, $pagetotal, $nextlink, $prevlink, $nextp, $prevp, $pagealink, $record_start, $record_end;
	
	function MyPagination()
	{
		$this->page = '';
		$this->limit = '';
		$this->offset = '';
		$this->totalresults = '';
		$this->pagetotal = '';
		$this->nextp = '';
		$this->prevp = '';
		$this->pagealink = '';
		$this->getvar = 'page';
	}
	function setgetvar($newname) {
		$this->getvar = $newname;
	}
	function setpage($_page) {
		if($_page < 1)
			$_page = 1;
		$this->page = (int) floor($_page);
	}
	function setoffset($_offset) {
		$this->offset = (int) $_offset;
	}
	function settotalresults($total_results) {
		$this->totalresults = (int) $total_results;
		$this->setpagetotal();
	}
	function setpagetotal() {
		$this->pagetotal = (int) ceil($this->totalresults / $this->offset);
	}
	function setnext($next) {
		$this->nextp = $next;
	}
	function setprev($prev) {
		$this->prevp = $prev;
	}
	function setnextlink($_page) {
		$queryString = $this->GetQueryString();
		$this->nextlink = '<a href="'.$queryString.$_page.'" class="pagination">'.$this->nextp.'</a>';
	}
	function setprevlink($_page) {
		$queryString = $this->GetQueryString();
		$this->prevlink = '<a href="'.$queryString.$_page.'" class="pagination">'.$this->prevp.'</a>';
	}
	function setpagealink($_page) {
		$queryString = $this->GetQueryString();
		$this->pagealink = '<a href="'.$queryString.$_page.'" class="page">'.$_page.'</a>';
	}
	function setpagerangelink($_page, $range) {
		$queryString = $this->GetQueryString();
		$this->pagealink = '<a href="'.$queryString.$_page.'" class="page">'.$range.'</a>';
	}
	// Adopted Method
	function SetQueryStringVar($reqQueryStringVar){
    	$this->queryStringVar = $reqQueryStringVar;
    }
	// Adopted Method
   	function SetQueryString($reqQueryString){
    	$this->queryString = $reqQueryString;
    }
	// Adopted Method
	function GetQueryString(){
      	$pattern = array('/'.$this->queryStringVar.'=[^&]*&?/', '/&$/');
       	$replace = array('', '');
       	$queryString = preg_replace($pattern, $replace, $this->queryString);
       	$queryString = str_replace('&', '&amp;', $queryString);
        
       	if(!empty($queryString)){
        	$queryString.= '&amp;';
       	}
		return '?'.$queryString.$this->queryStringVar.'=';
   	}
	function getLimit() {
		if(!$this->page || $this->page == 1) {
			$this->limit = 0;
		} else {
			$this->limit = ($this->offset * $this->page) - $this->offset;
		}
		return 'LIMIT '.$this->limit.', '.$this->offset;
	}
	function getNextPage() {
		if($this->page >= $this->pagetotal) {
			$pg = $this->pagetotal;
		} else {
			$pg = $this->page + 1;
		}
		return $pg;
	}
	function getPrevPage() {
		if($this->page <= 1) {
			return $pg = 1;
		} else if($this->page > $this->pagetotal) {
			return $pg = $this->pagetotal;
		}
		return $pg = $this->page - 1;
	}
	function getNextPrevLinks() {
		if($this->page <= 1 && $this->page < $this->pagetotal) {// page=1 total=4
			$this->setnextlink($this->getNextPage());
			$this->prevlink = $this->prevp;
		} else if($this->page > 1 && $this->page < $this->pagetotal) { // page=2 total=4
			$this->setnextlink($this->getNextPage());
			$this->setprevlink($this->getPrevPage());
		} else if($this->page > 1 && $this->page == $this->pagetotal) { // page=2 total=2
			$this->nextlink = $this->nextp;
			$this->setprevlink($this->getPrevPage());
		} else if ($this->page > $this->pagetotal) { // page=10 total=8
			$this->nextlink = $this->nextp;
			$this->setprevlink($this->getPrevPage());
		}
	}
	function getRecordsCounter() {
		if($this->page <= 1) {
			$this->record_start = 1;
			$this->record_end = $this->record_start * $this->offset;
		} else {
			$this->record_start = ($this->page * $this->offset) - ($this->offset - 1);
			$this->record_end = ($this->page * $this->offset);
			if($this->record_end > $this->totalresults) {
				$this->record_end = $this->totalresults;
			}
		}
	}
	function page_nextprev($_offset, $total_results, $_page, $next='next', $prev='prev') {
		$this->SetQueryStringVar($this->getvar);
   		$this->SetQueryString($_SERVER['QUERY_STRING']);
		if(isset($_GET[$this->queryStringVar]) && is_numeric($_GET[$this->queryStringVar])){
   			$this->setpage($_GET[$this->queryStringVar]);
   		} 
		
		$this->setpage($_page);
		$this->setoffset($_offset);
		$this->settotalresults($total_results);  
		$this->setnext($next);
		$this->setprev($prev);
		
		$this->getNextPrevLinks();
		$this->getRecordsCounter();
		
		$default = $this->prevlink.' | '.$this->nextlink;
		
		$temp['limit'] =  $this->getLimit();
		$temp['prev'] =  $this->prevlink;
		$temp['next'] =  $this->nextlink;
		$temp['default'] =  $default; 
		$temp['begin_rec'] =  $this->record_start;
		$temp['end_rec'] =  $this->record_end;
		$temp['total_rec'] =  $this->totalresults; 
		return $temp;
	}
	function page_series($_offset, $total_results, $_page, $page_numbers = 5, $next='next', $prev='prev') {
		$this->SetQueryStringVar($this->getvar);
   		$this->SetQueryString($_SERVER['QUERY_STRING']);
		if(isset($_GET[$this->queryStringVar]) && is_numeric($_GET[$this->queryStringVar])){
   			$this->setpage($_GET[$this->queryStringVar]);
   		} 
		
		$this->setpage($_page);
		$this->setoffset($_offset);
		$this->settotalresults($total_results);  
		$this->setnext($next);
		$this->setprev($prev);
		
		$this->getNextPrevLinks();
		$this->getRecordsCounter();		
		
		if($this->page <= $page_numbers) { // page=2/1 page_numbers=2
			$start = 1;
			$end = $this->page + $page_numbers - 1;
		} else { 							// page=6 page_numbers=3
			$start = $this->page - $page_numbers;
			$end = $this->page + $page_numbers - 1;
		}
		/*if($this->pagetotal < ($page_numbers * 2)) {
			$end = $this->page + ($this->pagetotal - $this->page);
			$start = 1;
		}*/
		if($end > $this->pagetotal) {
			$end = $this->pagetotal;
		}
		
		$pages = '';
		while($start <= $end) {
			$number = $start;
			if($number == $this->page) {
				$this->pagealink = $this->page;
			} else {
				$this->setpagealink($number);
			}
			$pages .= $this->pagealink.' ';
			$start++;
		}
		
		$default = $this->prevlink.' | '.$pages.' | '.$this->nextlink;
		$temp['limit'] =  $this->getLimit();
		$temp['prev'] =  $this->prevlink;
		$temp['next'] =  $this->nextlink;
		$temp['pages'] = $pages;
		$temp['default'] = $default; 
		$temp['begin_rec'] =  $this->record_start;
		$temp['end_rec'] =  $this->record_end;
		$temp['total_rec'] =  $this->totalresults;
		return $temp;
	}
	// select field pagination
	function page_selectField($_offset, $total_results, $_page, $next='next', $prev='prev') {
		$this->SetQueryStringVar($this->getvar);
   		$this->SetQueryString($_SERVER['QUERY_STRING']);
		if(isset($_GET[$this->queryStringVar]) && is_numeric($_GET[$this->queryStringVar])){
   			$this->setpage($_GET[$this->queryStringVar]);
   		} 
		
		$this->setpage($_page);
		$this->setoffset($_offset);
		$this->settotalresults($total_results);  
		$this->setnext($next);
		$this->setprev($prev);
		
		$this->getNextPrevLinks();
		$this->getRecordsCounter();
		
		$html = '<form name="FrmPagination"><select name="selectPG" class="select_pagination" onChange="document.location.href=\'?'.$this->getvar.'=\'+document.FrmPagination.selectPG.options[document.FrmPagination.selectPG.selectedIndex].value">';
		$option = '';
		for($i=1; $i<=$this->pagetotal; $i++) {
			if($i == $this->page) {
				$option .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			} else {
				$option .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		
		$html .= $option.'</select></form>';
		
		$default = '<div class="prev">'.$this->prevlink.'</div><div class="sel_page">'.$html.'</div><div class="next">'.$this->nextlink.'</div>';
		$temp['limit'] =  $this->getLimit();
		$temp['prev'] =  $this->prevlink;
		$temp['next'] =  $this->nextlink;
		$temp['pages'] = $html;
		$temp['default'] = $default; 
		$temp['begin_rec'] =  $this->record_start;
		$temp['end_rec'] =  $this->record_end;
		$temp['total_rec'] =  $this->totalresults;
		return $temp;
	}
	function number_series($_offset, $total_results, $_page, $next='next', $prev='prev')
	{
		$this->SetQueryStringVar($this->getvar);
   		$this->SetQueryString($_SERVER['QUERY_STRING']);
		if(isset($_GET[$this->queryStringVar]) && is_numeric($_GET[$this->queryStringVar])){
   			$this->setpage($_GET[$this->queryStringVar]);
   		} 
		
		$this->setpage($_page);
		$this->setoffset($_offset);
		$this->settotalresults($total_results);  
		$this->setnext($next);
		$this->setprev($prev);
		
		$this->getNextPrevLinks();
		$this->getRecordsCounter();		
		
		$pages = $total_results / $_offset;
		$whole = floor($pages);
		$fraction = $pages - $whole;
		
		for($x=0;$x<=$whole;$x++) {
			$paging[$x] = ($_offset * $x) + 1;
		}
		
		$ul = '<ul>';
		$last = count($paging); 
		$x = 0;
		
		foreach($paging as $index => $value) {
			$x++;
			$start = $value;
			$end = ($value + $_offset) - 1;
			if($x==$last) 
				$end = $total_results;
			
			if($x == $this->page) {
				$this->pagealink = (($start==$end)? $start : $start.' - '.$end);
			} else {
				$this->setpagerangelink($x,(($start==$end)? $start : $start.' - '.$end));
			}
			
			$ul .= '<li>'.$this->pagealink.'</li>';
		}
		$ul .= '</ul>';
		$pages = $ul;
		
		$default = $pages;
		$temp['limit'] =  $this->getLimit();
		$temp['prev'] =  $this->prevlink;
		$temp['next'] =  $this->nextlink;
		$temp['pages'] = $pages;
		$temp['default'] = $default; 
		$temp['begin_rec'] =  $this->record_start;
		$temp['end_rec'] =  $this->record_end;
		$temp['total_rec'] =  $this->totalresults;
		return $temp;
	}

}


?>