/**
 * EVE Online Information System Project
 * 
 * Title: factory.js
 * 
 * Author: Andy Lo
 * Last Modified: 2011-22-06
 */

/**
 * Class: Factory
 * 
 * Used to abstract the instantiation of classes.
 * 
 * (begin example)
 * 
 * factoryMultiply = new Factory();
 * factoryMultiply.setClass("Multiply");
 * MathOperationObject = factoryMultiply.create();
 * 
 * If you wanted to change the type of class for MathOperationObject as well as
 * modify all its references at once, simply set the factory to another class.
 * 
 * (end example)
 */
function c_Factory() {
    // Private:
    
    var m_productClass = null;
    
    // Public:
    
    /**
     * Method: setClass
     * 
     * Mutator. Sets the class the factory is to manufacture.
     * 
     * Parameters:
     *     className - A reference to the function that represents the class to
     * be manufactured.
     *         
     * Returns:
     *     Nothing.
     *
     * See Also:
     *     <create>
     */
    this.setClass = function(p_className) {
        /* If the class parameter isn't actually a function, generate an error.
         * This prevents the factory from producing something strange. */
        if(typeof(p_className) != "function") {
            alert("Factory cannot be set to invalid class.");
        } else {
            m_productClass = p_className;
        }
    }

    /**
     * Method: getClass
     * 
     * Accessor. Gets the class the factory is to manufacture.
     * 
     * Parameters:
     *     None.
     * 
     * Returns:
     *     The reference to the function that represents the class that the
     * factory is set to manufacture.
     * 
     */
    this.getClass = function() {
        return m_productClass;
    }
    
    /**
     * Method: create
     * 
     * Instantiates the class the factory has been set to manufacture and then
     * returns a reference to the created instance.
     *     
     * Returns:
     *     instance - A reference to the created instance.
     *     
     * See Also:
     *     <setClass>
     */
    this.create = function() {
        try {
            l_instance = new m_productClass();
        } catch(error) {
            alert("Error instantiating class: " + error);
        }

        return l_instance;
    }
}