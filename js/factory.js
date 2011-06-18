/*****************************************
 * EVE Online Information System Project *
 * Written By: Andy Lo                   *
 * Last Modified: 2011-18-06             *
 ****************************************/

// Class Factory
function Factory() {
    
    this.create = function(className) {
        return new className();
    }
}