<?php
# EVE Online Information System Project
# Written By: Andy Lo

require_once('authenticate.php');
require_once('sanitize.php');

define('ROWS_PER_VIEW', 5);

/* CLASS IMPLEMENTATION */
# This class manages XML data for the XSLT transformations in the AJAX grid.
class Grid
{
  private $mTotalPages;
  private $mItemCount;
  private $mReturnedPage;
  private $mysqli;
  private $mQuery;
  private $grid;

  # Constructor
  function __construct($constructedQuery)
  {
    $this->mysqli = new mysqli('localhost',
                               $_SESSION['username'],
                               $_SESSION['password'],
                               $_SESSION['database']);

    $this->mysqli->real_escape_string($constructedQuery);
    
    $this->mQuery = $constructedQuery;
    $this->mItemCount = $this->countAllRecords();
  }

  # Destructor
  function __destruct()
  {
    $this->mysqli->close();
  }

  # Private:
  private function countAllRecords()
  {
    # If the item count does not already exist, then a query will be generated
    # to retrieve the item count from the database.
    if(!isset($_SESSION['recordCount']))
    {
      $countQuery = 'SELECT COUNT(*) FROM (' . $this->mQuery . ') AS count';

      if($result = $this->mysqli->query($countQuery))
      {
        $row = $result->fetch_row();
        $_SESSION['recordCount'] = $row[0];
        $result->close();
      }
      else
      {
        echo 'Invalid query: ' . $this->mysqli->error;
      }
    }

    return $_SESSION['recordCount'];
  }

  private function createSubpageQuery($subpageQuery, $pageNo)
  {
    # If there aren't enough items to fill a page, set both the page number and
    # the total number of pages to one.
    if($this->mItemCount <= ROWS_PER_VIEW)
    {
      $pageNo = 1;
      $this->mTotalPages = 1;
    }
    # Otherwise, calculate the total number of pages required
    else
    {
      $this->mTotalPages = ceil($this->mItemCount / ROWS_PER_VIEW);
      $startIndex = ($pageNo - 1) * ROWS_PER_VIEW;
      $subpageQuery .= ' LIMIT ' . $startIndex . ' , ' . ROWS_PER_VIEW;
    }

    $this->mReturnedPage = $pageNo;
    return $subpageQuery;
  }

  # Public:
  public function readPage($page)
  {
    $readQuery = $this->createSubpageQuery($this->mQuery, $page);

    if($result = $this->mysqli->query($readQuery))
    {
      while($row = $result->fetch_assoc())
      {
        $this->grid .= '<item>';
        foreach($row as $name => $value)
        {
          $this->grid .= '<' . $name . '>' . htmlentities($value) . '</' .
            $name . '>';
        }
        $this->grid .= '</item>';
      }

      $result->close();
    }
  }

  public function updateRecord($item_ID, $item_name, $item_price)
  {
    $item_ID = $this->mysqli->real_escape_string($item_ID);
    $item_name = $this->mysqli->real_escape_string($item_name);
    $item_price = $this->mysqli->real_escape_string($item_price);

    $updateQuery = 'UPDATE item SET item_name = "' . $item_name .
      '", ' . 'item_price = "' . $item_price . '" WHERE item_ID = ' .
      $item_ID;

    $this->mysqli->query($updateQuery);
  }

  # Accessor Functions:
  public function getXML($category_ID, $type_ID)
  {
    $previous_page = ($this->mReturnedPage == 1) ? 0 : $this->mReturnedPage - 1;
    $next_page = ($this->mTotalPages == $this->mReturnedPage) ? 0 :
      $this->mReturnedPage + 1;
    $first_item = ROWS_PER_VIEW * ($this->mReturnedPage - 1) + 1;
    $last_item = ROWS_PER_VIEW * $this->mReturnedPage;

    return '<parameters>' .
           '<returned_page>' . $this->mReturnedPage . '</returned_page>' .
           '<total_pages>' . $this->mTotalPages . '</total_pages>' .
           '<first_item>' . $first_item . '</first_item>' .
           '<last_item>' . $last_item . '</last_item>' .
           '<item_count>' . $this->mItemCount . '</item_count>' .
           '<previous_page>' . $previous_page . '</previous_page>' .
           '<next_page>' . $next_page . '</next_page>' .
           '<query_category>' . $category_ID . '</query_category>' .
           '<query_type>' . $type_ID . '</query_type>' .
           '</parameters>' .
           '<grid>' . $this->grid . '</grid>';
  }
}
/* END OF CLASS IMPLEMENTATION */

/* MAIN BODY */
// If action is missing, generate error.
if(!isset($_POST['action']))
{
  echo 'Server error: Missing client command.';
  echo 'Action: ' . $_POST['action'] . '\n';
  exit;
}
else
{
  $action = sanitize($_POST['action']);

  # Set up query which is passed to the database querying object.
  $constructedQuery = 'SELECT item_ID, item_name, item_price FROM item';
  if(isset($_POST['categoryID']))
  {
    $category_ID = sanitize($_POST['categoryID']);
    $constructedQuery .= ' WHERE category_id = ' . $category_ID;
  }
  if(isset($_POST['typeID']))
  {
    $type_ID = sanitize($_POST['typeID']);
    $constructedQuery .= ' AND type_ID = ' . $type_ID;
  }
}

# Instantiates Grid object.
$grid = new Grid(sanitize($constructedQuery));

# Reads data into the grid.
if($action == 'FEED_GRID_PAGE')
{
  $page = $_POST['page'];
  $grid->readPage($page);
}
# Updates given item.
else if ($action == 'UPDATE_ROW')
{
  $item_ID = sanitize($_POST['item_id']);
  $item_name = sanitize($_POST['item_name']);
  $item_price = sanitize($_POST['item_price']);
  $grid->updateRecord($item_ID, $item_name, $item_price);
}
# Generates an error message if the action is invalid.
else
{
  echo 'Server error: Unrecognized client command.';
}

if(ob_get_length())
{
  ob_clean();
}

# Displays results.
header('Expires: Fri, 25 Dec 1980 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pramga: no-cache');
header('Content-Type: text/xml');

echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
echo '<data>';
echo '<action>' . $action . '</action>';
echo $grid->getXML($category_ID, $type_ID);
echo '</data>';
/* END OF MAIN BODY */
?>