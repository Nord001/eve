/**
 * EVE Online Information System Project
 * 
 * Title: c_AddOnloadEvent.js
 * 
 * Author: Andy Lo
 * Last Modified: 2011-22-06
 */

/**
 * Class: c_AddOnloadEvent
 * 
 * Manages a queue of event handler functions for the window.onload event.
 * 
 * (begin example)
 * 
 * // Create the c_AddOnloadEvent object.
 * onloadQueue = new c_AddOnloadEvent();
 * 
 * // Add the event handler functions to the queue.
 * onloadQueue.addEvent(handler1);
 * onloadQueue.addEvent(handler2);
 * 
 * // Call the event handlers in FIFO fashion.
 * onloadQueue.execute();
 * 
 * (end example)
 * 
 */
function c_AddOnloadEvent() {
    // Private:
    
    var m_existingHandler = window.onload;
    var m_handlerQueue = new Array();
    
    // Public:
    
    /**
     * Method: addHandler
     * 
     * Mutator.  Adds an event handler function to the queue.
     * 
     * Parameters:
     *     p_newHandler - Reference to the handler you want to add to the queue.
     * 
     * Returns:
     *     Nothing.
     */
    this.addHandler = function(p_newHandler) {
        try {
            if(typeof(p_newHandler) != "function") {
                throw "Event handler not a function.";
            } else {
                m_handlerQueue[m_handlerQueue.length] = p_newHandler;
            }
        } catch(e_error) {
            alert("Error adding onload event handler to queue: " + e_error);
        }
    }

    /**
     * Method: removeHandler
     * 
     * Removes the latest event handler from the queue.
     * 
     * Parameters:
     *     None.
     *     
     * Returns:
     *     Nothing.
     */
    this.removeHandler = function() {
        for(var i = m_handlerQueue.length - 1; i >= 0; i--) {
            if(typeof(m_handlerQueue[i]) == "function") {
                try {
                    m_handlerQueue[i] = null;
                } catch(e_error) {
                    alert("Error removing onload event handler from queue: " +
                        e_error);
                }
            }
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
                } catch(e_error) {
                    alert("Error executing onload event handler:" + e_error);
                }
            }
        }
    }
    
    /**
     * Method: clearHandlers
     * 
     * Clears all event handlers from the queue.
     * 
     * Parameters:
     *     None.
     *     
     * Returns:
     *     Nothing.
     */
    this.clearHandlers = function() {
        for(var i = 0; i < m_handlerQueue.length; i++) {
            m_handlerQueue[i] = null;
        }
    }
}