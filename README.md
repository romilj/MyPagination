# MyPagination

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
