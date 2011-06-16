/*****************************************
 * EVE Online Information System Project *
 * Written By: Andy Lo                   *
 * Last Modified: 2011-13-01             *
 ****************************************/

function addLoadEvent(currentHandler)
{
  var existingHandler = window.onload;
  if(typeof existingHandler != "function")
  {
    window.onload = currentHandler;
  }
  else
  {
    window.onload = function()
    {
      if(existingHandler)
      {
        existingHandler();
      }
      currentHandler();
    }
  }
}

// This function creates and returns an XHR object.  No ActiveX implementation.
function createXmlHttpRequestObject()
{
  var httpRequest;

  httpRequest = new XMLHttpRequest();

  if(!httpRequest)
  {
    // Displays an alert if an XHR object could not be created.
    alert("Error creating XMLHttpRequest object.");
  }
  else
  {
    return httpRequest;
  }
}

function handleServerResponse(responseHandler)
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

      responseHandler();
  }
}