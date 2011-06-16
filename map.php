<?php
# EVE Online Information System Project
# Written By: Andy Lo

require_once('authenticate.php');
require_once('sanitize.php');

/* CLASS IMPLEMENTATION */
# This class creates an XML map of the database structure.
class Map
{
  private $mysqli;
  private $map;

  # Constructor
  function __construct()
  {
    $this->mysqli = new mysqli('localhost',
                               $_SESSION['username'],
                               $_SESSION['password'],
                               $_SESSION['database']);
  }

  # Destructor
  function __destruct()
  {
    $this->mysqli->close();
  }

  public function mapDatabase()
  {
    $_SESSION['itemCategory'] = array();

    # Grabs item category data and records it into XML format.
    $categoryQuery = 'SELECT category_ID, category_name FROM item_category';

    if($result = $this->mysqli->query($categoryQuery))
    {
      $this->map .= '<item_categories>';

      while($row = $result->fetch_assoc())
      {
        $this->map .= '<item_category>';
        foreach($row as $name => $value)
        {
          $_SESSION['itemCategory'][$name] = $value;

          $this->map .= '<' . $name . '>' . htmlentities($value)
            . '</' . $name . '>';
        }
        $this->map .= '</item_category>';
      }

      $this->map .= '</item_categories>';

      $result->close();
    }

    # Grabs item type data and records it into XML format.
    $typeQuery = 'SELECT category_ID, type_ID, type_name FROM item_type';

    if($result = $this->mysqli->query($typeQuery))
    {
      $this->map .= '<item_types>';

      while($row = $result->fetch_assoc())
      {
        $this->map .= '<item_type>';
        foreach($row as $name => $value)
        {
          $_SESSION['itemType'][$name] = $value;

          $this->map .= '<' . $name . '>' . htmlentities($value) . '</' .
            $name . '>';
        }
        $this->map .= '</item_type>';
      }

      $this->map .= '</item_types>';
      $result->close();
    }
  }
  
  public function getMapXML()
  {
    return '<map>' . $this->map . '</map>';
  }
}
/* END OF CLASS IMPLEMENTATION */

/* MAIN BODY */
# If no action is sent to the server, an error message is generated.
if(!isset($_POST['action']))
{
  echo 'Server error: Missing client command.';
  exit;
}
else
{
  $action = sanitize($_POST['action']);
  
  if(isset($_SESSION['recordCount']))
  {
    unset($_SESSION['recordCount']);
  }
}

# Instantiates Map object.
$obMap = new Map;

# Maps the database given the correct action input.
if($action == 'MAP_DATABASE')
{
  $obMap->mapDatabase();
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
echo $obMap->getMapXML();
echo '</data>';
/* END OF MAIN BODY */
?>