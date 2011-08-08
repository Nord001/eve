/*****************************************
 * EVE Online Information System Project *
 * Written By: Andy Lo                   *
 ****************************************/

/* GLOBAL VARIABLES */
// Creates and stores the reference for an XHR object.
var httpRequest = createXmlHttpRequestObject();
// Stylesheet address.
var xsltFileUrl = "xsl/grid.xsl";
// Stores the locations of the XML data feeds.
var mapFormUrl = "map.php";
var feedGridUrl = "grid.php";
// Specifies the element where the grid will be displayed.
var displayDivId = "content-box";
var statusDivId = "statusDiv";
var editableId = null;
var stylesheetDoc;

// Initialization.
onloadQueue = new AddOnloadEvent();
onloadQueue.addEvent(loadStylesheet);
onloadQueue.addEvent(loadQueryForm);

function loadStylesheet() {
   if(window.XMLHttpRequest && window.XSLTProcessor && window.DOMParser) {
        httpRequest.open("POST", xsltFileUrl, false);
        httpRequest.setRequestHeader("Content-type",
          "application/x-www-form-urlencoded");
        httpRequest.send(null);

        // Creates the XSLT document.
        if(this.DOMParser) {
          var dp = new DOMParser();
          stylesheetDoc = dp.parseFromString(httpRequest.responseText,
            "text/xml");
        }
    } else {
        alert("Your browser doesn\'t support the necessary functionality.");
    }
}

function loadQueryForm()
{
  if(httpRequest && (httpRequest.readyState == 4
    || httpRequest.readyState == 0))
  {
    // Clear the display area when creating a new query form.
    var displayDiv = document.getElementById(displayDivId);
    displayDiv.innerHTML = '';

    var parameters = "action=MAP_DATABASE";

    // Sets up the connection.
    httpRequest.open("POST", mapFormUrl, true);
    httpRequest.setRequestHeader("Content-type",
      "application/x-www-form-urlencoded");
    httpRequest.onreadystatechange = function() {handleServerResponse("MAP");}
    httpRequest.send(parameters);
  }
}

// This function loads the next page of data available.
function loadGridPage(pageNo, categoryID, typeID)
{
  // Disables editing of the grid while loading.
  editableId = false;

  if(httpRequest && (httpRequest.readyState == 4 || httpRequest.readyState == 0))
  {
    var parameters = "action=FEED_GRID_PAGE&page=" + pageNo;

    if(categoryID)
    {
      parameters += "&categoryID=" + categoryID;
    }
    if(typeID)
    {
      parameters += "&typeID=" + typeID;
    }

    // Sets up the connection.
    httpRequest.open("POST", feedGridUrl, true);
    httpRequest.setRequestHeader("Content-type",
      "application/x-www-form-urlencoded");
    httpRequest.onreadystatechange = function() {handleServerResponse("GRID");}
    httpRequest.send(parameters);
  }
}

function handleServerResponse(responseType)
{
  if(httpRequest.readyState == 4 && httpRequest.status == 200)
  {
      // Reads server response.
      textResponse = httpRequest.responseText;

      // Error checking code.  Generates an error message if either an error or
      // no response is detected.
      if(textResponse.indexOf("ERRNO") >= 0
         || textResponse.indexOf("error") >= 0
         || textResponse.length == 0)
      {
        alert(textResponse.length == 0 ? "Server error." : textResponse);
        return;
      }
      // If no error is detected, then the XML grid is retrieved.
      xmlResponse = httpRequest.responseXML;

      if(window.XMLHttpRequest && window.XSLTProcessor && window.DOMParser)
      {
        // Loads the query selection form.
        if(responseType == "MAP")
        {
          loadForm(xmlResponse);
        }
        // Loads the results of the query in a table grid format.
        else if(responseType == "GRID")
        {
          loadGrid(xmlResponse);
        }
      }
      else
      {
        alert("Error reading server response.");
      }
  }
}

