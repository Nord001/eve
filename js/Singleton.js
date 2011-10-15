/**
 * Project: EVE Online Information System Project
 * 
 * Title: Singleton.js
 * 
 * Author: Andy Lo
 * E-Mail: andy.lo@gmx.com
 */

function Singleton() {
    // Private:
    
    // Public:
    
    Singleton.prototype.s_name = 'Singleton';
    Singleton.prototype.s_class = null;
    Singleton.prototype.s_instance = null;
    
    /**
     * Method: setClass
     * 
     * Mutator. Sets the class the factory is to manufacture.
     * 
     * Parameters:
     *     p_className - A reference to the function (that represents the class)
     * to be manufactured.
     *         
     * Returns:
     *     Nothing.
     *
     * See Also:
     *     <create>
     */
    this.setClass = function(p_className) {
        // If the class parameter isn't actually a function, generate an error.
        if(typeof(p_className) != "function") {
            alert("Singleton cannot be set to non-function reference.");
        } else {
            Singleton.prototype.s_class = p_className;
        }
        
        if(Singleton.prototype.s_class == p_className) {
            return true;
        } else {
            return false;
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
     *     A reference to the function (that represents the class) that the
     * factory is set to manufacture.
     * 
     */
    this.getClass = function() {
        return Singleton.prototype.s_class;
    }
    
    this.getInstance = function() {
        if(Singleton.prototype.s_instance === null) {
            Singleton.prototype.s_instance = new Singleton.prototype.s_class();
        }
        
        return Singleton.prototype.s_instance;
    }
}