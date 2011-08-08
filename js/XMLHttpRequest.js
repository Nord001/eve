/**
 * EVE Online Information System Project
 * 
 * Title: XMLHttpRequest.js
 * 
 * Author: Andy Lo
 */

/**
 * Class: XMLHttpRequest
 * 
 * Manages HTTP requests asynchronously.
 * 
 * (begin example)
 * 
 * // Create the XMLHttpRequest object.
 * xhrobject = new XMLHttpRequest();
 * 
 * (end example)
 * 
 */
function XMLHttpRequest() {

    // Private:
    var sendURL;
    var sendMethod; // (GET or POST)
    var sendParameters;

    // Public:
    
    XMLHttpRequest.prototype.s_name = 'XMLHttpRequest';
    
    // Accessor Methods
    this.getSendURL = function() {
        return sendURL;
    }
    
    this.getSendMethod = function() {
        return sendMethod;
    }
    
    this.getSendParameters = function() {
        return sendParameters;
    }

    // Mutator Methods
    this.setSendURL = function(url) {
        sendURL = url;
    }

    this.setSendMethod = function(method) {
        if(method != "GET" && method != "POST") {
            alert("Invalid send method. Use either GET or POST.");
        }

        sendMethod = method;
    }

    this.setSendParameters = function(parameters) {
        sendParameters = parameters;
    }

    // Method setRequest
    this.setRequest = function() {
        if(this.readyState == 4 || this.readyState == 0) {
            /**
             * THIS CODE NEEDS TO BE MOVED!
             * It is saved here for preservational purposes.
             * Clear the display area when creating a new query form.
             * var displayDiv = document.getElementById(displayDivId);
             * displayDiv.innerHTML = '';
             */

            // Sets up the connection.
            this.open(sendMethod, sendURL, true);
            this.setRequestHeader("Content-type",
                "application/x-www-form-urlencoded");
            this.onreadystatechange = handleServerResponse;
        }
    }

    // Method sendRequest
    this.sendRequest = function() {
        this.send(sendParameters);
    }

    // Method handleServerResponse
    this.handleServerResponse = function() {
        if(this.readyState == 4 && this.status == 200) {
            // Reads server text response.
            var textResponse = this.responseText;

            // Error checking code. Generates an error message if either an
            // error or no response is detected.
            if(textResponse.indexOf("ERRNO") >= 0
                || textResponse.indexOf("error") >= 0
                || textResponse.length == 0) {
                alert(textResponse.length == 0 ? "Server error." : textResponse);
                return;
            }

            var xmlResponse = this.responseXML;

            // If no errors are detected, then the XML response is retrieved.
            return xmlResponse;
        } else {
            return null;
        }
    }
}