function loadForm(xmlResponse)
{
      // Grabs the categories and types from the XML document.
      xData = xmlResponse.documentElement
      xMap = xData.childNodes[1];
      xCategories = xMap.childNodes[0];
      xTypes = xMap.childNodes[1];

      // Creates an array to organize the XML category data - primarily for the
      // dynamic drop down lists.
      const categoryCount =
        xCategories.getElementsByTagName("item_category").length;

      // Creates and populates an array to hold the item category list.
      var arrCategories = new Array();
      for(var i = 0; i < categoryCount; i++)
      {
        arrCategories[i] = new Array(2);
        xCategory = xCategories.childNodes[i];
        arrCategories[i][0] = xCategory.childNodes[0].childNodes[0].nodeValue;
        arrCategories[i][1] = xCategory.childNodes[1].childNodes[0].nodeValue;
      }

      // Creates an array to organize the XML type data - primarily for the
      // dynamic drop down lists.
      const typeCount = xTypes.getElementsByTagName("item_type").length;

      // Creates and populates an array to hold the item types list.
      var arrTypes = new Array();
      for(i = 0; i < typeCount; i++)
      {
        arrTypes[i] = new Array(3);
        xType = xTypes.childNodes[i];
        arrTypes[i][0] = xType.childNodes[0].childNodes[0].nodeValue;
        arrTypes[i][1] = xType.childNodes[1].childNodes[0].nodeValue;
        arrTypes[i][2] = xType.childNodes[2].childNodes[0].nodeValue;
      }

      // Outputs form table to page.
      var formDiv = document.getElementById(displayDivId);
      // Form
      elForm = document.createElement("form");
      elForm.id = "queryForm";
      formDiv.appendChild(elForm);
      elTable = document.createElement("table");
      elForm.appendChild(elTable);
      elRow1 = document.createElement("tr");
      elTable.appendChild(elRow1);
      // Category select header.
      elH1 = document.createElement("th");
      elH1.id = "categoryHeader";
      elRow1.appendChild(elH1);
      h1 = document.createTextNode("Item Category");
      elH1.appendChild(h1);
      // Type select header.
      elH2 = document.createElement("th");
      elH2.id = "typeHeader";
      elRow1.appendChild(elH2);
      h2 = document.createTextNode("Item Type");
      elH2.appendChild(h2);
      elRow2 = document.createElement("tr");
      elTable.appendChild(elRow2);
      // Category select list.
      elRow2Col1 = document.createElement("td");
      elRow2Col1.id = "categoryList";
      elRow2.appendChild(elRow2Col1);
      // Type select list.
      elRow2Col2 = document.createElement("td");
      elRow2Col2.id = "typeList";
      elRow2.appendChild(elRow2Col2);
      // Button to submit query to database.
      elSubmit = document.createElement("input");
      elSubmit.type = "button";
      elSubmit.id = "querySubmit";
      elSubmit.value = "Submit Query";
      elSubmit.onclick = function() {loadGridPage(1,
        elCategorySelect.options[elCategorySelect.selectedIndex].id,
        elTypeSelect.options[elTypeSelect.selectedIndex].id);}
      elForm.appendChild(elSubmit);

      // Note-to-self: Replace dynamic selects with CSS styled dropdowns.

      // Creates the item category list.
      elCategorySelect = document.createElement("select");
      elCategorySelect.name = "categoryID";
      elCategorySelect.id = "categoryID";
      elCategorySelect.size = "1";
      elCategorySelect.onchange = elCategorySelect.onkeyup =
        elCategorySelect.onkeydown = function() {loadTypes(arrTypes,
        elCategorySelect.options[elCategorySelect.selectedIndex].id);}
      elRow2Col1.appendChild(elCategorySelect);

      // Populates the item category list.
      for(i = 0; i < categoryCount; i++)
      {
        elOption = document.createElement("option");
        elOption.id = arrCategories[i][0];
        elOption.value = arrCategories[i][1];
        elOption.text = arrCategories[i][1];
        elCategorySelect.options.add(elOption);
      }

      // Outputs the item type list.
      var elRow2Col2 = document.getElementById("typeList");
      elTypeSelect = document.createElement("select");
      elTypeSelect.name = "typeID";
      elTypeSelect.id = "typeID";
      elTypeSelect.size = "1";
      elRow2Col2.appendChild(elTypeSelect);
      
      loadTypes(arrTypes,
        elCategorySelect.options[elCategorySelect.selectedIndex].id);
}

function loadTypes(arrTypes, selectedCategoryID)
{
  // Get the DOM element object of the item type drop down list.
  elTypeSelect = document.getElementById("typeID");

  // Removes all options from a drop down list - primarily used for dynamically
  // changing selectable options.
  const typeCount = xTypes.getElementsByTagName("item_type").length;

  for(var i = elTypeSelect.options.length - 1; i >= 0; i--)
  {
    elTypeSelect.remove(i);
  }

  // Populates the item types list.
  for(i = 0; i < typeCount; i++)
  {
    // List item type only if it's from the selected category.
    if(arrTypes[i][0] == selectedCategoryID)
    {
        elOption = document.createElement("option");
        elOption.id = arrTypes[i][1];
        elOption.value = arrTypes[i][2];
        elOption.text = arrTypes[i][2];
        elTypeSelect.options.add(elOption);
    }
  }
}

