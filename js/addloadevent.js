/**
 * EVE Online Information System Project
 * 
 * Title: addloadevent.js
 * 
 * Author: Andy Lo
 * Last Modified: 2011-22-06
 */

/**
 * Class: AddOnloadEvent
 * 
 * 
 * 
 * Parameters:
 *     currentHandler
 * 
 * Returns:
 *     Nothing.
 */
function c_AddOnloadEvent() {
    // Private:
    var m_existingHandler = window.onload;
    var m_handlerQueue = new Array();
    
    // Public:
    
    /**
     * Method: addEvent
     * 
     * Parameters:
     *     p_newHandler - Reference to the handler you want to add to the queue.
     * 
     * Returns:
     *     Nothing.
     */
    this.addEvent = function(p_newHandler) {
        try {
            if(typeof(p_newHandler) != "function") {
                error = "Event handler not a function.";
                throw error;
            } else {
                m_handlerQueue[m_handlerQueue.length] = p_newHandler;
            }
        } catch(error) {
            alert("Error adding onload event handler to queue: " + error);
        }
    }
    
    /**
     * Method: execute
     * 
     * Executes all event handlers in the queue.
     * 
     * Parameters:
     *     None.
     *     
     * Returns:
     *     Nothing.
     */
    this.execute = function() {
        window.onload = function() {
            for(var i = 0; i < m_handlerQueue.length; i++) {
                try {
                    m_handlerQueue[i]();
                } catch(error) {
                    alert("Error executing onload event handler:" + error);
                }
            }
        }
    }

    /**
     * Method: clearEvents
     * 
     * Clears all event handlers from the queue.
     * 
     * Parameters:
     *     None.
     *     
     * Returns:
     *     Nothing.
     */
    this.clearEvents = function() {
        for(var i = 0; i < m_handlerQueue.length; i++) {
            m_handlerQueue[i] = null;
        }
    }

}