// This function handles status changes in the HTTP request.
function loadGrid(xmlResponse)
{
    if(window.XMLHttpRequest && window.XSLTProcessor && window.DOMParser)
    {
      // Loads the XSLT document.
      var xsltProcessor = new XSLTProcessor();
      xsltProcessor.importStylesheet(stylesheetDoc);
      // Generates the HTML for the new page.
      page = xsltProcessor.transformToFragment(xmlResponse, document);
      // Displays the new grid page.
      var gridDiv = document.getElementById(displayDivId);
      gridDiv.innerHTML = '';
      gridDiv.appendChild(page);
    }
    else
    {
      alert("Error reading server response.");
    }
}

// This function manages the dynamic editing of table content.
function editId(id, editMode)
{
  var itemRow = document.getElementById(id).cells;

  if(editMode)
  {
    if(editableId)
    {
      editId(editableId, false);
    }

    // Saves original data before editing.
    save(id);

    // Creates text fields in order to edit table values.
    itemRow[1].innerHTML = "<input class='edit' type='text' name='item_name' " +
      "value='" + itemRow[1].innerHTML + "'>";
    itemRow[2].innerHTML = "<input class='edit' type='text' name='item_price' "
      + "value='" + itemRow[2].innerHTML + "'>";
    // Creates links to either commit or cancel changes.
    itemRow[3].innerHTML = '<a href="#" ' +
      "onclick='updateRow(document.forms.grid_form_id, " + id + ")'><u>Update" +
      "</u></a><br /><a href='#' onclick='editId(" + id + ", false)'><u>Cancel"
      + "</u></a>";

    editableId = id;
  }
  else
  {
    // These reference the above input tags.
    itemRow[1].innerHTML = document.forms.grid_form_id.item_name.value;
    itemRow[2].innerHTML = document.forms.grid_form_id.item_price.value;
    itemRow[3].innerHTML = "<a href='#' onclick='editId(" + id + ", true)'>" +
      "<u>Edit</u></a>";

    editableId = null;
  }
}

// Temporarily saves original data when editing row.
function save(id)
{
  // Retrieve table row.
  var tr = document.getElementById(id).cells;

  // Place row data in temporary storage.
  tempRow = new Array(tr.length);
  
  for(var i = 0; i < tr.length; i++)
  {
    tempRow[i] = tr[i].innerHTML;
  }
}

// Cancels row edit and restores original data.
function undo(id)
{
  var tr = document.getElementById(id).cells;

  for(var i = 0; i < tempRow.length; i++)
  {
    tr[i].innerHTML = tempRow[i];
  }

  editableId = null;
}

// This function simply sends the query to submit changes to the database from
// any table edits.
function updateRow(grid, itemId)
{
  if(httpRequest && (httpRequest.readyState == 4 || httpRequest.readyState == 0))
  {
    var parameters = "action=UPDATE_ROW&item_id=" + itemId + "&" +
      createUpdateUrl(grid);
    httpRequest.open("POST", feedGridUrl, true);
    httpRequest.setRequestHeader("Content-type",
      "application/x-www-form-urlencoded");
    httpRequest.onreadystatechange = handleUpdatingRow;
    httpRequest.send(parameters);
  }
}

function handleUpdatingRow()
{
  if(httpRequest.readyState == 4)
  {
    if(httpRequest.status == 200)
    {
      response = httpRequest.responseText;

      if(response.indexOf("ERRNO") >= 0
        || response.indexOf("error") >= 0
        || response.length == 0)
      {
        alert(response.length == 0 ? "Server error." : response);
      }
      else
      {
        editId(editableId, false);
      }
    }
    else
    {
      undo(editableId);
      alert("Error updating row.");
    }
  }
}

function createUpdateUrl(grid)
{
  var str = "";

  for(var i = 0; i < grid.elements.length; i++)
  {
    switch(grid.elements[i].type)
    {
      case "text":
      case "textarea":
        str += grid.elements[i].name + "=" + escape(grid.elements[i].value) +
          "&";
        break;
      case "checkbox":
        str += grid.elements[i].name + "=" + (grid.elements[i].checked ? 1 : 0)
          + "&";
        break;
    }
  }

  return str;
}